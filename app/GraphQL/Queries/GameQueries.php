<?php

namespace App\GraphQL\Queries;

use App\Models\Challenge;
use App\Models\Game;
use App\Models\GameItem;
use Illuminate\Support\Facades\DB;

class GameQueries
{
    public function searchPlayers($rootValue, array $args)
    {
        $query = $args['query'] ?? '';
        if (strlen($query) < 2) return [];

        return GameItem::ofType('player')
            ->search($query)
            ->active()
            ->limit(10)
            ->get()
            ->map(fn($item) => ['id' => $item->id, 'name' => $item->name_en]);
    }

    public function searchClubs($rootValue, array $args)
    {
        $query = $args['query'] ?? '';
        if (strlen($query) < 2) return [];

        return GameItem::ofType('club')
            ->search($query)
            ->active()
            ->limit(10)
            ->get()
            ->map(fn($item) => ['id' => $item->id, 'name' => $item->name_en]);
    }

    public function searchStadiums($rootValue, array $args)
    {
        $query = $args['query'] ?? '';
        if (strlen($query) < 2) return [];

        return GameItem::ofType('stadium')
            ->search($query)
            ->active()
            ->limit(10)
            ->get()
            ->map(fn($item) => ['id' => $item->id, 'name' => $item->name_en]);
    }
}
