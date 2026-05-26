<?php

namespace App\Http\Controllers\Mazad;

use App\Http\Controllers\Controller;
use App\Models\MazadPlayer;
use App\Models\MazadQuestion;
use App\Models\MazadRoom;
use App\Models\MazadRoomQuestion;
use App\Models\MazadTeam;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Events\Mazad\RoomUpdated;
use App\Events\Mazad\PlayerJoined;
use App\Events\Mazad\PlayerLeft;
use App\Events\Mazad\GameStarting;
use App\Jobs\Mazad\StartQuestionJob;

class RoomController extends Controller
{
    /**
     * List public rooms that are waiting for players.
     */
    public function index(): JsonResponse
    {
        $rooms = MazadRoom::where('visibility', 'public')
            ->where('status', 'waiting')
            ->with('owner:id,name,avatar')
            ->withCount('players')
            ->orderByDesc('created_at')
            ->get()
            ->map(fn(MazadRoom $room) => [
                'code' => $room->code,
                'owner' => [
                    'name' => $room->owner->name,
                    'avatar' => $room->owner->avatar,
                ],
                'mode' => $room->mode,
                'players_count' => $room->players_count,
                'max_players' => $room->max_players,
                'num_questions' => $room->num_questions,
                'question_time_seconds' => $room->question_time_seconds,
                'is_full' => $room->players_count >= $room->max_players,
                'created_at' => $room->created_at->diffForHumans(),
            ]);

        return response()->json(['rooms' => $rooms]);
    }

    /**
     * Create a new room.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'visibility' => ['required', Rule::in(['public', 'private'])],
            'max_players' => ['required', 'integer', 'min:2', 'max:50'],
            'min_players_to_start' => ['required', 'integer', 'min:2'],
            'auto_start_at' => ['nullable', 'integer', 'min:2'],
            'num_questions' => ['required', 'integer', 'min:1', 'max:20'],
            'question_time_seconds' => ['required', 'integer', 'min:15', 'max:120'],
            'rest_time_seconds' => ['required', 'integer', 'min:5', 'max:30'],
            'mode' => ['required', Rule::in(['individual', 'teams'])],
            'num_teams' => ['nullable', 'integer', 'min:2', 'max:6'],
            'language' => ['nullable', Rule::in(['en', 'ar', 'mix'])],
            'genres' => ['nullable', 'array'],
            'genres.*' => ['string', 'exists:genres,slug'],
        ]);

        // Ensure min_players_to_start <= max_players
        if ($validated['min_players_to_start'] > $validated['max_players']) {
            $validated['min_players_to_start'] = $validated['max_players'];
        }

        // Ensure auto_start_at is within range
        if (isset($validated['auto_start_at'])) {
            $validated['auto_start_at'] = min($validated['auto_start_at'], $validated['max_players']);
            $validated['auto_start_at'] = max($validated['auto_start_at'], $validated['min_players_to_start']);
        }

        // Teams mode requires num_teams
        if ($validated['mode'] === 'teams' && empty($validated['num_teams'])) {
            $validated['num_teams'] = 2;
        }

        $genreToCategoryMap = [
            'football' => ['football', 'sports'],
            'actors' => ['entertainment', 'music'],
            'movies' => ['cinema'],
            'geography' => ['geography', 'general', 'history', 'science', 'language', 'animals', 'food']
        ];

        $room = DB::transaction(function () use ($validated, $genreToCategoryMap) {
            $room = MazadRoom::create(array_merge($validated, [
                'owner_id' => Auth::id(),
                'language' => $validated['language'] ?? 'mix',
            ]));

            // Add owner as first player
            MazadPlayer::create([
                'room_id' => $room->id,
                'user_id' => Auth::id(),
                'is_owner' => true,
            ]);

            // Create teams if teams mode
            if ($room->mode === 'teams') {
                $teamColors = ['#6366f1', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899'];
                for ($i = 1; $i <= $room->num_teams; $i++) {
                    MazadTeam::create([
                        'room_id' => $room->id,
                        'name' => "Team {$i}",
                        'color' => $teamColors[$i - 1] ?? '#6366f1',
                    ]);
                }
            }

            // Pre-select random questions for this room based on language and genres
            $query = MazadQuestion::query();

            if ($room->language === 'ar') {
                $query->whereNotNull('text_ar');
            } elseif ($room->language === 'en') {
                $query->whereNotNull('text');
            }

            if (!empty($room->genres)) {
                $categories = [];
                foreach ($room->genres as $genreSlug) {
                    if (isset($genreToCategoryMap[$genreSlug])) {
                        $categories = array_merge($categories, $genreToCategoryMap[$genreSlug]);
                    }
                }
                if (!empty($categories)) {
                    $query->whereIn('category', $categories);
                }
            }

            $questions = $query->inRandomOrder()
                ->limit($room->num_questions)
                ->get();

            // Fallback: if we don't have enough matching questions, fill in the rest
            if ($questions->count() < $room->num_questions) {
                $missingCount = $room->num_questions - $questions->count();
                $excludeIds = $questions->pluck('id')->toArray();

                $extraQuery = MazadQuestion::whereNotIn('id', $excludeIds);
                if ($room->language === 'ar') {
                    $extraQuery->whereNotNull('text_ar');
                } elseif ($room->language === 'en') {
                    $extraQuery->whereNotNull('text');
                }

                $extraQuestions = $extraQuery->inRandomOrder()
                    ->limit($missingCount)
                    ->get();

                $questions = $questions->concat($extraQuestions);
            }

            foreach ($questions as $index => $question) {
                MazadRoomQuestion::create([
                    'room_id' => $room->id,
                    'question_id' => $question->id,
                    'question_order' => $index,
                ]);
            }

            return $room;
        });

        if ($room->visibility === 'public') {
            broadcast(new RoomUpdated($room))->toOthers();
        }

        return response()->json([
            'room' => [
                'code' => $room->code,
                'share_link' => $room->share_link,
            ],
        ], 201);
    }

    /**
     * Get room details.
     */
    public function show(string $locale, string $code): JsonResponse
    {
        $room = MazadRoom::where('code', $code)
            ->with([
                'owner:id,name,avatar',
                'players.user:id,name,avatar',
                'players.team:id,name,color',
                'teams',
            ])
            ->firstOrFail();

        $currentQuestionData = null;
        if ($room->status === 'in_progress') {
            $rq = $room->currentRoomQuestion();
            if ($rq) {
                $isRest = $rq->ended_at !== null;
                $now = now();

                $myPlayer = $room->getPlayer(Auth::id());
                $myAnswers = [];
                if ($myPlayer) {
                    $myAnswers = \App\Models\MazadAnswer::where('room_question_id', $rq->id)
                        ->where('player_id', $myPlayer->id)
                        ->get()
                        ->map(fn($ans) => [
                            'text' => $ans->answer_text,
                            'correct' => (bool)$ans->is_correct,
                        ])
                        ->toArray();
                }

                $liveScores = [];
                foreach ($room->players as $p) {
                    $liveScores[$p->id] = $p->correctCountForQuestion($rq->id);
                }

                $endTime = $rq->started_at ? $rq->started_at->addSeconds($room->question_time_seconds) : null;

                $restRemaining = 0;
                $restResults = null;
                if ($isRest && $rq->ended_at) {
                    $restEnd = $rq->ended_at->addSeconds($room->rest_time_seconds);
                    $restRemaining = max(0, $restEnd->diffInSeconds($now, false) * -1);

                    $scoringService = resolve(\App\Services\Mazad\ScoringService::class);
                    $restResults = $room->mode === 'teams'
                        ? $scoringService->scoreTeamRound($rq)
                        : $scoringService->scoreIndividualRound($rq);
                }

                $currentQuestionData = [
                    'question_index' => $rq->question_order,
                    'total_questions' => $room->num_questions,
                    'question_text' => $rq->question->text,
                    'question_text_ar' => $rq->question->text_ar ?? $rq->question->text,
                    'started_at' => $rq->started_at ? $rq->started_at->toISOString() : null,
                    'end_time' => $endTime ? $endTime->toISOString() : null,
                    'time_seconds' => $room->question_time_seconds,
                    'is_active' => !$isRest,
                    'is_rest' => $isRest,
                    'rest_remaining_seconds' => (int)$restRemaining,
                    'my_answers' => $myAnswers,
                    'live_scores' => $liveScores,
                    'rest_results' => $restResults,
                ];
            }
        }

        return response()->json([
            'room' => [
                'code' => $room->code,
                'visibility' => $room->visibility,
                'status' => $room->status,
                'mode' => $room->mode,
                'max_players' => $room->max_players,
                'min_players_to_start' => $room->min_players_to_start,
                'auto_start_at' => $room->auto_start_at,
                'num_questions' => $room->num_questions,
                'question_time_seconds' => $room->question_time_seconds,
                'rest_time_seconds' => $room->rest_time_seconds,
                'num_teams' => $room->num_teams,
                'share_link' => $room->share_link,
                'owner' => [
                    'id' => $room->owner->id,
                    'name' => $room->owner->name,
                    'avatar' => $room->owner->avatar,
                ],
                'players' => $room->players->map(fn(MazadPlayer $p) => [
                    'id' => $p->id,
                    'user_id' => $p->user_id,
                    'name' => $p->user->name,
                    'avatar' => $p->user->avatar,
                    'is_owner' => $p->is_owner,
                    'is_connected' => $p->is_connected,
                    'team' => $p->team ? [
                        'id' => $p->team->id,
                        'name' => $p->team->name,
                        'color' => $p->team->color,
                    ] : null,
                    'total_score' => $p->total_score,
                ]),
                'teams' => $room->teams->map(fn(MazadTeam $t) => [
                    'id' => $t->id,
                    'name' => $t->name,
                    'color' => $t->color,
                ]),
                'is_current_user_owner' => (int)$room->owner_id === (int)Auth::id(),
                'is_current_user_player' => $room->hasPlayer(Auth::id()),
                'current_question' => $currentQuestionData,
            ],
        ]);
    }

    /**
     * Join a room.
     */
    public function join(string $locale, string $code): JsonResponse
    {
        $room = MazadRoom::where('code', $code)->firstOrFail();
        $userId = Auth::id();

        // Check if already in the room (reconnection case)
        $existingPlayer = $room->getPlayer($userId);
        if ($existingPlayer) {
            $existingPlayer->update([
                'is_connected' => true,
                'disconnected_at' => null,
            ]);

            $playerPayload = [
                'id' => $existingPlayer->id,
                'user_id' => $existingPlayer->user_id,
                'name' => $existingPlayer->user->name,
                'avatar' => $existingPlayer->user->avatar,
                'is_owner' => $existingPlayer->is_owner,
                'is_connected' => true,
                'team' => $existingPlayer->team ? [
                    'id' => $existingPlayer->team->id,
                    'name' => $existingPlayer->team->name,
                    'color' => $existingPlayer->team->color,
                ] : null,
                'total_score' => $existingPlayer->total_score,
            ];

            broadcast(new PlayerJoined($room, $playerPayload))->toOthers();

            if ($room->visibility === 'public') {
                broadcast(new RoomUpdated($room))->toOthers();
            }

            return response()->json([
                'message' => 'Reconnected to room',
                'player_id' => $existingPlayer->id,
            ]);
        }

        if (!$room->isJoinable()) {
            return response()->json(['message' => 'Room is not available for joining'], 422);
        }

        $player = MazadPlayer::create([
            'room_id' => $room->id,
            'user_id' => $userId,
            'is_owner' => false,
        ]);

        $playerPayload = [
            'id' => $player->id,
            'user_id' => $player->user_id,
            'name' => Auth::user()->name,
            'avatar' => Auth::user()->avatar,
            'is_owner' => false,
            'is_connected' => true,
            'team' => null,
            'total_score' => 0,
        ];

        broadcast(new PlayerJoined($room, $playerPayload))->toOthers();

        if ($room->visibility === 'public') {
            broadcast(new RoomUpdated($room))->toOthers();
        }

        // Auto start on specific number of players joined
        if ($room->auto_start_at && $room->players()->count() >= $room->auto_start_at && $room->status === 'waiting') {
            $room->update([
                'status' => 'starting',
                'started_at' => now(),
            ]);

            broadcast(new GameStarting($room, 3))->toOthers();

            StartQuestionJob::dispatch($room->id, 0)->delay(now()->addSeconds(3));

            if ($room->visibility === 'public') {
                broadcast(new RoomUpdated($room))->toOthers();
            }
        }

        return response()->json([
            'message' => 'Joined room successfully',
            'player_id' => $player->id,
        ]);
    }

    /**
     * Leave a room.
     */
    public function leave(string $locale, string $code): JsonResponse
    {
        $room = MazadRoom::where('code', $code)->firstOrFail();
        $userId = Auth::id();

        $player = $room->getPlayer($userId);
        if (!$player) {
            return response()->json(['message' => 'You are not in this room'], 422);
        }

        // If game is in progress, mark as disconnected instead of removing
        if (in_array($room->status, ['starting', 'in_progress'])) {
            $player->update([
                'is_connected' => false,
                'disconnected_at' => now(),
            ]);

            broadcast(new PlayerLeft($room, $userId))->toOthers();

            return response()->json(['message' => 'Disconnected from room']);
        }

        // If owner leaves while waiting, close the room
        if ($player->is_owner && $room->status === 'waiting') {
            $room->update(['status' => 'closed']);

            if ($room->visibility === 'public') {
                broadcast(new RoomUpdated($room))->toOthers();
            }

            return response()->json(['message' => 'Room closed']);
        }

        $player->delete();

        broadcast(new PlayerLeft($room, $userId))->toOthers();

        if ($room->visibility === 'public') {
            broadcast(new RoomUpdated($room))->toOthers();
        }

        return response()->json(['message' => 'Left room successfully']);
    }

    /**
     * Owner closes the room.
     */
    public function destroy(string $locale, string $code): JsonResponse
    {
        $room = MazadRoom::where('code', $code)->firstOrFail();

        if ((int)$room->owner_id !== (int)Auth::id()) {
            return response()->json(['message' => 'Only the room owner can close the room'], 403);
        }

        if ($room->status === 'in_progress') {
            return response()->json(['message' => 'Cannot close a room while game is in progress'], 422);
        }

        $room->update(['status' => 'closed']);

        if ($room->visibility === 'public') {
            broadcast(new RoomUpdated($room))->toOthers();
        }

        return response()->json(['message' => 'Room closed successfully']);
    }

    /**
     * Auto-assign players to teams (round-robin).
     */
    public function autoAssignTeams(string $locale, string $code): JsonResponse
    {
        $room = MazadRoom::where('code', $code)->firstOrFail();

        if ((int)$room->owner_id !== (int)Auth::id()) {
            return response()->json(['message' => 'Only the room owner can assign teams'], 403);
        }

        if ($room->mode !== 'teams') {
            return response()->json(['message' => 'Room is not in teams mode'], 422);
        }

        $teams = $room->teams()->get();
        $players = $room->players()->get()->shuffle();

        $players->each(function (MazadPlayer $player, int $index) use ($teams) {
            $team = $teams[$index % $teams->count()];
            $player->update(['team_id' => $team->id]);
        });

        // Broadcast PlayerJoined with owner's info to trigger loadRoom() on other clients
        $owner = $room->players()->where('is_owner', true)->first();
        if ($owner) {
            $ownerPayload = [
                'id' => $owner->id,
                'user_id' => $owner->user_id,
                'name' => $owner->user->name,
                'avatar' => $owner->user->avatar,
                'is_owner' => true,
                'is_connected' => $owner->is_connected,
                'team' => $owner->team ? [
                    'id' => $owner->team->id,
                    'name' => $owner->team->name,
                    'color' => $owner->team->color,
                ] : null,
                'total_score' => $owner->total_score,
            ];
            broadcast(new PlayerJoined($room, $ownerPayload))->toOthers();
        }

        return response()->json(['message' => 'Teams assigned successfully']);
    }

    /**
     * Manually assign a player to a team.
     */
    public function assignTeam(Request $request, string $locale, string $code): JsonResponse
    {
        $room = MazadRoom::where('code', $code)->firstOrFail();

        if ((int)$room->owner_id !== (int)Auth::id()) {
            return response()->json(['message' => 'Only the room owner can assign teams'], 403);
        }

        $validated = $request->validate([
            'player_id' => ['required', 'exists:mazad_players,id'],
            'team_id' => ['nullable', 'exists:mazad_teams,id'],
        ]);

        $player = MazadPlayer::where('id', $validated['player_id'])
            ->where('room_id', $room->id)
            ->firstOrFail();

        $team = null;
        if (!empty($validated['team_id'])) {
            $team = MazadTeam::where('id', $validated['team_id'])
                ->where('room_id', $room->id)
                ->firstOrFail();
            $player->update(['team_id' => $team->id]);
        } else {
            $player->update(['team_id' => null]);
        }

        $playerPayload = [
            'id' => $player->id,
            'user_id' => $player->user_id,
            'name' => $player->user->name,
            'avatar' => $player->user->avatar,
            'is_owner' => $player->is_owner,
            'is_connected' => $player->is_connected,
            'team' => $team ? [
                'id' => $team->id,
                'name' => $team->name,
                'color' => $team->color,
            ] : null,
            'total_score' => $player->total_score,
        ];
        broadcast(new PlayerJoined($room, $playerPayload))->toOthers();

        return response()->json(['message' => 'Player team assignment updated']);
    }
}
