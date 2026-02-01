<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\SilhouetteChallenge;
use App\Models\SilhouetteHint;
use Illuminate\Database\Seeder;

class SilhouetteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $game = Game::updateOrCreate(
            ['slug' => 'guess-silhouette'],
            [
                'title' => 'Guess the Silhouette',
                'description' => 'The pose, the stride, the legend. Can you identify the football superstar from just their shadow?',
                'image' => 'games/guess-silhouette.png',
            ]
        );

        // We will add actual silhouette images via tinker or direct file copy after generating them.
    }
}
