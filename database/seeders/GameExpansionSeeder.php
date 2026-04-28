<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Challenge;
use Illuminate\Database\Seeder;

class GameExpansionSeeder extends Seeder
{
    /**
     * This seeder previously handled expansion for multiple games.
     * Silhouette challenges have been moved to SilhouetteSeeder.
     * Other games will be migrated to the unified system one by one.
     */
    public function run(): void
    {
        // Silhouette seeding moved to SilhouetteSeeder
        
        // Anagram Arena migration pending
        // $this->migrateAnagrams();
    }
}
