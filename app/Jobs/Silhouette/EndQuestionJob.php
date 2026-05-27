<?php

namespace App\Jobs\Silhouette;

use App\Events\Silhouette\GameFinished;
use App\Events\Silhouette\QuestionEnded;
use App\Models\SilhouetteRoom;
use App\Services\Silhouette\ScoringService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EndQuestionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $roomId,
        public int $questionIndex,
    ) {}

    public function handle(ScoringService $scoringService): void
    {
        $room = SilhouetteRoom::find($this->roomId);
        if (!$room || in_array($room->status, ['closed', 'finished'])) {
            return;
        }

        $roomQuestion = $room->roomQuestions()
            ->where('question_order', $this->questionIndex)
            ->first();

        if (!$roomQuestion) {
            return;
        }

        // If it's already ended (e.g. correct answer was submitted early), skip
        $alreadyEnded = $roomQuestion->ended_at !== null;
        if (!$alreadyEnded) {
            $roomQuestion->update(['ended_at' => now()]);
        }

        // Calculate scores for this round
        $roundResults = $room->mode === 'teams'
            ? $scoringService->scoreTeamRound($roomQuestion)
            : $scoringService->scoreIndividualRound($roomQuestion);

        // Check if there are more questions
        $nextIndex = $this->questionIndex + 1;
        $hasNext = $nextIndex < $room->num_questions;

        // Reveal the correct answer to players
        $challenge = $roomQuestion->challenge;
        $correctAnswer = $challenge->answer; // Eng name of answer
        $revealImagePath = $challenge->reveal_image_path ?? ($challenge->stimulus_data['reveal_image_path'] ?? null);

        // Broadcast round results
        broadcast(new QuestionEnded(
            room: $room,
            questionIndex: $this->questionIndex,
            roundResults: $roundResults,
            restTimeSeconds: $room->rest_time_seconds,
            hasNextQuestion: $hasNext,
            correctAnswer: $correctAnswer,
            revealImagePath: $revealImagePath,
        ));

        if ($hasNext) {
            // Schedule next question after rest period
            StartQuestionJob::dispatch($this->roomId, $nextIndex)
                ->delay(now()->addSeconds($room->rest_time_seconds));
        } else {
            // Game is finished
            $room->update([
                'status' => 'finished',
                'finished_at' => now(),
            ]);

            $leaderboard = $scoringService->buildLeaderboard($room);

            broadcast(new GameFinished($room, $leaderboard));
        }
    }
}
