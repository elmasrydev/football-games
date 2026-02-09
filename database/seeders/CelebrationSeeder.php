<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Video;
use App\Models\Hint;
use Illuminate\Database\Seeder;

class CelebrationSeeder extends Seeder
{
    public function run(): void
    {
        $game = Game::where('slug', 'highlight-moments')->first();
        
        if (!$game) {
            $game = Game::create([
                'title' => 'Highlight Moments',
                'slug' => 'highlight-moments',
                'description' => 'Identify the football legend by their iconic goal celebration. No filters, just the moves.',
                'image' => 'games/celebration-station.png',
            ]);
        }

        // CR7 - SIUUU
        $cr7 = Video::updateOrCreate(
            ['answer' => 'Cristiano Ronaldo', 'game_id' => $game->id],
            [
                'youtube_url' => 'https://www.youtube.com/watch?v=R96M9_6WzAI',
                'start_time' => '0:02',
                'end_time' => '0:10',
                'question' => 'Who is known for this "SIUUU" celebration?',
            ]
        );

        Hint::updateOrCreate(['video_id' => $cr7->id, 'sort_order' => 1], ['content' => 'He is the all-time leading goal scorer in professional football.']);
        Hint::updateOrCreate(['video_id' => $cr7->id, 'sort_order' => 2], ['content' => 'He has played for Manchester United, Real Madrid, and Juventus.']);

        // Messi - Pointing to Sky
        $messi = Video::updateOrCreate(
            ['answer' => 'Lionel Messi', 'game_id' => $game->id],
            [
                'youtube_url' => 'https://www.youtube.com/watch?v=GjYJp6_Xw54',
                'start_time' => '0:00',
                'end_time' => '0:08',
                'question' => 'Which legend celebrates goals by pointing both hands to the sky?',
            ]
        );

        Hint::updateOrCreate(['video_id' => $messi->id, 'sort_order' => 1], ['content' => 'He won the 2022 World Cup with Argentina.']);
        Hint::updateOrCreate(['video_id' => $messi->id, 'sort_order' => 2], ['content' => 'He spent most of his legendary career at FC Barcelona.']);

        // Haaland - Meditation
        $haaland = Video::updateOrCreate(
            ['answer' => 'Erling Haaland', 'game_id' => $game->id],
            [
                'youtube_url' => 'https://www.youtube.com/watch?v=8y_D7X-rFr0',
                'start_time' => '0:02',
                'end_time' => '0:10',
                'question' => 'Which young superstar is known for this "Meditation" celebration?',
            ]
        );

        Hint::updateOrCreate(['video_id' => $haaland->id, 'sort_order' => 1], ['content' => 'He is a Norwegian striker playing for Manchester City.']);
        Hint::updateOrCreate(['video_id' => $haaland->id, 'sort_order' => 2], ['content' => 'He broke the Premier League scoring record in his debut season.']);

        // Mbappe - Arms Folded
        $mbappe = Video::updateOrCreate(
            ['answer' => 'Kylian Mbappe', 'game_id' => $game->id],
            [
                'youtube_url' => 'https://www.youtube.com/watch?v=0kPtcR3-524',
                'start_time' => '0:02',
                'end_time' => '0:10',
                'question' => 'Which French star celebrates with his arms folded under his armpits?',
            ]
        );

        Hint::updateOrCreate(['video_id' => $mbappe->id, 'sort_order' => 1], ['content' => 'He scored a hat-trick in the 2022 World Cup final.']);
        Hint::updateOrCreate(['video_id' => $mbappe->id, 'sort_order' => 2], ['content' => 'He is the face of French football and played for PSG.']);

        $this->command->info('✅ Highlight Moments game and 4 iconic moments updated!');
    }
}
