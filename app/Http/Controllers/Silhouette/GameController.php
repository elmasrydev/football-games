<?php

namespace App\Http\Controllers\Silhouette;

use App\Http\Controllers\Controller;
use App\Events\Silhouette\GameFinished;
use App\Events\Silhouette\GameStarting;
use App\Events\Silhouette\QuestionEnded;
use App\Events\Silhouette\QuestionStarted;
use App\Events\Silhouette\ScoreUpdate;
use App\Jobs\Silhouette\EndQuestionJob;
use App\Jobs\Silhouette\StartQuestionJob;
use App\Models\SilhouetteAnswer;
use App\Models\SilhouetteRoom;
use App\Models\Challenge;
use App\Services\Silhouette\ScoringService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function __construct(
        private ScoringService $scoringService,
    ) {}

    public function start(string $locale, string $code): JsonResponse
    {
        $room = SilhouetteRoom::where('code', $code)->firstOrFail();

        if ((int)$room->owner_id !== (int)Auth::id()) {
            return response()->json(['message' => 'Only the room owner can start the game'], 403);
        }

        if (!$room->canStart()) {
            return response()->json([
                'message' => "Need at least {$room->min_players_to_start} players to start",
            ], 422);
        }

        $room->update([
            'status' => 'starting',
            'started_at' => now(),
        ]);

        broadcast(new GameStarting($room, 3))->toOthers();

        StartQuestionJob::dispatch($room->id, 0)->delay(now()->addSeconds(3));

        return response()->json(['message' => 'Game starting!']);
    }

    public function answer(Request $request, string $locale, string $code): JsonResponse
    {
        $validated = $request->validate([
            'answer' => ['required', 'string', 'max:200'],
        ]);

        $room = SilhouetteRoom::where('code', $code)->firstOrFail();
        $player = $room->getPlayer(Auth::id());

        if (!$player) {
            return response()->json(['message' => 'You are not in this room'], 422);
        }

        if ($room->status !== 'in_progress') {
            return response()->json(['message' => 'Game is not in progress'], 422);
        }

        $roomQuestion = $room->currentRoomQuestion();
        if (!$roomQuestion) {
            return response()->json(['message' => 'No active question'], 422);
        }

        // Check if there is already a winning correct answer for this round
        $hasWinner = SilhouetteAnswer::where('room_question_id', $roomQuestion->id)
            ->where('is_winning', true)
            ->exists();

        if ($hasWinner) {
            return response()->json([
                'status' => 'too_late',
                'message' => 'Someone already answered correctly!',
            ]);
        }

        if (!$roomQuestion->isActive()) {
            return response()->json(['message' => 'No active question'], 422);
        }

        $challenge = $roomQuestion->challenge;
        $answerText = trim($validated['answer']);

        // Check if this player already submitted this exact answer (normalized) for this question
        $normalizedInput = $this->normalize($answerText);
        $existingAnswer = SilhouetteAnswer::where('room_question_id', $roomQuestion->id)
            ->where('player_id', $player->id)
            ->get()
            ->first(function ($a) use ($normalizedInput) {
                return $this->normalize($a->answer_text) === $normalizedInput;
            });

        if ($existingAnswer) {
            return response()->json([
                'status' => 'duplicate',
                'message' => 'Already submitted',
            ]);
        }

        // Check if answer is correct
        $isCorrect = $this->checkAnswerCorrectness($challenge, $answerText);
        $gameItemId = $this->findGameItemId($challenge, $answerText);

        // If correct, this player is the winner of this question
        $isWinning = $isCorrect;

        // Save answer
        $answer = SilhouetteAnswer::create([
            'room_question_id' => $roomQuestion->id,
            'player_id' => $player->id,
            'answer_text' => $answerText,
            'game_item_id' => $gameItemId,
            'is_correct' => $isCorrect,
            'is_winning' => $isWinning,
            'submitted_at' => now(),
        ]);

        if ($isCorrect) {
            // Set question ended_at immediately
            $roomQuestion->update(['ended_at' => now()]);

            // Broadcast score update to others
            $correctCount = $player->correctCountForQuestion($roomQuestion->id);
            broadcast(new ScoreUpdate($room, $player->id, $correctCount))->toOthers();

            // Run the EndQuestionJob synchronously to transit the game round immediately
            EndQuestionJob::dispatchSync($room->id, $roomQuestion->question_order);
        }

        return response()->json([
            'status' => $isCorrect ? 'correct' : 'wrong',
            'correct_count' => $isCorrect ? 1 : 0,
        ]);
    }

    public function results(string $locale, string $code): JsonResponse
    {
        $room = SilhouetteRoom::where('code', $code)->firstOrFail();

        if (!in_array($room->status, ['finished', 'in_progress'])) {
            return response()->json(['message' => 'Game has not finished yet'], 422);
        }

        $leaderboard = $this->scoringService->buildLeaderboard($room);

        $rounds = $room->roomQuestions()->with('challenge')->get()->map(function ($rq) use ($room) {
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
                'question_text' => $rq->challenge->question ?? 'Who is this?',
                'question_text_ar' => $rq->challenge->question_ar ?? ($rq->challenge->question ?? 'من هذا؟'),
                'player_scores' => $playerScores,
            ];
        });

        return response()->json([
            'leaderboard' => $leaderboard,
            'rounds' => $rounds,
            'mode' => $room->mode,
        ]);
    }

    private function checkAnswerCorrectness(Challenge $challenge, string $userAnswer): bool
    {
        $normalizedInput = $this->normalize($userAnswer);
        $validAnswers = [$challenge->answer];
        if (is_array($challenge->answers)) {
            $validAnswers = array_merge($validAnswers, $challenge->answers);
        }

        $type = $challenge->answer_type ?? 'player';
        foreach ($validAnswers as $ans) {
            if ($this->normalize($ans) === $normalizedInput) {
                return true;
            }

            // Check GameItem synonyms
            $item = \App\Models\GameItem::where('type', $type)
                ->where(function($q) use ($ans) {
                    $q->where('name_en', $ans)
                      ->orWhere('name_ar', $ans);
                })->first();

            if ($item) {
                $options = [$item->name_en, $item->name_ar];
                if (isset($item->metadata['synonyms']) && is_array($item->metadata['synonyms'])) {
                    $options = array_merge($options, $item->metadata['synonyms']);
                }
                if (is_array($item->fuzzy_variants)) {
                    $options = array_merge($options, $item->fuzzy_variants);
                }
                foreach ($options as $opt) {
                    if ($opt && $this->normalize($opt) === $normalizedInput) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    private function findGameItemId(Challenge $challenge, string $userAnswer): ?int
    {
        $normalizedInput = $this->normalize($userAnswer);
        $validAnswers = [$challenge->answer];
        if (is_array($challenge->answers)) {
            $validAnswers = array_merge($validAnswers, $challenge->answers);
        }

        $type = $challenge->answer_type ?? 'player';
        foreach ($validAnswers as $ans) {
            $item = \App\Models\GameItem::where('type', $type)
                ->where(function($q) use ($ans) {
                    $q->where('name_en', $ans)
                      ->orWhere('name_ar', $ans);
                })->first();

            if ($item) {
                $options = [$item->name_en, $item->name_ar];
                if (isset($item->metadata['synonyms']) && is_array($item->metadata['synonyms'])) {
                    $options = array_merge($options, $item->metadata['synonyms']);
                }
                if (is_array($item->fuzzy_variants)) {
                    $options = array_merge($options, $item->fuzzy_variants);
                }
                foreach ($options as $opt) {
                    if ($opt && $this->normalize($opt) === $normalizedInput) {
                        return $item->id;
                    }
                }
            }
        }

        return null;
    }

    private function normalize(string $text): string
    {
        $text = mb_strtolower(trim($text));
        $text = preg_replace('/[\x{064B}-\x{065F}\x{0670}]/u', '', $text);
        $text = str_replace(['أ', 'إ', 'آ'], 'ا', $text);
        $text = str_replace('ة', 'ه', $text);
        $text = str_replace('ى', 'ي', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        return $text;
    }
}
