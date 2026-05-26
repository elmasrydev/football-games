<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\MazadRoom;
use App\Models\MazadPlayer;
use App\Models\MazadTeam;
use App\Models\MazadQuestion;
use App\Models\MazadRoomQuestion;
use App\Models\MazadAnswer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class MazadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed some base questions
        MazadQuestion::create([
            'text' => 'European capitals',
            'text_ar' => 'عواصم أوروبية',
            'category' => 'geography',
            'difficulty' => 'easy',
            'accepted_answers' => ['Paris', 'باريس', 'London', 'لندن', 'Rome', 'روما', 'Berlin', 'برلين'],
        ]);
    }

    public function test_user_can_create_room(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/en/mazad/rooms', [
            'visibility' => 'public',
            'max_players' => 10,
            'min_players_to_start' => 2,
            'num_questions' => 5,
            'question_time_seconds' => 60,
            'rest_time_seconds' => 10,
            'mode' => 'individual',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'room' => ['code', 'share_link']
        ]);

        $this->assertDatabaseHas('mazad_rooms', [
            'owner_id' => $user->id,
            'visibility' => 'public',
            'status' => 'waiting',
        ]);

        // The creator is automatically added as a player and marked as owner
        $this->assertDatabaseHas('mazad_players', [
            'user_id' => $user->id,
            'is_owner' => true,
        ]);
    }

    public function test_room_creation_validation(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/en/mazad/rooms', [
            'visibility' => 'invalid_visibility',
            'max_players' => 1, // too few
            'min_players_to_start' => 2,
            'num_questions' => 25, // too many
            'question_time_seconds' => 10, // too short
            'rest_time_seconds' => 10,
            'mode' => 'teams',
        ]);

        $response->assertStatus(422);
    }

    public function test_players_can_join_and_leave_room(): void
    {
        $owner = User::factory()->create();
        $room = MazadRoom::create([
            'owner_id' => $owner->id,
            'visibility' => 'public',
            'status' => 'waiting',
            'max_players' => 4,
            'min_players_to_start' => 2,
            'num_questions' => 2,
            'question_time_seconds' => 30,
            'rest_time_seconds' => 5,
            'mode' => 'individual',
        ]);

        // Owner is player
        MazadPlayer::create([
            'room_id' => $room->id,
            'user_id' => $owner->id,
            'is_owner' => true,
        ]);

        $player = User::factory()->create();

        // Join room
        $response = $this->actingAs($player)->postJson("/en/mazad/rooms/{$room->code}/join");
        $response->assertStatus(200);

        $this->assertDatabaseHas('mazad_players', [
            'room_id' => $room->id,
            'user_id' => $player->id,
        ]);

        // Leave room
        $response = $this->actingAs($player)->postJson("/en/mazad/rooms/{$room->code}/leave");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('mazad_players', [
            'room_id' => $room->id,
            'user_id' => $player->id,
        ]);
    }

    public function test_room_auto_starts_when_auto_start_at_reached(): void
    {
        Queue::fake();

        $owner = User::factory()->create();
        $room = MazadRoom::create([
            'owner_id' => $owner->id,
            'visibility' => 'public',
            'status' => 'waiting',
            'max_players' => 4,
            'min_players_to_start' => 2,
            'auto_start_at' => 3,
            'num_questions' => 2,
            'question_time_seconds' => 30,
            'rest_time_seconds' => 5,
            'mode' => 'individual',
        ]);

        MazadPlayer::create([
            'room_id' => $room->id,
            'user_id' => $owner->id,
            'is_owner' => true,
        ]);

        $player1 = User::factory()->create();
        $player2 = User::factory()->create();

        // Player 1 joins (count: 2) -> should NOT start yet
        $this->actingAs($player1)->postJson("/en/mazad/rooms/{$room->code}/join");
        $room->refresh();
        $this->assertEquals('waiting', $room->status);

        // Player 2 joins (count: 3) -> hits auto_start_at, should start!
        $this->actingAs($player2)->postJson("/en/mazad/rooms/{$room->code}/join");
        $room->refresh();
        $this->assertEquals('starting', $room->status);
    }

    public function test_fuzzy_answer_matching(): void
    {
        $owner = User::factory()->create();
        $room = MazadRoom::create([
            'owner_id' => $owner->id,
            'visibility' => 'public',
            'status' => 'in_progress',
            'max_players' => 4,
            'min_players_to_start' => 2,
            'num_questions' => 1,
            'question_time_seconds' => 30,
            'rest_time_seconds' => 5,
            'mode' => 'individual',
        ]);

        $player = MazadPlayer::create([
            'room_id' => $room->id,
            'user_id' => $owner->id,
            'is_owner' => true,
        ]);

        $question = MazadQuestion::first();
        $roomQuestion = MazadRoomQuestion::create([
            'room_id' => $room->id,
            'question_id' => $question->id,
            'question_order' => 0,
            'started_at' => now(),
        ]);

        // Exact match (English)
        $response = $this->actingAs($owner)->postJson("/en/mazad/rooms/{$room->code}/answer", [
            'answer' => 'Paris',
        ]);
        $response->assertJson(['status' => 'correct']);

        // Fuzzy match: 'Pris' -> matches 'Paris' (distance 1), should be duplicate
        $response = $this->actingAs($owner)->postJson("/en/mazad/rooms/{$room->code}/answer", [
            'answer' => 'Pris',
        ]);
        $response->assertJson(['status' => 'duplicate']);

        // Exact match (Arabic) - new spelling, should be correct
        $response = $this->actingAs($owner)->postJson("/en/mazad/rooms/{$room->code}/answer", [
            'answer' => 'باريس',
        ]);
        $response->assertJson(['status' => 'correct']);

        // Arabic normalization check: 'بَارِيس' (with tashkeel) normalizes to 'باريس', should be duplicate
        $response = $this->actingAs($owner)->postJson("/en/mazad/rooms/{$room->code}/answer", [
            'answer' => 'بَارِيس',
        ]);
        $response->assertJson(['status' => 'duplicate']);

        // Fuzzy match new answer: 'Berln' -> matches 'Berlin' (distance 1)
        $response = $this->actingAs($owner)->postJson("/en/mazad/rooms/{$room->code}/answer", [
            'answer' => 'Berln',
        ]);
        $response->assertJson(['status' => 'correct']);

        // Wrong answer
        $response = $this->actingAs($owner)->postJson("/en/mazad/rooms/{$room->code}/answer", [
            'answer' => 'Tokyo',
        ]);
        $response->assertJson(['status' => 'wrong']);
    }

    public function test_team_scoring_and_deduplication(): void
    {
        $owner = User::factory()->create();
        $room = MazadRoom::create([
            'owner_id' => $owner->id,
            'visibility' => 'public',
            'status' => 'in_progress',
            'max_players' => 4,
            'min_players_to_start' => 2,
            'num_questions' => 1,
            'question_time_seconds' => 30,
            'rest_time_seconds' => 5,
            'mode' => 'teams',
        ]);

        $team1 = MazadTeam::create(['room_id' => $room->id, 'name' => 'Team 1']);
        $team2 = MazadTeam::create(['room_id' => $room->id, 'name' => 'Team 2']);

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $player1 = MazadPlayer::create([
            'room_id' => $room->id,
            'user_id' => $user1->id,
            'team_id' => $team1->id,
        ]);

        $player2 = MazadPlayer::create([
            'room_id' => $room->id,
            'user_id' => $user2->id,
            'team_id' => $team1->id, // Both in Team 1
        ]);

        $question = MazadQuestion::first();
        $roomQuestion = MazadRoomQuestion::create([
            'room_id' => $room->id,
            'question_id' => $question->id,
            'question_order' => 0,
            'started_at' => now(),
        ]);

        // Player 1 answers 'Paris'
        $this->actingAs($user1)->postJson("/en/mazad/rooms/{$room->code}/answer", [
            'answer' => 'Paris',
        ]);

        // Player 2 answers 'Paris' (duplicate for player 2, should be accepted as duplicate spelling or already submitted)
        $response = $this->actingAs($user2)->postJson("/en/mazad/rooms/{$room->code}/answer", [
            'answer' => 'Paris',
        ]);
        // Since Player 2 hasn't submitted 'Paris' yet, they can submit it, but for the team score, it will only count once.
        // Wait, the GameController logic says:
        // "Check if this player already submitted this exact answer (normalized) for this question"
        // Since Player 2 hasn't submitted it themselves, they get 'correct'!
        $response->assertJson(['status' => 'correct']);

        // Player 2 also answers 'London'
        $this->actingAs($user2)->postJson("/en/mazad/rooms/{$room->code}/answer", [
            'answer' => 'London',
        ]);

        // Score the round using ScoringService
        $scoringService = new \App\Services\Mazad\ScoringService();
        $roundResults = $scoringService->scoreTeamRound($roomQuestion);

        // Team score should be 2: 'Paris' (deduplicated) and 'London'
        $this->assertEquals(2, $roundResults['team_scores'][$team1->id]);

        // Player 1 contribution: 1 ('Paris')
        $this->assertEquals(1, $roundResults['player_contributions'][$player1->id]);

        // Player 2 contribution: 2 ('Paris', 'London')
        $this->assertEquals(2, $roundResults['player_contributions'][$player2->id]);
    }

    public function test_user_can_create_room_with_genres_and_language(): void
    {
        // Seed another question in a different category and language
        MazadQuestion::create([
            'text' => 'Some actors question',
            'text_ar' => 'سؤال ممثلين',
            'category' => 'entertainment',
            'difficulty' => 'easy',
            'accepted_answers' => ['Ahmed', 'أحمد'],
        ]);

        // Create a genre in DB for validation
        \App\Models\Genre::updateOrCreate(['slug' => 'football'], [
            'name_en' => 'Football',
            'name_ar' => 'كرة القدم',
            'icon' => '⚽',
        ]);
        \App\Models\Genre::updateOrCreate(['slug' => 'actors'], [
            'name_en' => 'Actors',
            'name_ar' => 'الممثلين',
            'icon' => '🎭',
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/en/mazad/rooms', [
            'visibility' => 'public',
            'max_players' => 10,
            'min_players_to_start' => 2,
            'num_questions' => 2,
            'question_time_seconds' => 60,
            'rest_time_seconds' => 10,
            'mode' => 'individual',
            'language' => 'ar',
            'genres' => ['football', 'actors'],
        ]);

        $response->assertStatus(201);

        $room = MazadRoom::where('owner_id', $user->id)->first();
        $this->assertEquals('ar', $room->language);
        $this->assertEquals(['football', 'actors'], $room->genres);

        // Ensure questions seeded to the room have text_ar not null
        $roomQuestions = $room->roomQuestions()->with('question')->get();
        $this->assertNotEmpty($roomQuestions);
        foreach ($roomQuestions as $rq) {
            $this->assertNotNull($rq->question->text_ar);
        }
    }

    public function test_multiplayer_games_are_listed_on_multiplayer_page_and_excluded_from_library(): void
    {
        // Create an active multiplayer game and a single player game
        $multiGame = \App\Models\Game::updateOrCreate(['slug' => 'mazad'], [
            'title' => 'Mazad',
            'name_ar' => 'مزاد',
            'game_type' => 'multiplayer',
            'is_active' => true,
        ]);

        $singleGame = \App\Models\Game::updateOrCreate(['slug' => 'guess-silhouette'], [
            'title' => 'Silhouette Identity',
            'name_ar' => 'هوية الظل',
            'game_type' => 'image_guess',
            'is_active' => true,
        ]);

        $genre = \App\Models\Genre::create([
            'name_en' => 'Test Genre',
            'name_ar' => 'قسم تجريبي',
            'slug' => 'test-genre',
            'is_active' => true,
        ]);

        $singleGame->genres()->sync([$genre->id]);

        \App\Models\Challenge::create([
            'game_id' => $singleGame->id,
            'genre_id' => $genre->id,
            'language' => 'en',
            'is_active' => true,
            'answer' => 'test',
        ]);

        // Access multiplayer list page
        $response = $this->get('/en/multiplayer');
        $response->assertStatus(200);
        $response->assertSee('Mazad');
        $response->assertDontSee('Silhouette Identity');

        // Access library page (single player)
        $response = $this->get('/en/library');
        $response->assertStatus(200);
        // The count on index page lists single player games count
        $this->assertEquals(1, $response->viewData('totalGamesCount'));
    }

    public function test_reconnection_state_restoration(): void
    {
        $owner = User::factory()->create();
        $room = MazadRoom::create([
            'owner_id' => $owner->id,
            'visibility' => 'public',
            'status' => 'in_progress',
            'max_players' => 4,
            'min_players_to_start' => 2,
            'num_questions' => 1,
            'question_time_seconds' => 30,
            'rest_time_seconds' => 5,
            'mode' => 'individual',
        ]);

        $player = MazadPlayer::create([
            'room_id' => $room->id,
            'user_id' => $owner->id,
            'is_owner' => true,
        ]);

        $question = MazadQuestion::first();
        $roomQuestion = MazadRoomQuestion::create([
            'room_id' => $room->id,
            'question_id' => $question->id,
            'question_order' => 0,
            'started_at' => now(),
        ]);

        // Submit one correct answer and one incorrect answer
        MazadAnswer::create([
            'room_question_id' => $roomQuestion->id,
            'player_id' => $player->id,
            'answer_text' => 'Paris',
            'matched_answer' => 'Paris',
            'is_correct' => true,
        ]);
        MazadAnswer::create([
            'room_question_id' => $roomQuestion->id,
            'player_id' => $player->id,
            'answer_text' => 'Berlin',
            'matched_answer' => 'Berlin',
            'is_correct' => true,
        ]);

        // Fetch room details simulating reconnection/refresh
        $response = $this->actingAs($owner)->getJson("/en/mazad/rooms/{$room->code}");
        $response->assertStatus(200);
        $response->assertJsonPath('room.current_question.is_active', true);
        $response->assertJsonPath('room.current_question.question_text', 'European capitals');
        $response->assertJsonCount(2, 'room.current_question.my_answers');
        $this->assertEquals(2, $response->json('room.current_question.live_scores.' . $player->id));
    }

    public function test_team_results_contain_members(): void
    {
        $owner = User::factory()->create();
        $room = MazadRoom::create([
            'owner_id' => $owner->id,
            'visibility' => 'public',
            'status' => 'finished',
            'max_players' => 4,
            'min_players_to_start' => 2,
            'num_questions' => 1,
            'question_time_seconds' => 30,
            'rest_time_seconds' => 5,
            'mode' => 'teams',
        ]);

        $team = MazadTeam::create([
            'room_id' => $room->id,
            'name' => 'Team Alpha',
            'color' => 'blue',
        ]);

        $player = MazadPlayer::create([
            'room_id' => $room->id,
            'user_id' => $owner->id,
            'team_id' => $team->id,
            'is_owner' => true,
            'total_score' => 10,
        ]);

        $response = $this->actingAs($owner)->getJson("/en/mazad/rooms/{$room->code}/results");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'leaderboard' => [
                '*' => [
                    'team_id',
                    'team_name',
                    'team_color',
                    'score',
                    'members' => [
                        '*' => [
                            'player_id',
                            'name',
                            'avatar',
                            'score',
                        ]
                    ]
                ]
            ],
            'rounds',
            'mode',
        ]);

        $this->assertEquals($player->user->name, $response->json('leaderboard.0.members.0.name'));
    }
}
