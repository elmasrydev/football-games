<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Video;
use Illuminate\Http\Request;

class TrophyHunterController extends Controller
{
    public function play(?int $videoId = null)
    {
        $game = Game::where('slug', 'trophy-hunter')->where('is_active', true)->firstOrFail();

        $video = $videoId
            ? Video::where('game_id', $game->id)->where('is_active', true)->findOrFail($videoId)
            : Video::where('game_id', $game->id)->where('is_active', true)->inRandomOrder()->first();

        if (!$video) {
            return redirect()->route('home')->with('error', 'No trophy moments available yet!');
        }

        return view('games.trophy.play', [
            'game' => $game,
            'video' => $video,
        ]);
    }

    public function checkAnswer(Request $request, int $videoId)
    {
        $video = Video::findOrFail($videoId);
        $userAnswer = strtolower(trim($request->answer));
        $correctAnswer = strtolower($video->answer);

        // Normalize common competition name variations
        $normalizations = [
            'champions league' => ['ucl', 'cl', 'uefa champions league', 'european cup'],
            'world cup' => ['wc', 'fifa world cup'],
            'europa league' => ['uel', 'el', 'uefa europa league', 'uefa cup'],
            'premier league' => ['epl', 'pl', 'english premier league'],
            'la liga' => ['spanish league', 'liga'],
            'fa cup' => ['facup', 'the fa cup'],
            'copa del rey' => ['kings cup', 'spanish cup'],
            'euro' => ['euros', 'european championship', 'uefa euro'],
            'copa america' => ['copa', 'conmebol copa america'],
            'afcon' => ['africa cup of nations', 'african cup'],
        ];

        // Normalize user answer
        $normalizedUser = $userAnswer;
        foreach ($normalizations as $standard => $variants) {
            foreach ($variants as $variant) {
                if (str_contains($userAnswer, $variant)) {
                    $normalizedUser = str_replace($variant, $standard, $normalizedUser);
                }
            }
        }

        // Normalize correct answer
        $normalizedCorrect = $correctAnswer;
        foreach ($normalizations as $standard => $variants) {
            foreach ($variants as $variant) {
                if (str_contains($correctAnswer, $variant)) {
                    $normalizedCorrect = str_replace($variant, $standard, $normalizedCorrect);
                }
            }
        }

        // Check for match
        $correct = $normalizedUser === $normalizedCorrect ||
                   str_contains($normalizedCorrect, $normalizedUser) ||
                   str_contains($normalizedUser, $normalizedCorrect) ||
                   (levenshtein($normalizedUser, $normalizedCorrect) <= 3);

        return response()->json([
            'correct' => $correct,
            'message' => $correct
                ? "Correct! That's the {$video->answer}!"
                : "Not quite right. Try again!",
        ]);
    }

    public function getHint(Request $request, int $videoId)
    {
        $video = Video::with('hints')->findOrFail($videoId);
        $shownHints = $request->shown_hints ?? [];

        $nextHint = $video->hints()
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
