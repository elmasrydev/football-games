<?php

namespace App\Observers;

use App\Models\Challenge;

class ChallengeObserver
{
    /**
     * Handle the Challenge "created" event.
     */
    public function saved(Challenge $challenge): void
    {
        $this->syncGameGenres($challenge->game);
    }

    public function deleted(Challenge $challenge): void
    {
        $this->syncGameGenres($challenge->game);
    }

    public function restored(Challenge $challenge): void
    {
        $this->syncGameGenres($challenge->game);
    }

    private function syncGameGenres($game): void
    {
        if (!$game) return;

        // Get all unique genre IDs from active challenges for this game
        $genreIds = Challenge::where('game_id', $game->id)
            ->where('is_active', true)
            ->distinct()
            ->pluck('genre_id')
            ->filter()
            ->toArray();

        $game->genres()->sync($genreIds);
    }
}
