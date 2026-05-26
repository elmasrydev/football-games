<?php

namespace App\Events\Mazad;

use App\Models\MazadRoom;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionEnded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public MazadRoom $room,
        public int $questionIndex,
        public array $roundResults,
        public int $restTimeSeconds,
        public bool $hasNextQuestion,
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('mazad.room.' . $this->room->code);
    }

    public function broadcastWith(): array
    {
        return [
            'question_index' => $this->questionIndex,
            'round_results' => $this->roundResults,
            'rest_time_seconds' => $this->restTimeSeconds,
            'has_next_question' => $this->hasNextQuestion,
        ];
    }
}
