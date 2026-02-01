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

    /**
     * Get the next club in the career chain to reveal
     */
    public function getNextClub(Request $request, int $challengeId)
    {
        $challenge = CareerChallenge::with('careerClubs.club')->findOrFail($challengeId);
        $revealedCount = $request->revealed_count ?? 0;
        
        $careerClubs = $challenge->careerClubs()->orderBy('sort_order')->get();
        
        if ($revealedCount < $careerClubs->count()) {
            $nextClub = $careerClubs[$revealedCount];
            return response()->json([
                'club' => [
                    'name' => $nextClub->club->name,
                    'logo_url' => $nextClub->club->logo_url,
                    'year' => $nextClub->join_year,
                ],
                'revealed_count' => $revealedCount + 1,
                'total_clubs' => $careerClubs->count(),
            ]);
        }

        return response()->json([
            'message' => 'All clubs revealed!',
            'revealed_count' => $revealedCount,
            'total_clubs' => $careerClubs->count(),
        ]);
    }
}
