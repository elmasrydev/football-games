<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Video;
use Illuminate\Http\Request;

class BlackWhiteController extends Controller
{
    public function play(Game $game, $video = null)
    {
        if (!$game->is_active) {
            abort(404);
        }

        if ($video) {
            $video = Video::where('game_id', $game->id)->where('is_active', true)->findOrFail($video);
        } else {
            $video = $game->videos()->where('is_active', true)->inRandomOrder()->first();
        }
        
        if (!$video) {
            return redirect()->route('home')->with('error', 'No videos found for this game.');
        }

        return view('games.bw.play', compact('game', 'video'));
    }

    public function checkAnswer(Request $request, Video $video)
    {
        $request->validate([
            'answer' => 'required|string',
        ]);

        $isCorrect = strtolower(trim($request->answer)) === strtolower(trim($video->answer));

        return response()->json([
            'correct' => $isCorrect,
            'message' => $isCorrect ? 'Correct! Well done.' : 'Wrong answer. Try again!',
        ]);
    }

    public function revealAnswer(Video $video)
    {
        return response()->json([
            'answer' => $video->answer,
        ]);
    }

    public function getHint(Request $request, Video $video)
    {
        $shownHintIds = $request->input('shown_hints', []);
        
        $hint = $video->hints()
            ->whereNotIn('id', $shownHintIds)
            ->first();

        if (!$hint) {
            return response()->json(['hint' => null, 'message' => 'No more hints available!']);
        }

        return response()->json([
            'hint' => $hint->content,
            'id' => $hint->id,
        ]);
    }
}
