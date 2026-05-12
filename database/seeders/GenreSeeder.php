<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            ['name_en' => 'Football', 'name_ar' => 'كرة القدم', 'slug' => 'football', 'icon' => '⚽', 'theme_color' => '#10b981', 'sort_order' => 1],
            ['name_en' => 'Actors', 'name_ar' => 'الممثلين', 'slug' => 'actors', 'icon' => '🎭', 'theme_color' => '#f43f5e', 'sort_order' => 2],
            ['name_en' => 'Movies', 'name_ar' => 'أفلام', 'slug' => 'movies', 'icon' => '🎬', 'theme_color' => '#8b5cf6', 'sort_order' => 3],
            ['name_en' => 'Geography', 'name_ar' => 'جغرافيا', 'slug' => 'geography', 'icon' => '🌍', 'theme_color' => '#0ea5e9', 'sort_order' => 4],
        ];

        foreach ($genres as $genre) {
            Genre::updateOrCreate(['slug' => $genre['slug']], $genre);
        }
    }
}
