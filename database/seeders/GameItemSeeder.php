<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameItemSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/game_items_dump.sql');
        if (file_exists($path)) {
            $sql = file_get_contents($path);
            DB::unprepared($sql);
        }

        // Add fuzzy_variants column if missing (since the dump drops and recreates the table)
        if (!\Illuminate\Support\Facades\Schema::hasColumn('game_items', 'fuzzy_variants')) {
            \Illuminate\Support\Facades\Schema::table('game_items', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->json('fuzzy_variants')->nullable()->after('metadata');
            });
        }
    }
}
