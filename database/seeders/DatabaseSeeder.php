<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $game = \App\Models\Game::create([
            'title' => 'Black & White',
            'description' => 'The ultimate grayscale guessing challenge. Watch carefully and answer the question!',
            'image' => null,
        ]);

        $video = \App\Models\Video::create([
            'game_id' => $game->id,
            'youtube_url' => 'https://www.youtube.com/watch?v=aqz-KE-bpKQ', // Big Buck Bunny (Commonly used for testing)
            'question' => 'What is the name of this famous animated short film?',
            'answer' => 'Big Buck Bunny',
        ]);

        \App\Models\Hint::create([
            'video_id' => $video->id,
            'content' => 'He is never gonna give you up.',
            'sort_order' => 1,
        ]);

        \App\Models\Hint::create([
            'video_id' => $video->id,
            'content' => 'He is also never gonna let you down.',
            'sort_order' => 2,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
