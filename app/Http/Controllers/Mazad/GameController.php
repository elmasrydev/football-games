<?php

namespace App\Http\Controllers\Mazad;

use App\Http\Controllers\Controller;
use App\Events\Mazad\GameFinished;
use App\Events\Mazad\GameStarting;
use App\Events\Mazad\QuestionEnded;
use App\Events\Mazad\QuestionStarted;
use App\Events\Mazad\ScoreUpdate;
use App\Jobs\Mazad\EndQuestionJob;
use App\Jobs\Mazad\StartQuestionJob;
use App\Models\MazadAnswer;
use App\Models\MazadRoom;
use App\Services\Mazad\AnswerMatcher;
use App\Services\Mazad\ScoringService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function __construct(
        private AnswerMatcher $answerMatcher,
        private ScoringService $scoringService,
    ) {}

    /**
     * Owner starts the game.
     */
    public function start(string $locale, string $code): JsonResponse
    {
        $room = MazadRoom::where('code', $code)->firstOrFail();

        if ($room->owner_id !== Auth::id()) {
            return response()->json(['message' => 'Only the room owner can start the game'], 403);
        }

        if (!$room->canStart()) {
            return response()->json([
                'message' => "Need at least {$room->min_players_to_start} players to start",
            ], 422);
        }

        // Mark room as starting
        $room->update([
            'status' => 'starting',
            'started_at' => now(),
        ]);

        // Broadcast countdown
        broadcast(new GameStarting($room, 3))->toOthers();

        // Schedule the first question to start after 3 seconds
        StartQuestionJob::dispatch($room->id, 0)->delay(now()->addSeconds(3));

        return response()->json(['message' => 'Game starting!']);
    }

    /**
     * Submit an answer during an active question.
     */
    public function answer(Request $request, string $locale, string $code): JsonResponse
    {
        $validated = $request->validate([
            'answer' => ['required', 'string', 'max:200'],
        ]);

        $room = MazadRoom::where('code', $code)->firstOrFail();
        $player = $room->getPlayer(Auth::id());

        if (!$player) {
            return response()->json(['message' => 'You are not in this room'], 422);
        }

        if ($room->status !== 'in_progress') {
            return response()->json(['message' => 'Game is not in progress'], 422);
        }

        $roomQuestion = $room->currentRoomQuestion();
        if (!$roomQuestion || !$roomQuestion->isActive()) {
            return response()->json(['message' => 'No active question'], 422);
        }

        $question = $roomQuestion->question;
        $answerText = trim($validated['answer']);

        // Check if this player already submitted this exact answer (normalized) for this question
        $normalizedInput = $this->answerMatcher->normalize($answerText);
        $existingAnswer = MazadAnswer::where('room_question_id', $roomQuestion->id)
            ->where('player_id', $player->id)
            ->get()
            ->first(function ($a) use ($normalizedInput) {
                return $this->answerMatcher->normalize($a->answer_text) === $normalizedInput;
            });

        if ($existingAnswer) {
            return response()->json([
                'status' => 'duplicate',
                'message' => 'Already submitted',
            ]);
        }

        // Match against accepted answers
        $matchedAnswer = $this->answerMatcher->match($answerText, $question->accepted_answers);
        $isCorrect = $matchedAnswer !== null;

        // Check if this correct answer was already submitted by this player (different spelling)
        if ($isCorrect) {
            $alreadyMatchedThis = MazadAnswer::where('room_question_id', $roomQuestion->id)
                ->where('player_id', $player->id)
                ->where('matched_answer', $matchedAnswer)
                ->exists();

            if ($alreadyMatchedThis) {
                // Same canonical answer, different spelling — treat as duplicate
                MazadAnswer::create([
                    'room_question_id' => $roomQuestion->id,
                    'player_id' => $player->id,
                    'answer_text' => $answerText,
                    'matched_answer' => $matchedAnswer,
                    'is_correct' => false, // Don't double-count
                    'submitted_at' => now(),
                ]);

                return response()->json([
                    'status' => 'duplicate',
                    'message' => 'Already submitted (different spelling)',
                ]);
            }
        }

        // Save the answer
        MazadAnswer::create([
            'room_question_id' => $roomQuestion->id,
            'player_id' => $player->id,
            'answer_text' => $answerText,
            'matched_answer' => $matchedAnswer,
            'is_correct' => $isCorrect,
            'submitted_at' => now(),
        ]);

        if ($isCorrect) {
            $correctCount = $player->correctCountForQuestion($roomQuestion->id);

            // Broadcast score update to the room
            broadcast(new ScoreUpdate($room, $player->id, $correctCount))->toOthers();
        }

        return response()->json([
            'status' => $isCorrect ? 'correct' : 'wrong',
            'correct_count' => $isCorrect
                ? $player->correctCountForQuestion($roomQuestion->id)
                : null,
        ]);
    }

    /**
     * Get final results for a finished game.
     */
    public function results(string $locale, string $code): JsonResponse
    {
        $room = MazadRoom::where('code', $code)->firstOrFail();

        if (!in_array($room->status, ['finished', 'in_progress'])) {
            return response()->json(['message' => 'Game has not finished yet'], 422);
        }

        $leaderboard = $this->scoringService->buildLeaderboard($room);

        // Get per-question breakdown
        $rounds = $room->roomQuestions()->with('question')->get()->map(function ($rq) use ($room) {
            $playerScores = $room->players->map(function ($player) use ($rq) {
                return [
                    'player_id' => $player->id,
                    'name' => $player->user->name,
                    'correct_count' => $player->correctCountForQuestion($rq->id),
                    'answers' => $player->answers()
                        ->where('room_question_id', $rq->id)
                        ->where('is_correct', true)
                        ->pluck('answer_text'),
                ];
            });

            return [
                'question_order' => $rq->question_order,
                'question_text' => $rq->question->text,
                'question_text_ar' => $rq->question->text_ar,
                'player_scores' => $playerScores,
            ];
        });

        return response()->json([
            'leaderboard' => $leaderboard,
            'rounds' => $rounds,
            'mode' => $room->mode,
        ]);
    }
}
