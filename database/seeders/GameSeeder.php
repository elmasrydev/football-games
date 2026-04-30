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
                'description' => 'Identify the player from their shadow silhouette.',
                'description_ar' => 'تعرف على هوية اللاعب من خلال ظله فقط.',
                'game_type' => 'image_guess',
                'answer_type' => 'player',
                'image_file' => 'guess-silhouette.png'
            ],
            [
                'title' => 'Anagram Arena',
                'name_ar' => 'ساحة الحروف',
                'slug' => 'anagram-arena',
                'description' => 'Unscramble the letters to reveal the player name.',
                'description_ar' => 'قم بإعادة ترتيب الحروف المبعثرة للكشف عن اسم اللاعب.',
                'game_type' => 'word_puzzle',
                'answer_type' => 'player',
                'image_file' => 'anagram-arena.png'
            ],
            [
                'title' => 'Transfer Chain',
                'name_ar' => 'سلسلة الانتقالات',
                'slug' => 'transfer-chain',
                'description' => 'Guess the player by following their transfer history.',
                'description_ar' => 'خمن اسم اللاعب من خلال تتبع مسيرة انتقالاته بين الأندية.',
                'game_type' => 'connection_guess',
                'answer_type' => 'player',
                'image_file' => 'transfer-chain.png'
            ],
            [
                'title' => 'Stadium Spotter',
                'name_ar' => 'مكتشف الملاعب',
                'slug' => 'stadium-spotter',
                'description' => 'Name the famous football stadium from an image.',
                'description_ar' => 'تعرف على اسم الملعب الشهير من خلال صورته.',
                'game_type' => 'image_guess',
                'answer_type' => 'stadium',
                'image_file' => 'stadium-spotter.png'
            ],
            [
                'title' => 'Vowel Void',
                'name_ar' => 'فراغ الحروف',
                'slug' => 'vowel-void',
                'description' => 'Fill in the missing vowels to complete the player name.',
                'description_ar' => 'املأ حروف العلة الناقصة لإكمال اسم اللاعب الصحيح.',
                'game_type' => 'word_puzzle',
                'answer_type' => 'player',
                'image_file' => 'vowel-void.png'
            ],
            [
                'title' => 'Kit Detective',
                'name_ar' => 'محقق الأطقم',
                'slug' => 'kit-detective',
                'description' => 'Identify the team or player from a piece of their kit.',
                'description_ar' => 'تعرف على الفريق أو اللاعب من خلال تفاصيل طقم اللعب.',
                'game_type' => 'image_guess',
                'answer_type' => 'player',
                'image_file' => 'kit-detective.png'
            ],
            [
                'title' => 'Black & White',
                'name_ar' => 'أبيض وأسود',
                'slug' => 'black-and-white',
                'description' => 'Identify the classic player from a vintage photo.',
                'description_ar' => 'تعرف على أساطير اللعبة من خلال صورهم الكلاسيكية القديمة.',
                'game_type' => 'image_guess',
                'answer_type' => 'player',
                'image_file' => 'bw.png'
            ],
            [
                'title' => 'Highlight Moments',
                'name_ar' => 'لحظات فارقة',
                'slug' => 'highlight-moments',
                'description' => 'Identify the match or player from a famous celebration.',
                'description_ar' => 'تعرف على المباراة أو اللاعب من خلال احتفال تاريخي شهير.',
                'game_type' => 'image_guess',
                'answer_type' => 'player',
                'image_file' => 'highlight_moments_generic_cover.png'
            ],
            [
                'title' => 'Trophy Hunter',
                'name_ar' => 'صائد البطولات',
                'slug' => 'trophy-hunter',
                'description' => 'Identify the player or team from their trophy cabinet.',
                'description_ar' => 'تعرف على اللاعب أو الفريق من خلال سجل بطولاته وإنجازاته.',
                'game_type' => 'image_guess',
                'answer_type' => 'player',
                'image_file' => 'trophy-hunter.png'
            ],
            [
                'title' => 'Terminology Trivia',
                'name_ar' => 'مسابقة المصطلحات',
                'slug' => 'terminology-trivia',
                'description' => 'Guess the word based on its definition or description across different genres.',
                'description_ar' => 'خمن الكلمة بناءً على تعريفها أو وصفها في مختلف المجالات.',
                'game_type' => 'word_puzzle',
                'answer_type' => 'term',
                'image_file' => 'terminology-trivia.png'
            ],
            [
                'title' => 'Missing Link',
                'name_ar' => 'الحلقة المفقودة',
                'slug' => 'missing-link',
                'description' => 'Find the word that connects these football terms.',
                'description_ar' => 'اعثر على الكلمة التي تربط بين هذه المصطلحات الكروية.',
                'game_type' => 'word_puzzle',
                'answer_type' => 'term',
                'image_file' => 'missing-link.png'
            ],
            [
                'title' => 'Career Path',
                'name_ar' => 'مسيرة اللاعب',
                'slug' => 'career',
                'description' => 'Follow the clubs to identify the player.',
                'description_ar' => 'تتبع الأندية التي لعب لها النجم للتعرف على هويته.',
                'game_type' => 'connection_guess',
                'answer_type' => 'player',
                'image_file' => 'career-path.png'
            ],
            [
                'title' => 'Group Guess',
                'name_ar' => 'خمن المجموعة',
                'slug' => 'group-players',
                'description' => 'Identify the common link between a group of players.',
                'description_ar' => 'تعرف على الرابط المشترك الذي يجمع بين مجموعة من اللاعبين.',
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
