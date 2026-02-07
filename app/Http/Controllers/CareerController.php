<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\CareerChallenge;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function play(?int $challengeId = null)
    {
        $game = Game::where('slug', 'career')->where('is_active', true)->firstOrFail();

        $challenge = $challengeId
            ? CareerChallenge::with(['careerClubs.club'])->where('is_active', true)->findOrFail($challengeId)
            : CareerChallenge::with(['careerClubs.club'])->where('game_id', $game->id)->where('is_active', true)->inRandomOrder()->first();

        if (!$challenge) {
            return redirect()->route('home')->with('error', 'No career challenges available yet! Add some in the admin panel.');
        }

        return view('games.career.play', [
            'game' => $game,
            'challenge' => $challenge,
        ]);
    }

    public function checkAnswer(Request $request, int $challengeId)
    {
        $challenge = CareerChallenge::findOrFail($challengeId);
        $userAnswer = strtolower(trim($request->answer));
        $correctAnswer = strtolower($challenge->player_name);

        // Check for exact match or close match
        $correct = $userAnswer === $correctAnswer ||
                   str_contains($correctAnswer, $userAnswer) ||
                   (function_exists('levenshtein') &&
                    levenshtein($userAnswer, $correctAnswer) <= 3);

        return response()->json([
            'correct' => $correct,
            'message' => $correct
                ? "Correct! Well done!"
                : "Not quite. The answer is: {$challenge->player_name}",
        ]);
    }

    public function getHint(Request $request, int $challengeId)
    {
        $challenge = CareerChallenge::with('hints')->findOrFail($challengeId);
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
