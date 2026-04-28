<?php

namespace Tests\Feature;

use App\Models\AnagramChallenge;
use App\Models\FootballGlossaryChallenge;
use App\Models\Game;
use App\Models\MissingLinkChallenge;
use App\Models\TransferChainChallenge;
use App\Models\VowelVoidChallenge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WordGamesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create the football category and games
        $football = \App\Models\Category::create(['name' => 'Football', 'slug' => 'football']);
        
        Game::create(['slug' => 'anagram-arena', 'title' => 'Anagram Arena', 'category_id' => $football->id]);
        Game::create(['slug' => 'vowel-void', 'title' => 'Vowel Void', 'category_id' => $football->id]);
        Game::create(['slug' => 'missing-link', 'title' => 'Missing Link', 'category_id' => $football->id]);
        Game::create(['slug' => 'football-glossary', 'title' => 'Football Glossary', 'category_id' => $football->id]);
        Game::create(['slug' => 'transfer-chain', 'title' => 'Transfer Chain', 'category_id' => $football->id]);
    }

    public function test_anagram_arena_play_page()
    {
        $game = Game::where('slug', 'anagram-arena')->first();
        $challenge = AnagramChallenge::create([
            'game_id' => $game->id,
            'scrambled_word' => 'SSIME',
            'answer' => 'Messi',
            'difficulty' => 'easy'
        ]);

        $response = $this->get(route('games.anagram.play', $challenge->id));
        $response->assertStatus(200);
        $response->assertSee('SSIME');
    }

    public function test_anagram_check_answer()
    {
        $game = Game::where('slug', 'anagram-arena')->first();
        $challenge = AnagramChallenge::create([
            'game_id' => $game->id,
            'scrambled_word' => 'SSIME',
            'answer' => 'Messi',
            'difficulty' => 'easy'
        ]);

        $response = $this->post("/anagram/{$challenge->id}/check", [
            'answer' => 'Messi'
        ]);

        $response->assertJson(['correct' => true]);

        $response = $this->post("/anagram/{$challenge->id}/check", [
            'answer' => 'Wrong'
        ]);

        $response->assertJson(['correct' => false]);
    }

    public function test_vowel_void_check_answer()
    {
        $game = Game::where('slug', 'vowel-void')->first();
        $challenge = VowelVoidChallenge::create([
            'game_id' => $game->id,
            'answer' => 'Ronaldo',
            'category' => 'player',
            'difficulty' => 'easy'
        ]);

        $response = $this->post("/vowel-void/{$challenge->id}/check", [
            'answer' => 'Ronaldo'
        ]);

        $response->assertJson(['correct' => true]);
    }

    public function test_missing_link_check_answer()
    {
        $game = Game::where('slug', 'missing-link')->first();
        $challenge = MissingLinkChallenge::create([
            'game_id' => $game->id,
            'part_a' => 'Champions',
            'part_b' => 'Final',
            'answer' => 'League',
            'difficulty' => 'easy'
        ]);

        $response = $this->post("/missing-link/{$challenge->id}/check", [
            'answer' => 'League'
        ]);

        $response->assertJson(['correct' => true]);
    }

    public function test_transfer_chain_check_answer()
    {
        $game = Game::where('slug', 'transfer-chain')->first();
        $challenge = TransferChainChallenge::create([
            'game_id' => $game->id,
            'club_a' => 'Barcelona',
            'club_b' => 'PSG',
            'answers' => ['Messi', 'Neymar'],
            'difficulty' => 'easy'
        ]);

        $response = $this->post("/transfer-chain/{$challenge->id}/check", [
            'answer' => 'Messi'
        ]);

        $response->assertJson(['correct' => true]);

        $response = $this->post("/transfer-chain/{$challenge->id}/check", [
            'answer' => 'Neymar'
        ]);

        $response->assertJson(['correct' => true]);
    }
}
