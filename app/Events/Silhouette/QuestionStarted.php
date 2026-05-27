<?php

namespace App\Events\Silhouette;

use App\Models\SilhouetteRoom;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionStarted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public SilhouetteRoom $room,
        public int $questionIndex,
        public string $questionText,
        public string $questionTextAr,
        public ?string $imagePath,
        public int $timeSeconds,
        public string $endTime,
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('silhouette.room.' . $this->room->code);
    }

    public function broadcastWith(): array
    {
        return [
            'question_index' => $this->questionIndex,
            'question_text' => $this->questionText,
            'question_text_ar' => $this->questionTextAr,
            'image_path' => $this->imagePath,
            'time_seconds' => $this->timeSeconds,
            'end_time' => $this->endTime,
            'total_questions' => $this->room->num_questions,
        ];
    }
}
