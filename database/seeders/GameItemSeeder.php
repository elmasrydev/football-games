<?php

namespace Database\Seeders;

use App\Models\GameItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameItemSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Migrate Clubs (451 rows)
        $this->command->info('Migrating Clubs...');
        $clubs = DB::table('clubs')->get();
        
        foreach ($clubs as $club) {
            $item = GameItem::create([
                'type' => 'club',
                'name_en' => $club->name,
                'country' => null, 
                'external_id' => $club->club_id,
                'metadata' => [
                    'club_code' => $club->club_code,
                    'stadium_name' => $club->stadium_name,
                    'league' => $club->domestic_competition_id,
                ],
            ]);

            // Add Logo if exists (using Spatie Media Library)
            if (!empty($club->logo)) {
                try {
                    $item->addMediaFromUrl($club->logo)
                         ->toMediaCollection('image');
                } catch (\Exception $e) {
                    Log::error("Failed to download club logo for {$club->name}: " . $e->getMessage());
                }
            }
        }

        // 2. Migrate Players (34,291 rows)
        $this->command->info('Migrating Players (this may take a while)...');
        
        DB::table('players')->orderBy('player_id')->chunk(500, function ($players) {
            foreach ($players as $player) {
                GameItem::create([
                    'type' => 'player',
                    'name_en' => $player->name,
                    'country' => $player->country_of_citizenship,
                    'external_id' => $player->player_id,
                    'metadata' => [
                        'position' => $player->position,
                        'sub_position' => $player->sub_position,
                        'foot' => $player->foot,
                        'height' => $player->height_in_cm,
                        'market_value' => $player->market_value_in_eur,
                        'legacy_image_url' => $player->image_url, 
                    ],
                ]);
            }
            $this->command->info("Migrated " . GameItem::where('type', 'player')->count() . " players...");
        });

        // 3. Migrate Stadiums (From Stadium Spotter challenges)
        $this->command->info('Migrating Stadiums from challenges...');
        $stadiums = DB::table('challenges')
            ->join('games', 'challenges.game_id', '=', 'games.id')
            ->where('games.slug', 'stadium-spotter')
            ->groupBy('challenges.answer')
            ->select('challenges.answer')
            ->get();

        foreach ($stadiums as $stadium) {
            GameItem::firstOrCreate([
                'type' => 'stadium',
                'name_en' => $stadium->answer,
            ]);
        }
    }
}
