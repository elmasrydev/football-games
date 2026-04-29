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

    public function play(string $locale, string $slug, ?int $challengeId = null)
    {
        $game = Game::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $genreSlug = request('genre');
        $level = request('level'); 

        // Find genre by slug for cleaner URLs
        $selectedGenre = $genreSlug ? Genre::where('slug', $genreSlug)->first() : null;

        $query = Challenge::where('game_id', $game->id)
            ->where('is_active', true)
            ->where('language', $locale);

        if ($selectedGenre) {
            $query->where('genre_id', $selectedGenre->id);
        }

        $totalChallenges = $query->count();
        $fetchQuery = (clone $query)->orderBy('id', 'asc');

        if ($level) {
            $challenge = $fetchQuery->offset(max(0, $level - 1))->first();
        } elseif ($challengeId) {
            $challenge = $query->findOrFail($challengeId);
        } else {
            // Explicitly get the newest challenge for this game/genre
            $challenge = (clone $query)->orderBy('id', 'desc')->first();
        }

        if (!$challenge) {
            return redirect()->route('home')->with('info', 'No challenges available for this criteria yet!');
        }

        // Level number matches the natural ASC order: COUNT where ID <= current ID
        $currentLevel = (clone $query)->where('id', '<=', $challenge->id)->count();

        // Get only genres that have challenges for this game
        $availableGenres = Genre::whereHas('challenges', function($q) use ($game, $locale) {
            $q->where('game_id', $game->id)
              ->where('is_active', true)
              ->where('language', $locale);
        })->get();

        // Fetch User Stats
        $stats = $this->getStats();

        return view('games.play_unified', [
            'game' => $game,
            'challenge' => $challenge,
            'genres' => $availableGenres,
            'selectedGenre' => $selectedGenre,
            'totalChallenges' => $totalChallenges,
            'currentLevel' => $currentLevel,
            'stats' => $stats,
        ]);
    }

    public function checkAnswer(Request $request, string $locale, int $challengeId)
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
                $stats = $this->updateStats(true, $challenge->id, $challenge->game->slug);
                return response()->json([
                    'correct' => true,
                    'message' => __("Found one! :answer is in the group.", ['answer' => $userAnswer]),
                    'matched_sort_order' => $matchIndex,
                    'stats' => $stats
                ]);
            }

            return response()->json([
                'correct' => false,
                'message' => __("Nope, :answer is not in this group (or already found).", ['answer' => $userAnswer])
            ]);
        }

        // Standard logic
        $correctAnswer = strtolower($challenge->answer);
        $correct = $userAnswer === $correctAnswer;

        // Update stats on check
        $stats = $this->updateStats($correct, $challenge->id, $challenge->game->slug);

        return response()->json([
            'correct' => $correct,
            'message' => $correct ? __("Correct! Well done!") : __("Not quite. Try again!"),
            'stats' => $stats
        ]);
    }

    public function getHint(Request $request, string $locale, int $challengeId)
    {
        $challenge = Challenge::with('hints')->findOrFail($challengeId);
        $shownHints = $request->shown_hints ?? [];

        $nextHint = $challenge->hints()->whereNotIn('id', $shownHints)->first();

        if ($nextHint) {
            return response()->json(['hint' => $nextHint->content, 'id' => $nextHint->id]);
        }

        return response()->json(['message' => 'No more hints available!']);
    }

    public function revealAnswer(string $locale, int $challengeId)
    {
        $challenge = Challenge::findOrFail($challengeId);
        
        if ($challenge->game->slug === 'group-players') {
            return response()->json(['answers' => $challenge->answers_array]);
        }

        return response()->json(['answer' => $challenge->answer]);
    }

    public function search(Request $request, string $locale, string $type)
    {
        $query = $request->query('query');
        if (!$query) return response()->json([]);

        $nameField = $locale === 'ar' ? 'name_ar' : 'name_en';

        $results = GameItem::ofType($type)
            ->where(function($q) use ($query) {
                $q->where('name_en', 'like', "%$query%")
                  ->orWhere('name_ar', 'like', "%$query%");
            })
            ->active()
            ->limit(10)
            ->pluck($nameField);

        return response()->json($results);
    }
}
