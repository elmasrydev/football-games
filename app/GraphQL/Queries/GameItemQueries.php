<?php

namespace App\GraphQL\Queries;

use App\Models\GameItem;

class GameItemQueries
{
    public function searchItems($root, array $args)
    {
        $query = $args['query'];
        $type = $args['type'];

        return GameItem::ofType($type)
            ->search($query)
            ->active()
            ->limit(10)
            ->get();
    }
}
