<?php

namespace App\Events\Mazad;

use App\Models\MazadRoom;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerJoined implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public MazadRoom $room,
        public array $player,
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('mazad.room.' . $this->room->code);
    }

    public function broadcastWith(): array
    {
        return [
            'player' => $this->player,
            'player_count' => $this->room->players()->count(),
        ];
    }
}
