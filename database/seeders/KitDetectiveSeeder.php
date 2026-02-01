<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\KitChallenge;
use App\Models\KitHint;
use Illuminate\Database\Seeder;

class KitDetectiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $game = Game::updateOrCreate(
            ['slug' => 'kit-detective'],
            [
                'title' => 'Kit Detective',
                'description' => 'A thread, a pattern, a legend. Zoom in on famous football kits and guess the team and the year they wore it!',
                'image' => 'games/stadium-spotter.png', // Placeholder until we have a real one
            ]
        );

        // We don't have images yet, but we can set up the records.
        // The user will need to upload images via Filament.
        // For now, I'll just create one placeholder record if they want to see the UI.
        
        /*
        $challenge = KitChallenge::create([
            'game_id' => $game->id,
            'image_path' => 'kits/zoomed/placeholder.jpg',
            'full_image_path' => 'kits/full/placeholder.jpg',
            'team_name' => 'Manchester United',
            'kit_year' => '1998-99',
            'difficulty' => 'easy',
        ]);

        KitHint::create([
            'kit_challenge_id' => $challenge->id,
            'content' => 'They won the Treble in this kit.',
            'sort_order' => 1,
        ]);
        */
    }
}
