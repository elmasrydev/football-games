<?php

namespace App\Jobs\Silhouette;

use App\Events\Silhouette\QuestionStarted;
use App\Models\SilhouetteRoom;
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

        // Mark room as in progress and update current question index
        $room->update([
            'status' => 'in_progress',
            'current_question_index' => $this->questionIndex,
        ]);

        // Mark question as started
        $endTime = now()->addSeconds($room->question_time_seconds);
        $roomQuestion->update([
            'started_at' => now(),
            'ended_at' => null, // clear in case of restarts/job reruns
        ]);

        $challenge = $roomQuestion->challenge;
        $imagePath = $challenge->image_path ?? ($challenge->stimulus_data['image_path'] ?? null);

        // Broadcast the question to all players
        broadcast(new QuestionStarted(
            room: $room,
            questionIndex: $this->questionIndex,
            questionText: $challenge->question ?? 'Who is this?',
            questionTextAr: $challenge->question_ar ?? ($challenge->question ?? 'من هذا؟'),
            imagePath: $imagePath,
            timeSeconds: $room->question_time_seconds,
            endTime: $endTime->toISOString(),
        ));

        // Schedule the end of this question
        EndQuestionJob::dispatch($this->roomId, $this->questionIndex)
            ->delay($endTime);
    }
}
