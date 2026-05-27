<?php

namespace App\Events\Silhouette;

use App\Models\SilhouetteRoom;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoomUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public SilhouetteRoom $room
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('silhouette.room.' . $this->room->code);
    }

    public function broadcastWith(): array
    {
        return [
            'room' => [
                'code' => $this->room->code,
                'status' => $this->room->status,
                'players_count' => $this->room->playerCount(),
                'max_players' => $this->room->max_players,
            ]
        ];
    }
}
