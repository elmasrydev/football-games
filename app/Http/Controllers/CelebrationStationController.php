<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Video;
use Illuminate\Http\Request;

class CelebrationStationController extends Controller
{
    public function play(?int $videoId = null)
    {
        $game = Game::where('slug', 'highlight-moments')->where('is_active', true)->firstOrFail();

        $video = $videoId
            ? Video::where('game_id', $game->id)->where('is_active', true)->findOrFail($videoId)
            : Video::where('game_id', $game->id)->where('is_active', true)->inRandomOrder()->first();

        if (!$video) {
            return redirect()->route('home')->with('error', 'No celebrations available yet!');
        }

        return view('games.celebration.play', [
            'game' => $game,
            'video' => $video,
        ]);
    }
}
