<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\StadiumChallenge;
use Illuminate\Http\Request;

class StadiumSpotterController extends Controller
{
    public function play(?int $stadium = null)
    {
        $game = Game::where('slug', 'stadium-spotter')->where('is_active', true)->firstOrFail();

        $challenge = $stadium
            ? StadiumChallenge::where('is_active', true)->findOrFail($stadium)
            : StadiumChallenge::where('game_id', $game->id)->where('is_active', true)->inRandomOrder()->first();

        if (!$challenge) {
            return redirect()->route('home')->with('error', 'No stadiums available yet! Add some in the admin panel.');
        }

        return view('games.stadium.play', [
            'game' => $game,
            'challenge' => $challenge,
        ]);
    }

    public function checkAnswer(Request $request, int $stadiumId)
    {
        $challenge = StadiumChallenge::findOrFail($stadiumId);
        $userAnswer = strtolower(trim($request->answer));
        $correctAnswer = strtolower($challenge->stadium_name);

        // Check for exact match or partial match
        $correct = $userAnswer === $correctAnswer ||
                   str_contains($correctAnswer, $userAnswer) ||
                   (function_exists('levenshtein') &&
                    levenshtein($userAnswer, $correctAnswer) <= 2);

        return response()->json([
            'correct' => $correct,
            'message' => $correct
                ? "Correct! Well done!"
                : "Not quite. The answer is: {$challenge->stadium_name}",
        ]);
    }

    public function getHint(Request $request, int $stadiumId)
    {
        $challenge = StadiumChallenge::with('hints')->findOrFail($stadiumId);
        $shownHints = $request->shown_hints ?? [];
        
        $nextHint = $challenge->hints()
            ->whereNotIn('id', $shownHints)
            ->first();

        if ($nextHint) {
            return response()->json([
                'hint' => $nextHint->content,
                'id' => $nextHint->id,
            ]);
        }

        return response()->json([
            'message' => 'No more hints available!',
        ]);
    }
}
