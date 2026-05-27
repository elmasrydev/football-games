<?php

namespace App\Http\Controllers\Silhouette;

use App\Http\Controllers\Controller;
use App\Models\SilhouettePlayer;
use App\Models\Challenge;
use App\Models\SilhouetteRoom;
use App\Models\SilhouetteRoomQuestion;
use App\Models\SilhouetteTeam;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Events\Silhouette\RoomUpdated;
use App\Events\Silhouette\PlayerJoined;
use App\Events\Silhouette\PlayerLeft;
use App\Events\Silhouette\GameStarting;
use App\Jobs\Silhouette\StartQuestionJob;

class RoomController extends Controller
{
    public function index(): JsonResponse
    {
        $rooms = SilhouetteRoom::where('visibility', 'public')
            ->where('status', 'waiting')
            ->with('owner:id,name,avatar')
            ->withCount('players')
            ->orderByDesc('created_at')
            ->get()
            ->map(fn(SilhouetteRoom $room) => [
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

        if ($validated['min_players_to_start'] > $validated['max_players']) {
            $validated['min_players_to_start'] = $validated['max_players'];
        }

        if (isset($validated['auto_start_at'])) {
            $validated['auto_start_at'] = min($validated['auto_start_at'], $validated['max_players']);
            $validated['auto_start_at'] = max($validated['auto_start_at'], $validated['min_players_to_start']);
        }

        if ($validated['mode'] === 'teams' && empty($validated['num_teams'])) {
            $validated['num_teams'] = 2;
        }

        $room = DB::transaction(function () use ($validated) {
            $room = SilhouetteRoom::create(array_merge($validated, [
                'owner_id' => Auth::id(),
                'language' => $validated['language'] ?? 'mix',
            ]));

            // Add owner as first player
            SilhouettePlayer::create([
                'room_id' => $room->id,
                'user_id' => Auth::id(),
                'is_owner' => true,
            ]);

            // Create teams if teams mode
            if ($room->mode === 'teams') {
                $teamColors = ['#6366f1', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899'];
                for ($i = 1; $i <= $room->num_teams; $i++) {
                    SilhouetteTeam::create([
                        'room_id' => $room->id,
                        'name' => "Team {$i}",
                        'color' => $teamColors[$i - 1] ?? '#6366f1',
                    ]);
                }
            }

            // Pre-select random questions for this room based on language and genres from Challenges table (game_id = 1)
            $query = Challenge::where('game_id', 1)->where('is_active', true);

            if ($room->language === 'ar') {
                $query->where('language', 'ar');
            } elseif ($room->language === 'en') {
                $query->where('language', 'en');
            }

            if (!empty($room->genres)) {
                $genreIds = Genre::whereIn('slug', $room->genres)->pluck('id')->toArray();
                if (!empty($genreIds)) {
                    $query->whereIn('genre_id', $genreIds);
                }
            }

            $challenges = $query->inRandomOrder()
                ->limit($room->num_questions)
                ->get();

            // Fallback: if we don't have enough matching questions, fill in the rest
            if ($challenges->count() < $room->num_questions) {
                $missingCount = $room->num_questions - $challenges->count();
                $excludeIds = $challenges->pluck('id')->toArray();

                $extraQuery = Challenge::where('game_id', 1)
                    ->where('is_active', true)
                    ->whereNotIn('id', $excludeIds);

                if ($room->language === 'ar') {
                    $extraQuery->where('language', 'ar');
                } elseif ($room->language === 'en') {
                    $extraQuery->where('language', 'en');
                }

                $extraChallenges = $extraQuery->inRandomOrder()
                    ->limit($missingCount)
                    ->get();

                $challenges = $challenges->concat($extraChallenges);
            }

            foreach ($challenges as $index => $challenge) {
                SilhouetteRoomQuestion::create([
                    'room_id' => $room->id,
                    'challenge_id' => $challenge->id,
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

    public function show(string $locale, string $code): JsonResponse
    {
        $room = SilhouetteRoom::where('code', $code)
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
                    $myAnswers = \App\Models\SilhouetteAnswer::where('room_question_id', $rq->id)
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

                    $scoringService = resolve(\App\Services\Silhouette\ScoringService::class);
                    $restResults = $room->mode === 'teams'
                        ? $scoringService->scoreTeamRound($rq)
                        : $scoringService->scoreIndividualRound($rq);
                }

                $challenge = $rq->challenge;
                $imagePath = $challenge->image_path ?? ($challenge->stimulus_data['image_path'] ?? null);

                $currentQuestionData = [
                    'question_index' => $rq->question_order,
                    'total_questions' => $room->num_questions,
                    'question_text' => $challenge->question ?? 'Who is this?',
                    'question_text_ar' => $challenge->question_ar ?? ($challenge->question ?? 'من هذا؟'),
                    'image_path' => $imagePath,
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
                'players' => $room->players->map(fn(SilhouettePlayer $p) => [
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
                'teams' => $room->teams->map(fn(SilhouetteTeam $t) => [
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

    public function join(string $locale, string $code): JsonResponse
    {
        $room = SilhouetteRoom::where('code', $code)->firstOrFail();
        $userId = Auth::id();

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

        $player = SilhouettePlayer::create([
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

    public function leave(string $locale, string $code): JsonResponse
    {
        $room = SilhouetteRoom::where('code', $code)->firstOrFail();
        $userId = Auth::id();

        $player = $room->getPlayer($userId);
        if (!$player) {
            return response()->json(['message' => 'You are not in this room'], 422);
        }

        if (in_array($room->status, ['starting', 'in_progress'])) {
            $player->update([
                'is_connected' => false,
                'disconnected_at' => now(),
            ]);

            broadcast(new PlayerLeft($room, $userId))->toOthers();

            return response()->json(['message' => 'Disconnected from room']);
        }

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

    public function destroy(string $locale, string $code): JsonResponse
    {
        $room = SilhouetteRoom::where('code', $code)->firstOrFail();

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

    public function autoAssignTeams(string $locale, string $code): JsonResponse
    {
        $room = SilhouetteRoom::where('code', $code)->firstOrFail();

        if ((int)$room->owner_id !== (int)Auth::id()) {
            return response()->json(['message' => 'Only the room owner can assign teams'], 403);
        }

        if ($room->mode !== 'teams') {
            return response()->json(['message' => 'Room is not in teams mode'], 422);
        }

        $teams = $room->teams()->get();
        $players = $room->players()->get()->shuffle();

        $players->each(function (SilhouettePlayer $player, int $index) use ($teams) {
            $team = $teams[$index % $teams->count()];
            $player->update(['team_id' => $team->id]);
        });

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

    public function assignTeam(Request $request, string $locale, string $code): JsonResponse
    {
        $room = SilhouetteRoom::where('code', $code)->firstOrFail();

        if ((int)$room->owner_id !== (int)Auth::id()) {
            return response()->json(['message' => 'Only the room owner can assign teams'], 403);
        }

        $validated = $request->validate([
            'player_id' => ['required', 'exists:silhouette_players,id'],
            'team_id' => ['nullable', 'exists:silhouette_teams,id'],
        ]);

        $player = SilhouettePlayer::where('id', $validated['player_id'])
            ->where('room_id', $room->id)
            ->firstOrFail();

        $team = null;
        if (!empty($validated['team_id'])) {
            $team = SilhouetteTeam::where('id', $validated['team_id'])
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
