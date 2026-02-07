<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\SilhouetteChallenge;
use Illuminate\Http\Request;

class SilhouetteController extends Controller
{
    public function play(?int $challengeId = null)
    {
        $game = Game::where('slug', 'guess-silhouette')->where('is_active', true)->firstOrFail();

        $challenge = $challengeId
            ? SilhouetteChallenge::where('is_active', true)->findOrFail($challengeId)
            : SilhouetteChallenge::where('game_id', $game->id)->where('is_active', true)->inRandomOrder()->first();

        if (!$challenge) {
            return redirect()->route('home')->with('error', 'No silhouette challenges available yet!');
        }

        return view('games.silhouette.play', [
            'game' => $game,
            'challenge' => $challenge,
        ]);
    }

    public function checkAnswer(Request $request, int $challengeId)
    {
        $challenge = SilhouetteChallenge::findOrFail($challengeId);
        $userAnswer = strtolower(trim($request->answer));
        $correctAnswer = strtolower($challenge->player_name);

        // Check for exact match, partial match, or close enough (Levenshtein)
        $correct = $userAnswer === $correctAnswer ||
                   str_contains($correctAnswer, $userAnswer) ||
                   str_contains($userAnswer, $correctAnswer) ||
                   (levenshtein($userAnswer, $correctAnswer) <= 2);

        return response()->json([
            'correct' => $correct,
            'message' => $correct
                ? "Correct! It's {$challenge->player_name}!"
                : "Wrong answer. Try again!",
            'reveal_image' => $correct && $challenge->reveal_image_path
                ? asset('storage/' . $challenge->reveal_image_path)
                : null,
        ]);
    }

    public function revealAnswer(int $challengeId)
    {
        $challenge = SilhouetteChallenge::findOrFail($challengeId);
        return response()->json([
            'answer' => $challenge->player_name,
            'reveal_image' => $challenge->reveal_image_path
                ? asset('storage/' . $challenge->reveal_image_path)
                : null,
        ]);
    }

    public function getHint(Request $request, int $challengeId)
    {
        $challenge = SilhouetteChallenge::with('hints')->findOrFail($challengeId);
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
