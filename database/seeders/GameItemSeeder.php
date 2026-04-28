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
    }
}
