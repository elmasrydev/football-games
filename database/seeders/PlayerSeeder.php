<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $url = 'https://raw.githubusercontent.com/federicopaschetta/FootballPlayersAnalysis/main/male_players.csv';
        
        $this->command->info("Downloading player data from GitHub...");
        
        $handle = fopen($url, 'r');
        if ($handle === false) {
            $this->command->error("Failed to open URL: $url");
            return;
        }

        // Skip header
        fgetcsv($handle);

        $players = [];
        $count = 0;
        $batchSize = 1000;

        while (($data = fgetcsv($handle)) !== false) {
            // Index 1: Name, Index 2: Nation, Index 3: Club
            if (count($data) < 4) continue;

            $players[] = [
                'name' => $data[1],
                'nationality' => $data[2],
                'current_club' => $data[3],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $count++;

            if (count($players) >= $batchSize) {
                \App\Models\Player::insert($players);
                $players = [];
                $this->command->info("Imported $count players...");
            }
        }

        if (!empty($players)) {
            \App\Models\Player::insert($players);
        }

        fclose($handle);
        $this->command->info("Import complete! Total players: $count");
    }
}
