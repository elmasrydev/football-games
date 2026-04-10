<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\KitChallenge;
use Illuminate\Http\Request;

class KitDetectiveController extends Controller
{
    public function play(?int $challengeId = null)
    {
        $game = Game::where('slug', 'kit-detective')->where('is_active', true)->firstOrFail();

        $challenge = $challengeId
            ? KitChallenge::where('is_active', true)->findOrFail($challengeId)
            : KitChallenge::where('game_id', $game->id)->where('is_active', true)->inRandomOrder()->first();

        if (!$challenge) {
            return redirect()->route('home')->with('error', 'No kit challenges available yet! Add some in the admin panel.');
        }

        return view('games.kit.play', [
            'game' => $game,
            'challenge' => $challenge,
        ]);
    }

    public function checkAnswer(Request $request, int $challengeId)
    {
        $challenge = KitChallenge::findOrFail($challengeId);
        $userAnswer = strtolower(trim($request->answer));
        
        $correctTeam = strtolower($challenge->team_name);
        
        // Check if the answer is the team name or very close
        $correct = str_contains($userAnswer, $correctTeam) || (levenshtein($userAnswer, $correctTeam) <= 2);

        if (!$correct) {
             $correct = $userAnswer === $correctTeam || (levenshtein($userAnswer, $correctTeam) <= 3);
        }

        return response()->json([
            'correct' => $correct,
            'message' => $correct
                ? "Correct! That's the {$challenge->team_name} kit!"
                : "Wrong answer. Try again!",
            'full_image' => $correct ? asset('storage/' . $challenge->full_image_path) : null
        ]);
    }

    public function revealAnswer(int $challengeId)
    {
        $challenge = KitChallenge::findOrFail($challengeId);
        return response()->json([
            'answer' => $challenge->team_name,
            'full_image' => asset('storage/' . $challenge->full_image_path)
        ]);
    }

    public function getHint(Request $request, int $challengeId)
    {
        $challenge = KitChallenge::with('hints')->findOrFail($challengeId);
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
