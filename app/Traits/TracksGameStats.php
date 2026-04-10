<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;

trait TracksGameStats
{
    protected function getStats()
    {
        $rawStats = request()->cookie('game_stats');
        
        if (is_string($rawStats)) {
            $stats = json_decode($rawStats, true) ?: [];
        } else {
            $stats = (array) $rawStats;
        }

        return array_merge([
            'streak' => 0,
            'last_played_at' => null,
            'total_correct' => 0,
            'total_questions' => 0,
            'games_played' => 0,
            'played_challenges' => [] 
        ], $stats);
    }

    protected function updateStats(bool $isCorrect, $challengeId, string $gameType)
    {
        $stats = $this->getStats();
        $today = Carbon::today()->toDateString();
        $yesterday = Carbon::yesterday()->toDateString();

        // Handle Streak
        if ($stats['last_played_at'] === $yesterday) {
            $stats['streak']++;
        } elseif ($stats['last_played_at'] !== $today) {
            $stats['streak'] = 1;
        }

        // Handle Games Played (unique challenge per day)
        $challengeKey = $gameType . '_' . $challengeId;
        if ($stats['last_played_at'] !== $today) {
            $stats['played_challenges'] = [$challengeKey];
            $stats['games_played'] = 1;
        } elseif (!in_array($challengeKey, $stats['played_challenges'])) {
            $stats['played_challenges'][] = $challengeKey;
            $stats['games_played']++;
        }

        // Handle Score
        $stats['total_questions']++;
        if ($isCorrect) {
            $stats['total_correct']++;
        }

        $stats['last_played_at'] = $today;

        // Save for 1 year
        Cookie::queue('game_stats', json_encode($stats), 60 * 24 * 365);
        
        return $stats;
    }
}
