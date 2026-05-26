<?php

namespace App\Jobs\Mazad;

use App\Events\Mazad\GameFinished;
use App\Events\Mazad\QuestionEnded;
use App\Models\MazadRoom;
use App\Services\Mazad\ScoringService;
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
        $room = MazadRoom::find($this->roomId);
        if (!$room || $room->status === 'closed' || $room->status === 'finished') {
            return;
        }

        $roomQuestion = $room->roomQuestions()
            ->where('question_order', $this->questionIndex)
            ->first();

        if (!$roomQuestion) {
            return;
        }

        // Mark question as ended
        $roomQuestion->update(['ended_at' => now()]);

        // Calculate scores for this round
        $roundResults = $room->mode === 'teams'
            ? $scoringService->scoreTeamRound($roomQuestion)
            : $scoringService->scoreIndividualRound($roomQuestion);

        // Check if there are more questions
        $nextIndex = $this->questionIndex + 1;
        $hasNext = $nextIndex < $room->num_questions;

        // Broadcast round results
        broadcast(new QuestionEnded(
            room: $room,
            questionIndex: $this->questionIndex,
            roundResults: $roundResults,
            restTimeSeconds: $room->rest_time_seconds,
            hasNextQuestion: $hasNext,
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
