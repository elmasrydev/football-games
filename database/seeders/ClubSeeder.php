<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Club;
use Illuminate\Support\Facades\DB;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('data/clubs.csv');
        
        if (!file_exists($filePath)) {
            $this->command->error("CSV file not found at: $filePath");
            return;
        }

        $this->command->info("Truncating clubs table...");
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Club::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $this->command->info("Importing club data from local CSV...");
        
        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            $this->command->error("Failed to open file: $filePath");
            return;
        }

        // Skip header
        $header = fgetcsv($handle);

        $clubs = [];
        $count = 0;
        $batchSize = 1000;

        while (($data = fgetcsv($handle)) !== false) {
            // CSV has 17 columns
            if (count($data) < 17) continue;

            $clubs[] = [
                'club_id'                 => (int) $data[0],
                'club_code'               => $data[1] ?: null,
                'name'                    => $data[2],
                'domestic_competition_id' => $data[3] ?: null,
                'total_market_value'      => $data[4] ?: null,
                'squad_size'              => $data[5] ? (int) $data[5] : null,
                'average_age'             => $data[6] ? (float) $data[6] : null,
                'foreigners_number'       => $data[7] ? (int) $data[7] : null,
                'foreigners_percentage'   => $data[8] ? (float) $data[8] : null,
                'national_team_players'   => $data[9] ? (int) $data[9] : null,
                'stadium_name'            => $data[10] ?: null,
                'stadium_seats'           => $data[11] ? (int) $data[11] : null,
                'net_transfer_record'     => $data[12] ?: null,
                'coach_name'              => $data[13] ?: null,
                'last_season'             => $data[14] ? (int) $data[14] : null,
                'filename'                => $data[15] ?: null,
                'url'                     => $data[16] ?: null,
                'created_at'              => now(),
                'updated_at'              => now(),
            ];

            $count++;

            if (count($clubs) >= $batchSize) {
                Club::insert($clubs);
                $clubs = [];
                $this->command->info("Imported $count clubs...");
            }
        }

        if (!empty($clubs)) {
            Club::insert($clubs);
        }

        fclose($handle);
        $this->command->info("Import complete! Total clubs: $count");
    }
}
