<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Game;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Categories
        $football = Category::firstOrCreate(
            ['slug' => 'football'],
            [
                'name_en' => 'Football',
                'name_ar' => 'كرة القدم',
                'description_en' => 'Challenges for true football fans',
                'description_ar' => 'تحديات لعشاق كرة القدم الحقيقيين',
                'sort_order' => 1,
            ]
        );

        $words = Category::firstOrCreate(
            ['slug' => 'words'],
            [
                'name_en' => 'Words',
                'name_ar' => 'كلمات',
                'description_en' => 'Test your vocabulary and spelling',
                'description_ar' => 'اختبر مفرداتك وهجائك',
                'sort_order' => 2,
            ]
        );

        $maths = Category::firstOrCreate(
            ['slug' => 'mathematics'],
            [
                'name_en' => 'Mathematics',
                'name_ar' => 'رياضيات',
                'description_en' => 'Brain teasers and math puzzles',
                'description_ar' => 'ألعاب العقل وألغاز الرياضيات',
                'sort_order' => 3,
            ]
        );

        // 2. Assign current games to Football and add Arabic names
        $gamesData = [
            'black-and-white' => ['ar' => 'أبيض وأسود'],
            'stadium-spotter' => ['ar' => 'مكتشف الملاعب'],
            'highlight-moments' => ['ar' => 'لحظات بارزة'],
            'career' => ['ar' => 'مسيرة اللاعب'],
            'kit-detective' => ['ar' => 'متحري الأطقم'],
            'trophy-hunter' => ['ar' => 'صائد البطولات'],
            'guess-silhouette' => ['ar' => 'خمن الظل'],
            'group-players' => ['ar' => 'تخمين المجموعة'],
        ];

        foreach ($gamesData as $slug => $data) {
            Game::where('slug', $slug)->update([
                'category_id' => $football->id,
                'name_ar' => $data['ar']
            ]);
        }
    }
}
