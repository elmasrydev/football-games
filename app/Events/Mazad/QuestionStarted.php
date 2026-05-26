<?php

namespace App\Events\Mazad;

use App\Models\MazadRoom;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionStarted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public MazadRoom $room,
        public int $questionIndex,
        public string $questionText,
        public string $questionTextAr,
        public int $timeSeconds,
        public string $endTime,
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('mazad.room.' . $this->room->code);
    }

    public function broadcastWith(): array
    {
        return [
            'question_index' => $this->questionIndex,
            'question_text' => $this->questionText,
            'question_text_ar' => $this->questionTextAr,
            'time_seconds' => $this->timeSeconds,
            'end_time' => $this->endTime,
            'total_questions' => $this->room->num_questions,
        ];
    }
}
