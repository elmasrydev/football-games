<?php

namespace App\Events\Mazad;

use App\Models\MazadRoom;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoomUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public MazadRoom $room,
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('mazad.lobby');
    }

    public function broadcastWith(): array
    {
        return [
            'code' => $this->room->code,
            'status' => $this->room->status,
            'visibility' => $this->room->visibility,
            'players_count' => $this->room->players()->count(),
            'max_players' => $this->room->max_players,
            'mode' => $this->room->mode,
            'owner_name' => $this->room->owner->name,
        ];
    }
}
