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
        $correctYear = strtolower($challenge->kit_year);
        
        // Check if the answer contains both the team and the year or just is very close
        $hasTeam = str_contains($userAnswer, $correctTeam) || (levenshtein($userAnswer, $correctTeam) <= 2);
        
        // For the year, we want more precision
        $hasYear = str_contains($userAnswer, $correctYear);

        $correct = $hasTeam && $hasYear;

        // Fallback: if they just got the team exactly right but didn't provide the year, we can give partial success or ask for year
        // But for simplicity, let's say they need both or a very good match for the full string
        $fullAnswer = strtolower($challenge->team_name . ' ' . $challenge->kit_year);
        if (!$correct) {
             $correct = $userAnswer === $fullAnswer || (levenshtein($userAnswer, $fullAnswer) <= 3);
        }

        return response()->json([
            'correct' => $correct,
            'message' => $correct
                ? "Correct! That's the {$challenge->team_name} {$challenge->kit_year} kit!"
                : "Wrong answer. Try again!",
            'full_image' => $correct ? asset('storage/' . $challenge->full_image_path) : null
        ]);
    }

    public function revealAnswer(int $challengeId)
    {
        $challenge = KitChallenge::findOrFail($challengeId);
        return response()->json([
            'answer' => $challenge->team_name . ' ' . $challenge->kit_year,
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
