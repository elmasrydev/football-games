<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Player;
use Illuminate\Support\Facades\DB;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('data/players.csv');
        
        if (!file_exists($filePath)) {
            $this->command->error("CSV file not found at: $filePath");
            return;
        }

        $this->command->info("Truncating players table...");
        Player::truncate();

        $this->command->info("Importing player data from local CSV...");
        
        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            $this->command->error("Failed to open file: $filePath");
            return;
        }

        // Skip header
        $header = fgetcsv($handle);

        $players = [];
        $count = 0;
        $batchSize = 1000;

        while (($data = fgetcsv($handle)) !== false) {
            if (count($data) < 23) continue;

            $players[] = [
                'player_id'                            => (int) $data[0],
                'first_name'                           => $data[1] ?: null,
                'last_name'                            => $data[2] ?: null,
                'name'                                 => $data[3],
                'last_season'                          => $data[4] ? (int) $data[4] : null,
                'current_club_id'                      => $data[5] ? (int) $data[5] : null,
                'player_code'                          => $data[6] ?: null,
                'country_of_birth'                     => $data[7] ?: null,
                'city_of_birth'                        => $data[8] ?: null,
                'country_of_citizenship'               => $data[9] ?: null,
                'date_of_birth'                        => $data[10] && $data[10] !== '0000-00-00 00:00:00' ? substr($data[10], 0, 10) : null,
                'sub_position'                         => $data[11] ?: null,
                'position'                             => $data[12] ?: null,
                'foot'                                 => $data[13] ?: null,
                'height_in_cm'                         => $data[14] ? (int) $data[14] : null,
                'contract_expiration_date'             => $data[15] ?: null,
                'agent_name'                           => $data[16] ?: null,
                'image_url'                            => $data[17] ?: null,
                'url'                                  => $data[18] ?: null,
                'current_club_domestic_competition_id' => $data[19] ?: null,
                'current_club_name'                    => $data[20] ?: null,
                'market_value_in_eur'                  => $data[21] ? (int) $data[21] : null,
                'highest_market_value_in_eur'          => $data[22] ? (int) $data[22] : null,
                'created_at'                           => now(),
                'updated_at'                           => now(),
            ];

            $count++;

            if (count($players) >= $batchSize) {
                Player::insert($players);
                $players = [];
                $this->command->info("Imported $count players...");
            }
        }

        if (!empty($players)) {
            Player::insert($players);
        }

        fclose($handle);
        $this->command->info("Import complete! Total players: $count");
    }
}
