<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Game;
use App\Models\Challenge;
use App\Models\ChallengeHint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataMigrationSeeder extends Seeder
{
    /**
     * Migrate all data from 13 legacy challenge tables into the unified challenges table.
     * Also seeds genres and assigns game_type to each game.
     */
    public function run(): void
    {
        // ── 1. Create Genres ──
        $football = Genre::firstOrCreate(
            ['slug' => 'football'],
            ['name_en' => 'Football', 'name_ar' => 'كرة القدم', 'icon' => '⚽', 'sort_order' => 1]
        );

        Genre::firstOrCreate(
            ['slug' => 'movies'],
            ['name_en' => 'Movies', 'name_ar' => 'أفلام', 'icon' => '🎬', 'sort_order' => 2]
        );

        Genre::firstOrCreate(
            ['slug' => 'actors'],
            ['name_en' => 'Actors', 'name_ar' => 'ممثلين', 'icon' => '🎭', 'sort_order' => 3]
        );

        Genre::firstOrCreate(
            ['slug' => 'science'],
            ['name_en' => 'Science', 'name_ar' => 'علوم', 'icon' => '🔬', 'sort_order' => 4]
        );

        Genre::firstOrCreate(
            ['slug' => 'general-knowledge'],
            ['name_en' => 'General Knowledge', 'name_ar' => 'ثقافة عامة', 'icon' => '🧠', 'sort_order' => 5]
        );

        $this->command->info('✅ Genres seeded');

        // ── 2. Assign game_type to each game ──
        $gameTypeMap = [
            // Image Guess games
            'stadium-spotter'     => 'image_guess',
            'kit-detective'       => 'image_guess',
            'guess-silhouette'    => 'image_guess',
            'black-and-white'     => 'image_guess',
            'highlight-moments'   => 'image_guess',
            'trophy-hunter'       => 'image_guess',
            'football-glossary'   => 'image_guess',

            // Word Puzzle games
            'anagram-arena'       => 'word_puzzle',
            'vowel-void'          => 'word_puzzle',
            'missing-link'        => 'word_puzzle',

            // Connection Guess games
            'career'              => 'connection_guess',
            'transfer-chain'      => 'connection_guess',
            'group-players'       => 'connection_guess',
        ];

        foreach ($gameTypeMap as $slug => $type) {
            Game::where('slug', $slug)->update(['game_type' => $type]);
        }

        $this->command->info('✅ game_type assigned to all games');

        // ── 3. Migrate challenge data ──
        $footballId = $football->id;

        $this->migrateStadiums($footballId);
        $this->migrateKits($footballId);
        $this->migrateSilhouettes($footballId);
        $this->migrateVideos($footballId);
        $this->migrateGlossary($footballId);
        $this->migrateAnagrams($footballId);
        $this->migrateVowelVoids($footballId);
        $this->migrateMissingLinks($footballId);
        $this->migrateCareers($footballId);
        $this->migrateTransferChains($footballId);
        $this->migrateGroups($footballId);

        // ── 4. Verify counts ──
        $this->verifyMigration();
    }

    private function migrateStadiums(int $genreId): void
    {
        $rows = DB::table('stadium_challenges')->get();
        foreach ($rows as $row) {
            $challenge = Challenge::create([
                'game_id' => $row->game_id,
                'genre_id' => $genreId,
                'difficulty' => $row->difficulty ?? 'medium',
                'stimulus_type' => 'image',
                'stimulus_data' => [
                    'image_path' => $row->image_path,
                    'capacity' => $row->capacity,
                    'opened_year' => $row->opened_year,
                    'country' => $row->country,
                ],
                'answer' => $row->stadium_name,
                'is_active' => $row->is_active ?? true,
            ]);

            $hints = DB::table('stadium_hints')->where('stadium_challenge_id', $row->id)->orderBy('sort_order')->get();
            foreach ($hints as $hint) {
                ChallengeHint::create([
                    'challenge_id' => $challenge->id,
                    'content' => $hint->content,
                    'sort_order' => $hint->sort_order,
                ]);
            }
        }
        $this->command->info("  → Stadium Spotter: {$rows->count()} challenges migrated");
    }

    private function migrateKits(int $genreId): void
    {
        $rows = DB::table('kit_challenges')->get();
        foreach ($rows as $row) {
            $challenge = Challenge::create([
                'game_id' => $row->game_id,
                'genre_id' => $genreId,
                'difficulty' => $row->difficulty ?? 'medium',
                'stimulus_type' => 'image',
                'stimulus_data' => [
                    'image_path' => $row->image_path,
                    'full_image_path' => $row->full_image_path,
                ],
                'answer' => $row->team_name,
                'is_active' => $row->is_active ?? true,
            ]);

            $hints = DB::table('kit_hints')->where('kit_challenge_id', $row->id)->orderBy('sort_order')->get();
            foreach ($hints as $hint) {
                ChallengeHint::create([
                    'challenge_id' => $challenge->id,
                    'content' => $hint->content,
                    'sort_order' => $hint->sort_order,
                ]);
            }
        }
        $this->command->info("  → Kit Detective: {$rows->count()} challenges migrated");
    }

    private function migrateSilhouettes(int $genreId): void
    {
        $rows = DB::table('silhouette_challenges')->get();
        foreach ($rows as $row) {
            $challenge = Challenge::create([
                'game_id' => $row->game_id,
                'genre_id' => $genreId,
                'difficulty' => $row->difficulty ?? 'medium',
                'stimulus_type' => 'image',
                'stimulus_data' => [
                    'image_path' => $row->image_path,
                    'reveal_image_path' => $row->reveal_image_path,
                ],
                'answer' => $row->player_name,
                'is_active' => $row->is_active ?? true,
            ]);

            $hints = DB::table('silhouette_hints')->where('silhouette_challenge_id', $row->id)->orderBy('sort_order')->get();
            foreach ($hints as $hint) {
                ChallengeHint::create([
                    'challenge_id' => $challenge->id,
                    'content' => $hint->content,
                    'sort_order' => $hint->sort_order,
                ]);
            }
        }
        $this->command->info("  → Silhouette: {$rows->count()} challenges migrated");
    }

    private function migrateVideos(int $genreId): void
    {
        $rows = DB::table('videos')->get();
        foreach ($rows as $row) {
            $challenge = Challenge::create([
                'game_id' => $row->game_id,
                'genre_id' => $genreId,
                'difficulty' => 'medium',
                'stimulus_type' => 'video',
                'stimulus_data' => [
                    'youtube_url' => $row->youtube_url,
                    'uploaded_video' => $row->uploaded_video,
                    'question' => $row->question,
                    'start_time' => $row->start_time,
                    'end_time' => $row->end_time,
                ],
                'answer' => $row->answer,
                'is_active' => $row->is_active ?? true,
            ]);

            $hints = DB::table('hints')->where('video_id', $row->id)->orderBy('sort_order')->get();
            foreach ($hints as $hint) {
                ChallengeHint::create([
                    'challenge_id' => $challenge->id,
                    'content' => $hint->content,
                    'sort_order' => $hint->sort_order,
                ]);
            }
        }
        $this->command->info("  → Videos: {$rows->count()} challenges migrated");
    }

    private function migrateGlossary(int $genreId): void
    {
        $rows = DB::table('football_glossary_challenges')->get();
        foreach ($rows as $row) {
            $challenge = Challenge::create([
                'game_id' => $row->game_id,
                'genre_id' => $genreId,
                'difficulty' => $row->difficulty ?? 'medium',
                'stimulus_type' => 'text',
                'stimulus_data' => [
                    'clue' => $row->clue,
                ],
                'answer' => $row->answer,
                'is_active' => $row->is_active ?? true,
            ]);

            $hints = DB::table('football_glossary_hints')->where('football_glossary_challenge_id', $row->id)->orderBy('sort_order')->get();
            foreach ($hints as $hint) {
                ChallengeHint::create([
                    'challenge_id' => $challenge->id,
                    'content' => $hint->content,
                    'sort_order' => $hint->sort_order,
                ]);
            }
        }
        $this->command->info("  → Football Glossary: {$rows->count()} challenges migrated");
    }

    private function migrateAnagrams(int $genreId): void
    {
        $rows = DB::table('anagram_challenges')->get();
        foreach ($rows as $row) {
            $challenge = Challenge::create([
                'game_id' => $row->game_id,
                'genre_id' => $genreId,
                'difficulty' => $row->difficulty ?? 'medium',
                'stimulus_type' => 'scrambled_text',
                'stimulus_data' => [
                    'scrambled_word' => $row->scrambled_word,
                ],
                'answer' => $row->answer,
                'is_active' => $row->is_active ?? true,
            ]);

            $hints = DB::table('anagram_hints')->where('anagram_challenge_id', $row->id)->orderBy('sort_order')->get();
            foreach ($hints as $hint) {
                ChallengeHint::create([
                    'challenge_id' => $challenge->id,
                    'content' => $hint->content,
                    'sort_order' => $hint->sort_order,
                ]);
            }
        }
        $this->command->info("  → Anagram Arena: {$rows->count()} challenges migrated");
    }

    private function migrateVowelVoids(int $genreId): void
    {
        $rows = DB::table('vowel_void_challenges')->get();
        foreach ($rows as $row) {
            $challenge = Challenge::create([
                'game_id' => $row->game_id,
                'genre_id' => $genreId,
                'difficulty' => $row->difficulty ?? 'medium',
                'stimulus_type' => 'scrambled_text',
                'stimulus_data' => [
                    'category' => $row->category,
                ],
                'answer' => $row->answer,
                'is_active' => $row->is_active ?? true,
            ]);

            $hints = DB::table('vowel_void_hints')->where('vowel_void_challenge_id', $row->id)->orderBy('sort_order')->get();
            foreach ($hints as $hint) {
                ChallengeHint::create([
                    'challenge_id' => $challenge->id,
                    'content' => $hint->content,
                    'sort_order' => $hint->sort_order,
                ]);
            }
        }
        $this->command->info("  → Vowel Void: {$rows->count()} challenges migrated");
    }

    private function migrateMissingLinks(int $genreId): void
    {
        $rows = DB::table('missing_link_challenges')->get();
        foreach ($rows as $row) {
            $challenge = Challenge::create([
                'game_id' => $row->game_id,
                'genre_id' => $genreId,
                'difficulty' => $row->difficulty ?? 'medium',
                'stimulus_type' => 'text',
                'stimulus_data' => [
                    'part_a' => $row->part_a,
                    'part_b' => $row->part_b,
                ],
                'answer' => $row->answer,
                'is_active' => $row->is_active ?? true,
            ]);

            $hints = DB::table('missing_link_hints')->where('missing_link_challenge_id', $row->id)->orderBy('sort_order')->get();
            foreach ($hints as $hint) {
                ChallengeHint::create([
                    'challenge_id' => $challenge->id,
                    'content' => $hint->content,
                    'sort_order' => $hint->sort_order,
                ]);
            }
        }
        $this->command->info("  → Missing Link: {$rows->count()} challenges migrated");
    }

    private function migrateCareers(int $genreId): void
    {
        $rows = DB::table('career_challenges')->get();
        foreach ($rows as $row) {
            // Get career clubs for this challenge
            $clubs = DB::table('career_clubs')
                ->where('career_challenge_id', $row->id)
                ->orderBy('sort_order')
                ->get()
                ->map(fn($cc) => [
                    'club_id' => $cc->club_id,
                    'year' => $cc->join_year,
                    'sort_order' => $cc->sort_order,
                ])
                ->toArray();

            $challenge = Challenge::create([
                'game_id' => $row->game_id,
                'genre_id' => $genreId,
                'difficulty' => $row->difficulty ?? 'medium',
                'stimulus_type' => 'sequence',
                'stimulus_data' => [
                    'clubs' => $clubs,
                    'player_image' => $row->player_image,
                ],
                'answer' => $row->player_name,
                'is_active' => $row->is_active ?? true,
            ]);

            $hints = DB::table('career_hints')->where('career_challenge_id', $row->id)->orderBy('sort_order')->get();
            foreach ($hints as $hint) {
                ChallengeHint::create([
                    'challenge_id' => $challenge->id,
                    'content' => $hint->content,
                    'sort_order' => $hint->sort_order,
                ]);
            }
        }
        $this->command->info("  → Career Path: {$rows->count()} challenges migrated");
    }

    private function migrateTransferChains(int $genreId): void
    {
        $rows = DB::table('transfer_chain_challenges')->get();
        foreach ($rows as $row) {
            $answers = json_decode($row->answers, true);

            $challenge = Challenge::create([
                'game_id' => $row->game_id,
                'genre_id' => $genreId,
                'difficulty' => $row->difficulty ?? 'medium',
                'stimulus_type' => 'text',
                'stimulus_data' => [
                    'club_a' => $row->club_a,
                    'club_b' => $row->club_b,
                ],
                'answer' => is_array($answers) ? $answers[0] : $row->club_a, // primary answer
                'answers' => $answers, // all valid answers
                'is_active' => $row->is_active ?? true,
            ]);

            $hints = DB::table('transfer_chain_hints')->where('transfer_chain_challenge_id', $row->id)->orderBy('sort_order')->get();
            foreach ($hints as $hint) {
                ChallengeHint::create([
                    'challenge_id' => $challenge->id,
                    'content' => $hint->content,
                    'sort_order' => $hint->sort_order,
                ]);
            }
        }
        $this->command->info("  → Transfer Chain: {$rows->count()} challenges migrated");
    }

    private function migrateGroups(int $genreId): void
    {
        $rows = DB::table('group_challenges')->get();
        foreach ($rows as $row) {
            $players = DB::table('group_challenge_players')
                ->where('group_challenge_id', $row->id)
                ->orderBy('sort_order')
                ->pluck('player_name')
                ->toArray();

            $challenge = Challenge::create([
                'game_id' => $row->game_id,
                'genre_id' => $genreId,
                'difficulty' => $row->difficulty ?? 'medium',
                'stimulus_type' => 'text',
                'stimulus_data' => [
                    'title' => $row->title,
                    'image' => $row->image,
                    'players_count' => $row->players_count,
                    'players' => $players,
                ],
                'answer' => $players[0] ?? 'unknown',
                'answers' => $players,
                'is_active' => $row->is_active ?? true,
            ]);

            $hints = DB::table('group_challenge_hints')->where('group_challenge_id', $row->id)->orderBy('sort_order')->get();
            foreach ($hints as $hint) {
                ChallengeHint::create([
                    'challenge_id' => $challenge->id,
                    'content' => $hint->content,
                    'sort_order' => $hint->sort_order,
                ]);
            }
        }
        $this->command->info("  → Group Challenge: {$rows->count()} challenges migrated");
    }

    private function verifyMigration(): void
    {
        $this->command->newLine();
        $this->command->info('── Verification ──');

        $legacyCounts = [
            'stadium_challenges' => DB::table('stadium_challenges')->count(),
            'kit_challenges' => DB::table('kit_challenges')->count(),
            'silhouette_challenges' => DB::table('silhouette_challenges')->count(),
            'videos' => DB::table('videos')->count(),
            'football_glossary_challenges' => DB::table('football_glossary_challenges')->count(),
            'anagram_challenges' => DB::table('anagram_challenges')->count(),
            'vowel_void_challenges' => DB::table('vowel_void_challenges')->count(),
            'missing_link_challenges' => DB::table('missing_link_challenges')->count(),
            'career_challenges' => DB::table('career_challenges')->count(),
            'transfer_chain_challenges' => DB::table('transfer_chain_challenges')->count(),
            'group_challenges' => DB::table('group_challenges')->count(),
        ];

        $expectedTotal = array_sum($legacyCounts);
        $actualTotal = Challenge::count();
        $actualHints = ChallengeHint::count();

        $legacyHintCounts = [
            DB::table('stadium_hints')->count(),
            DB::table('kit_hints')->count(),
            DB::table('silhouette_hints')->count(),
            DB::table('hints')->count(), // video hints
            DB::table('football_glossary_hints')->count(),
            DB::table('anagram_hints')->count(),
            DB::table('vowel_void_hints')->count(),
            DB::table('missing_link_hints')->count(),
            DB::table('career_hints')->count(),
            DB::table('transfer_chain_hints')->count(),
            DB::table('group_challenge_hints')->count(),
        ];
        $expectedHints = array_sum($legacyHintCounts);

        $this->command->info("Legacy challenges total: {$expectedTotal}");
        $this->command->info("Migrated challenges:     {$actualTotal}");
        $this->command->info("Legacy hints total:      {$expectedHints}");
        $this->command->info("Migrated hints:          {$actualHints}");

        if ($expectedTotal === $actualTotal && $expectedHints === $actualHints) {
            $this->command->info('✅ Migration PASSED — all rows accounted for!');
        } else {
            $this->command->error('❌ Migration MISMATCH — please investigate!');
        }
    }
}
