<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GroupChallenge;
use Illuminate\Http\Request;
use App\Traits\TracksGameStats;

class GroupChallengeController extends Controller
{
    use TracksGameStats;
    public function play(?int $challengeId = null)
    {
        $game = Game::where('slug', 'group-players')->where('is_active', true)->firstOrFail();

        $challenge = $challengeId
            ? GroupChallenge::where('is_active', true)->findOrFail($challengeId)
            : GroupChallenge::where('game_id', $game->id)->where('is_active', true)->inRandomOrder()->first();

        if (!$challenge) {
            return redirect()->route('home')->with('error', 'No group challenges available yet!');
        }

        // We only send the structure, not the player names, to prevent cheating
        $playerSlots = [];
        for ($i = 0; $i < $challenge->players_count; $i++) {
            $playerSlots[] = [
                'order' => $i,
                'revealed' => false,
                'name' => null
            ];
        }

        return view('games.group.play', [
            'game' => $game,
            'challenge' => $challenge,
            'playerSlots' => $playerSlots,
        ]);
    }

    public function checkAnswer(Request $request, int $challengeId)
    {
        $challenge = GroupChallenge::with('players')->findOrFail($challengeId);
        $userAnswer = strtolower(trim($request->answer));
        $revealedOrders = $request->revealed_orders ?? [];

        // Find a player that matches the user's answer and hasn't been revealed yet
        $matchingPlayer = $challenge->players
            ->whereNotIn('sort_order', $revealedOrders)
            ->first(function ($player) use ($userAnswer) {
                $correctAnswer = strtolower($player->player_name);
                return $userAnswer === $correctAnswer ||
                       str_contains($correctAnswer, $userAnswer) ||
                       (function_exists('levenshtein') && levenshtein($userAnswer, $correctAnswer) <= 2);
            });

        $isCorrect = (bool)$matchingPlayer;
        $stats = $this->updateStats($isCorrect, $challengeId, 'group');

        if ($matchingPlayer) {
            return response()->json([
                'correct' => true,
                'player_name' => $matchingPlayer->player_name,
                'sort_order' => $matchingPlayer->sort_order,
                'message' => "Correct! That's {$matchingPlayer->player_name}!",
                'stats' => $stats
            ]);
        }

        return response()->json([
            'correct' => false,
            'message' => "Wrong answer or already revealed. Try again!",
            'stats' => $stats
        ]);
    }

    public function revealAnswer(int $challengeId)
    {
        $challenge = GroupChallenge::with('players')->findOrFail($challengeId);
        
        return response()->json([
            'players' => $challenge->players->map(fn($p) => [
                'name' => $p->player_name,
                'sort_order' => $p->sort_order
            ])
        ]);
    }

    public function getHint(Request $request, int $challengeId)
    {
        $challenge = GroupChallenge::with('hints')->findOrFail($challengeId);
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

    public function searchPlayers(Request $request)
    {
        $query = $request->query('query');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $players = \App\Models\Player::where('name', 'LIKE', "%{$query}%")
            ->limit(10)
            ->distinct()
            ->pluck('name');

        return response()->json($players);
    }
}
