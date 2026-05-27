<?php

namespace App\Events\Silhouette;

use App\Models\SilhouetteRoom;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionEnded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public SilhouetteRoom $room,
        public int $questionIndex,
        public array $roundResults,
        public int $restTimeSeconds,
        public bool $hasNextQuestion,
        public string $correctAnswer = '',
        public ?string $revealImagePath = null,
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('silhouette.room.' . $this->room->code);
    }

    public function broadcastWith(): array
    {
        return [
            'question_index' => $this->questionIndex,
            'round_results' => $this->roundResults,
            'rest_time_seconds' => $this->restTimeSeconds,
            'has_next_question' => $this->hasNextQuestion,
            'correct_answer' => $this->correctAnswer,
            'reveal_image_path' => $this->revealImagePath,
        ];
    }
}
