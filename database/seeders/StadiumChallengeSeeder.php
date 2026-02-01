<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\StadiumChallenge;
use App\Models\StadiumHint;
use Illuminate\Database\Seeder;

class StadiumChallengeSeeder extends Seeder
{
    public function run(): void
    {
        $game = Game::where('slug', 'stadium-spotter')->first();

        if (!$game) {
            $this->command->error('Stadium Spotter game not found! Please create it first.');
            return;
        }

        // Easy: Camp Nou
        $campNou = StadiumChallenge::create([
            'game_id' => $game->id,
            'image_path' => 'stadiums/test-camp-nou.png',
            'stadium_name' => 'Camp Nou',
            'capacity' => 99354,
            'opened_year' => 1957,
            'country' => 'Spain',
            'difficulty' => 'easy',
        ]);

        StadiumHint::create([
            'stadium_challenge_id' => $campNou->id,
            'content' => 'This stadium is home to one of the most successful clubs in Europe.',
            'sort_order' => 1,
        ]);

        StadiumHint::create([
            'stadium_challenge_id' => $campNou->id,
            'content' => 'It is located in Barcelona.',
            'sort_order' => 2,
        ]);

        StadiumHint::create([
            'stadium_challenge_id' => $campNou->id,
            'content' => 'Messi played here for most of his career.',
            'sort_order' => 3,
        ]);

        // Easy: Old Trafford
        $oldTrafford = StadiumChallenge::create([
            'game_id' => $game->id,
            'image_path' => 'stadiums/test-old-trafford.png',
            'stadium_name' => 'Old Trafford',
            'capacity' => 74310,
            'opened_year' => 1910,
            'country' => 'England',
            'difficulty' => 'easy',
        ]);

        StadiumHint::create([
            'stadium_challenge_id' => $oldTrafford->id,
            'content' => 'Known as the "Theatre of Dreams".',
            'sort_order' => 1,
        ]);

        StadiumHint::create([
            'stadium_challenge_id' => $oldTrafford->id,
            'content' => 'Located in Manchester.',
            'sort_order' => 2,
        ]);

        // Medium: Parc des Princes
        $parcDesPrinces = StadiumChallenge::create([
            'game_id' => $game->id,
            'image_path' => 'stadiums/test-parc-des-princes.png',
            'stadium_name' => 'Parc des Princes',
            'capacity' => 47929,
            'opened_year' => 1972,
            'country' => 'France',
            'difficulty' => 'medium',
        ]);

        StadiumHint::create([
            'stadium_challenge_id' => $parcDesPrinces->id,
            'content' => 'Home to a club owned by Qatar Sports Investments.',
            'sort_order' => 1,
        ]);

        StadiumHint::create([
            'stadium_challenge_id' => $parcDesPrinces->id,
            'content' => 'Located in Paris.',
            'sort_order' => 2,
        ]);

        // Hard: Atatürk Olympic Stadium
        $ataturk = StadiumChallenge::create([
            'game_id' => $game->id,
            'image_path' => 'stadiums/test-ataturk.png',
            'stadium_name' => 'Atatürk Olympic Stadium',
            'capacity' => 76092,
            'opened_year' => 2002,
            'country' => 'Turkey',
            'difficulty' => 'hard',
        ]);

        StadiumHint::create([
            'stadium_challenge_id' => $ataturk->id,
            'content' => 'Hosted the 2005 Champions League final (Liverpool vs AC Milan).',
            'sort_order' => 1,
        ]);

        StadiumHint::create([
            'stadium_challenge_id' => $ataturk->id,
            'content' => 'Located in Istanbul.',
            'sort_order' => 2,
        ]);

        $this->command->info('✅ Created 4 test stadiums (2 easy, 1 medium, 1 hard) with hints!');
        $this->command->warn('⚠️  Note: Images are placeholder paths. Upload real images via admin panel.');
    }
}
