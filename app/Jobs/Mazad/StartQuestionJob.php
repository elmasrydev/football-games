<?php

namespace App\Jobs\Mazad;

use App\Events\Mazad\QuestionStarted;
use App\Models\MazadRoom;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StartQuestionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $roomId,
        public int $questionIndex,
    ) {}

    public function handle(): void
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

        // Mark room as in progress and update current question index
        $room->update([
            'status' => 'in_progress',
            'current_question_index' => $this->questionIndex,
        ]);

        // Mark question as started
        $endTime = now()->addSeconds($room->question_time_seconds);
        $roomQuestion->update([
            'started_at' => now(),
        ]);

        // Broadcast the question to all players
        broadcast(new QuestionStarted(
            room: $room,
            questionIndex: $this->questionIndex,
            questionText: $roomQuestion->question->text,
            questionTextAr: $roomQuestion->question->text_ar ?? $roomQuestion->question->text,
            timeSeconds: $room->question_time_seconds,
            endTime: $endTime->toISOString(),
        ));

        // Schedule the end of this question
        EndQuestionJob::dispatch($this->roomId, $this->questionIndex)
            ->delay($endTime);
    }
}
