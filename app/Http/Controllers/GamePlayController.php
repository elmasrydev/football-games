<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Challenge;
use App\Models\Genre;
use App\Models\GameItem;
use Illuminate\Http\Request;
use App\Traits\TracksGameStats;

class GamePlayController extends Controller
{
    use TracksGameStats;

    public function play(string $slug, ?int $challengeId = null)
    {
        $game = Game::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $genreId = request('genre');
        $level = request('level'); 

        $query = Challenge::where('game_id', $game->id)->where('is_active', true);
        if ($genreId) {
            $query->where('genre_id', $genreId);
        }

        $totalChallenges = $query->count();

        // Use a clean clone for fetching the challenge to avoid order/offset pollution
        $fetchQuery = (clone $query)->orderBy('id', 'asc');

        if ($level) {
            $challenge = $fetchQuery->offset(max(0, $level - 1))->first();
        } elseif ($challengeId) {
            $challenge = $query->findOrFail($challengeId);
        } else {
            // Default to latest
            $challenge = $fetchQuery->orderBy('id', 'desc')->first();
        }

        if (!$challenge) {
            return redirect()->route('home')->with('info', 'No challenges available for this criteria yet!');
        }

        // Calculate current level number reliably by counting challenges with ID <= current challenge ID
        // within the same game/genre context.
        $currentLevel = (clone $query)->where('id', '<=', $challenge->id)->count();

        return view('games.play_unified', [
            'game' => $game,
            'challenge' => $challenge,
            'genres' => Genre::all(),
            'selectedGenre' => $genreId,
            'totalChallenges' => $totalChallenges,
            'currentLevel' => $currentLevel,
        ]);
    }

    public function checkAnswer(Request $request, int $challengeId)
    {
        $challenge = Challenge::findOrFail($challengeId);
        $userAnswer = strtolower(trim($request->answer));
        
        // Group Players logic (multiple answers)
        if ($challenge->game->slug === 'group-players') {
            $answers = array_map('trim', array_map('strtolower', $challenge->answers_array));
            $revealedOrders = $request->revealed_orders ?? [];
            
            $matchIndex = -1;
            foreach ($answers as $idx => $ans) {
                if ($ans === $userAnswer && !in_array($idx, $revealedOrders)) {
                    $matchIndex = $idx;
                    break;
                }
            }

            if ($matchIndex !== -1) {
                return response()->json([
                    'correct' => true,
                    'message' => "Found one! {$userAnswer} is in the group.",
                    'matched_sort_order' => $matchIndex
                ]);
            }

            return response()->json([
                'correct' => false,
                'message' => "Nope, {$userAnswer} is not in this group (or already found)."
            ]);
        }

        // Standard logic
        $correctAnswer = strtolower($challenge->answer);
        $correct = $userAnswer === $correctAnswer;

        return response()->json([
            'correct' => $correct,
            'message' => $correct ? "Correct! Well done!" : "Not quite. Try again!",
        ]);
    }

    public function getHint(Request $request, int $challengeId)
    {
        $challenge = Challenge::with('hints')->findOrFail($challengeId);
        $shownHints = $request->shown_hints ?? [];

        $nextHint = $challenge->hints()->whereNotIn('id', $shownHints)->first();

        if ($nextHint) {
            return response()->json(['hint' => $nextHint->content, 'id' => $nextHint->id]);
        }

        return response()->json(['message' => 'No more hints available!']);
    }

    public function revealAnswer(int $challengeId)
    {
        $challenge = Challenge::findOrFail($challengeId);
        
        if ($challenge->game->slug === 'group-players') {
            return response()->json(['answers' => $challenge->answers_array]);
        }

        return response()->json(['answer' => $challenge->answer]);
    }

    public function search(Request $request, string $type)
    {
        $query = $request->query('query');
        if (!$query) return response()->json([]);

        \Log::info("Searching for '$query' in type: $type");

        $results = GameItem::ofType($type)
            ->search($query)
            ->active()
            ->limit(10)
            ->pluck('name_en');

        return response()->json($results);
    }
}
