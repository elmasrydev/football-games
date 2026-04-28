<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Disable foreign key checks for dropping tables
        Schema::disableForeignKeyConstraints();

        $tables = [
            'anagram_challenges',
            'anagram_hints',
            'career_challenges',
            'career_hints',
            'career_clubs',
            'football_glossary_challenges',
            'football_glossary_hints',
            'group_challenges',
            'group_challenge_hints',
            'group_challenge_players',
            'kit_challenges',
            'kit_hints',
            'missing_link_challenges',
            'missing_link_hints',
            'silhouette_challenges',
            'silhouette_hints',
            'stadium_challenges',
            'stadium_hints',
            'transfer_chain_challenges',
            'transfer_chain_hints',
            'vowel_void_challenges',
            'vowel_void_hints',
            'videos',
            'hints',
            'players',
            'clubs',
        ];

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No easy way to reverse a 26-table drop with data.
        // We'll leave it empty as this is a destructive cleanup migration.
    }
};
