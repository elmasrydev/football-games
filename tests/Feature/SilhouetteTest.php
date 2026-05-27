<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Genre;
use App\Models\Game;
use App\Models\Challenge;
use App\Models\SilhouetteRoom;
use App\Models\SilhouettePlayer;
use App\Models\SilhouetteTeam;
use App\Models\SilhouetteRoomQuestion;
use App\Models\SilhouetteAnswer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SilhouetteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the game record
        Game::updateOrCreate(['slug' => 'silhouette'], [
            'title' => 'Silhouette Arena',
            'name_ar' => 'ساحة هوية الظل',
            'game_type' => 'multiplayer',
            'is_active' => true,
        ]);

        $singleGame = Game::updateOrCreate(['id' => 1, 'slug' => 'guess-silhouette'], [
            'title' => 'Silhouette Identity',
            'name_ar' => 'هوية الظل',
            'game_type' => 'image_guess',
            'is_active' => true,
        ]);

        $genre = Genre::create([
            'name_en' => 'Football',
            'name_ar' => 'كرة القدم',
            'slug' => 'football',
            'is_active' => true,
        ]);

        // Create a single player challenge (acts as question source)
        Challenge::create([
            'game_id' => $singleGame->id,
            'genre_id' => $genre->id,
            'language' => 'en',
            'is_active' => true,
            'difficulty' => 'easy',
            'answer' => 'Paris',
            'answers' => ['Paris', 'باريس'],
            'stimulus_data' => [
                'image_path' => 'challenges/silhouette_paris.png',
                'reveal_image_path' => 'challenges/reveals/paris.png',
                'question' => 'Which city has this silhouette?'
            ]
        ]);
    }

    public function test_user_can_create_silhouette_room(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/en/silhouette/rooms', [
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

        $this->assertDatabaseHas('silhouette_rooms', [
            'owner_id' => $user->id,
            'visibility' => 'public',
            'status' => 'waiting',
        ]);

        $this->assertDatabaseHas('silhouette_players', [
            'user_id' => $user->id,
            'is_owner' => true,
        ]);
    }

    public function test_players_can_join_and_leave_silhouette_room(): void
    {
        $owner = User::factory()->create();
        $room = SilhouetteRoom::create([
            'owner_id' => $owner->id,
            'visibility' => 'public',
            'status' => 'waiting',
            'max_players' => 4,
            'min_players_to_start' => 2,
            'num_questions' => 1,
            'question_time_seconds' => 30,
            'rest_time_seconds' => 5,
            'mode' => 'individual',
        ]);

        SilhouettePlayer::create([
            'room_id' => $room->id,
            'user_id' => $owner->id,
            'is_owner' => true,
        ]);

        $player = User::factory()->create();

        // Join
        $response = $this->actingAs($player)->postJson("/en/silhouette/rooms/{$room->code}/join");
        $response->assertStatus(200);

        $this->assertDatabaseHas('silhouette_players', [
            'room_id' => $room->id,
            'user_id' => $player->id,
        ]);

        // Leave
        $response = $this->actingAs($player)->postJson("/en/silhouette/rooms/{$room->code}/leave");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('silhouette_players', [
            'room_id' => $room->id,
            'user_id' => $player->id,
        ]);
    }

    public function test_first_correct_answer_wins_round_immediately(): void
    {
        Queue::fake();

        $owner = User::factory()->create();
        $room = SilhouetteRoom::create([
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

        $player1 = SilhouettePlayer::create([
            'room_id' => $room->id,
            'user_id' => $owner->id,
            'is_owner' => true,
        ]);

        $user2 = User::factory()->create();
        $player2 = SilhouettePlayer::create([
            'room_id' => $room->id,
            'user_id' => $user2->id,
        ]);

        $challenge = Challenge::first();
        $roomQuestion = SilhouetteRoomQuestion::create([
            'room_id' => $room->id,
            'challenge_id' => $challenge->id,
            'question_order' => 0,
            'started_at' => now(),
        ]);

        // Wrong answer does not end round
        $response = $this->actingAs($owner)->postJson("/en/silhouette/rooms/{$room->code}/answer", [
            'answer' => 'Tokyo',
        ]);
        $response->assertJson(['status' => 'wrong']);
        $this->assertNull($roomQuestion->fresh()->ended_at);

        // Player 1 correct answer ends round and wins
        $response = $this->actingAs($owner)->postJson("/en/silhouette/rooms/{$room->code}/answer", [
            'answer' => 'Paris',
        ]);
        $response->assertJson(['status' => 'correct']);
        $this->assertNotNull($roomQuestion->fresh()->ended_at);

        $this->assertDatabaseHas('silhouette_answers', [
            'room_question_id' => $roomQuestion->id,
            'player_id' => $player1->id,
            'is_correct' => true,
            'is_winning' => true,
        ]);

        // Player 2 trying to answer correct now gets "too late"
        $response = $this->actingAs($user2)->postJson("/en/silhouette/rooms/{$room->code}/answer", [
            'answer' => 'Paris',
        ]);
        $response->assertJson(['status' => 'too_late']);
    }
}
