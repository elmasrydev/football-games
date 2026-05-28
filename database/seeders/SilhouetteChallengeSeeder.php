<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Challenge;
use Illuminate\Database\Seeder;

class SilhouetteChallengeSeeder extends Seeder
{
    public function run(): void
    {
        $game = Game::where('slug', 'guess-silhouette')->first();
        if (!$game) return;

        $football = Genre::where('slug', 'football')->first();
        $actors = Genre::where('slug', 'actors')->first();
        $movies = Genre::where('slug', 'movies')->first();
        $geography = Genre::where('slug', 'geography')->first();

        $challenges = [
            [
                'genre_id' => $football?->id,
                'language' => 'mix',
                'difficulty' => 'easy',
                'answer' => 'Mohamed Salah',
                'answers' => ['Mohamed Salah', 'محمد صلاح', 'Salah'],
                'answer_type' => 'player',
                'autocomplete_type' => 'player',
                'stimulus_data' => [
                    'image_path' => '/images/challenges/salah_silhouette.png',
                    'reveal_image_path' => '/images/challenges/salah_reveal.png',
                    'question' => 'Who is this famous Premier League winger?',
                    'question_ar' => 'من هو هذا الجناح الشهير في الدوري الإنجليزي الممتاز؟',
                ]
            ],
            [
                'genre_id' => $football?->id,
                'language' => 'mix',
                'difficulty' => 'easy',
                'answer' => 'Lionel Messi',
                'answers' => ['Lionel Messi', 'ليونيل ميسي', 'Messi'],
                'answer_type' => 'player',
                'autocomplete_type' => 'player',
                'stimulus_data' => [
                    'image_path' => '/images/challenges/messi_silhouette.png',
                    'reveal_image_path' => '/images/challenges/messi_reveal.png',
                    'question' => 'Who is this Inter Miami forward?',
                    'question_ar' => 'من هو مهاجم إنتر ميامي الحالي؟',
                ]
            ],
            [
                'genre_id' => $actors?->id,
                'language' => 'mix',
                'difficulty' => 'medium',
                'answer' => 'Adel Emam',
                'answers' => ['Adel Emam', 'عادل إمام', 'Al Zaeem'],
                'answer_type' => 'actor',
                'autocomplete_type' => 'actor',
                'stimulus_data' => [
                    'image_path' => '/images/challenges/adelemam_silhouette.png',
                    'reveal_image_path' => '/images/challenges/adelemam_reveal.png',
                    'question' => 'Who is this legendary Egyptian comedy actor?',
                    'question_ar' => 'من هو هذا الممثل الكوميدي المصري الأسطوري؟',
                ]
            ],
            [
                'genre_id' => $geography?->id,
                'language' => 'mix',
                'difficulty' => 'easy',
                'answer' => 'Egypt',
                'answers' => ['Egypt', 'مصر'],
                'answer_type' => 'term',
                'autocomplete_type' => 'term',
                'stimulus_data' => [
                    'image_path' => '/images/challenges/egypt_silhouette.png',
                    'reveal_image_path' => '/images/challenges/egypt_reveal.png',
                    'question' => 'Which country has this silhouette?',
                    'question_ar' => 'أي بلد يملك هذا الظل؟',
                ]
            ]
        ];

        foreach ($challenges as $data) {
            Challenge::create(array_merge($data, [
                'game_id' => $game->id,
                'is_active' => true,
                'stimulus_type' => 'image',
            ]));
        }
    }
}
