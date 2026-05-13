<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            ['name_en' => 'Football', 'name_ar' => 'كرة القدم', 'slug' => 'football', 'icon' => '⚽', 'theme_color' => '#10b981', 'sort_order' => 1, 'image_file' => 'football.png'],
            ['name_en' => 'Actors', 'name_ar' => 'الممثلين', 'slug' => 'actors', 'icon' => '🎭', 'theme_color' => '#f43f5e', 'sort_order' => 2, 'image_file' => 'actors.png'],
            ['name_en' => 'Movies', 'name_ar' => 'أفلام', 'slug' => 'movies', 'icon' => '🎬', 'theme_color' => '#8b5cf6', 'sort_order' => 3, 'image_file' => 'movies.png'],
            ['name_en' => 'Geography', 'name_ar' => 'جغرافيا', 'slug' => 'geography', 'icon' => '🌍', 'theme_color' => '#0ea5e9', 'sort_order' => 4, 'image_file' => 'geography.png'],
        ];

        foreach ($genres as $genreData) {
            $imageFile = $genreData['image_file'];
            unset($genreData['image_file']);
            
            $genre = Genre::updateOrCreate(['slug' => $genreData['slug']], $genreData);
            
            $sourcePath = storage_path('app/seeds/genres/' . $imageFile);
            
            if (file_exists($sourcePath)) {
                $genre->clearMediaCollection('cover');
                $genre->addMedia($sourcePath)
                     ->preservingOriginal()
                     ->toMediaCollection('cover');
                
                $genre->update(['image' => 'genres/' . $imageFile]);
            }
        }
    }
}
