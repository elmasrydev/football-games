<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $football = Genre::where('slug', 'football')->first();

        $games = [
            [
                'title' => 'Guess the Silhouette',
                'name_ar' => 'خمن الظل',
                'slug' => 'guess-silhouette',
                'description' => 'Can you identify the player from just their shadow?',
                'game_type' => 'image_guess',
                'answer_type' => 'player',
                'image_file' => 'guess-silhouette.png'
            ],
            [
                'title' => 'Anagram Arena',
                'name_ar' => 'حلبة الأناجرام',
                'slug' => 'anagram-arena',
                'description' => 'Unscramble the letters to find the hidden player.',
                'game_type' => 'word_puzzle',
                'answer_type' => 'player',
                'image_file' => 'anagram-arena.png'
            ],
            [
                'title' => 'Transfer Chain',
                'name_ar' => 'سلسلة الانتقالات',
                'slug' => 'transfer-chain',
                'description' => 'Follow the journey of players through their clubs.',
                'game_type' => 'connection_guess',
                'answer_type' => 'player',
                'image_file' => 'transfer-chain.png'
            ],
            [
                'title' => 'Stadium Spotter',
                'name_ar' => 'مكتشف الملاعب',
                'slug' => 'stadium-spotter',
                'description' => 'Guess the stadium from its aerial view.',
                'game_type' => 'image_guess',
                'answer_type' => 'stadium',
                'image_file' => 'stadium-spotter.png'
            ],
            [
                'title' => 'Vowel Void',
                'name_ar' => 'فراغ الحروف',
                'slug' => 'vowel-void',
                'description' => 'Fill in the missing vowels to reveal the name.',
                'game_type' => 'word_puzzle',
                'answer_type' => 'player',
                'image_file' => 'vowel-void.png'
            ],
            [
                'title' => 'Kit Detective',
                'name_ar' => 'مكتشف الأطقم',
                'slug' => 'kit-detective',
                'description' => 'Identify the team from a close-up of their jersey.',
                'game_type' => 'image_guess',
                'answer_type' => 'team',
                'image_file' => 'kit-detective.png'
            ],
            [
                'title' => 'Black & White',
                'name_ar' => 'أبيض وأسود',
                'slug' => 'black-and-white',
                'description' => 'Identify the legend from a vintage black and white photo.',
                'game_type' => 'image_guess',
                'answer_type' => 'player',
                'image_file' => 'bw.png'
            ],
            [
                'title' => 'Highlight Moments',
                'name_ar' => 'لحظات بارزة',
                'slug' => 'highlight-moments',
                'description' => 'Guess the event from a famous celebration photo.',
                'game_type' => 'image_guess',
                'answer_type' => 'event',
                'image_file' => 'celebration-station.png'
            ],
            [
                'title' => 'Trophy Hunter',
                'name_ar' => 'صائد البطولات',
                'slug' => 'trophy-hunter',
                'description' => 'Identify the player or team from their trophy cabinet.',
                'game_type' => 'image_guess',
                'answer_type' => 'player',
                'image_file' => 'trophy-hunter.png'
            ],
            [
                'title' => 'Terminology Trivia',
                'name_ar' => 'مسابقة المصطلحات',
                'slug' => 'terminology-trivia',
                'description' => 'Guess the word based on its definition or description across different genres.',
                'game_type' => 'word_puzzle',
                'answer_type' => 'term',
                'image_file' => 'terminology-trivia.png'
            ],
            [
                'title' => 'Missing Link',
                'name_ar' => 'الحلقة المفقودة',
                'slug' => 'missing-link',
                'description' => 'Find the word that connects these football terms.',
                'game_type' => 'word_puzzle',
                'answer_type' => 'term',
                'image_file' => 'missing-link.png'
            ],
            [
                'title' => 'Career Path',
                'name_ar' => 'مسيرة اللاعب',
                'slug' => 'career',
                'description' => 'Follow the clubs to identify the player.',
                'game_type' => 'connection_guess',
                'answer_type' => 'player',
                'image_file' => 'career-path.png'
            ],
            [
                'title' => 'Group Guess',
                'name_ar' => 'خمن المجموعة',
                'slug' => 'group-players',
                'description' => 'Identify the common link between a group of players.',
                'game_type' => 'connection_guess',
                'answer_type' => 'player',
                'image_file' => 'group_guess_cover.png'
            ],
        ];

        foreach ($games as $gameData) {
            $imageFile = $gameData['image_file'];
            unset($gameData['image_file']);
            
            $game = Game::updateOrCreate(
                ['slug' => $gameData['slug']], 
                array_merge($gameData, ['genre_id' => $football->id])
            );

            $sourcePath = storage_path('app/seeds/games/' . $imageFile);
            
            if (file_exists($sourcePath)) {
                $this->command->info("Seeding image for game: {$game->slug} from {$sourcePath}");
                $game->clearMediaCollection('cover');
                $game->addMedia($sourcePath)
                     ->preservingOriginal()
                     ->toMediaCollection('cover');
                
                $game->update(['image' => 'games/' . $imageFile]);
            } else {
                $this->command->warn("Image not found for game: {$game->slug} at path: {$sourcePath}");
            }
        }
    }
}
