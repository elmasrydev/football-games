<?php

namespace App\Services\Silhouette;

use App\Models\SilhouetteAnswer;
use App\Models\SilhouettePlayer;
use App\Models\SilhouetteRoom;
use App\Models\SilhouetteRoomQuestion;

class ScoringService
{
    public function scoreIndividualRound(SilhouetteRoomQuestion $roomQuestion): array
    {
        $room = $roomQuestion->room;
        $scores = [];

        // Check if there is a winning answer
        $winningAnswer = SilhouetteAnswer::where('room_question_id', $roomQuestion->id)
            ->where('is_winning', true)
            ->first();

        if ($winningAnswer) {
            $player = SilhouettePlayer::find($winningAnswer->player_id);
            if ($player) {
                $player->increment('total_score', 1);
                $scores[$player->id] = 1;
            }
        }

        return $scores;
    }

    public function scoreTeamRound(SilhouetteRoomQuestion $roomQuestion): array
    {
        $room = $roomQuestion->room;
        $teamScores = [];
        $playerContributions = [];

        // Check if there is a winning answer
        $winningAnswer = SilhouetteAnswer::where('room_question_id', $roomQuestion->id)
            ->where('is_winning', true)
            ->first();

        if ($winningAnswer) {
            $player = SilhouettePlayer::find($winningAnswer->player_id);
            if ($player) {
                $player->increment('total_score', 1);
                $playerContributions[$player->id] = 1;

                if ($player->team_id) {
                    $teamScores[$player->team_id] = 1;
                }
            }
        }

        return [
            'team_scores' => $teamScores,
            'player_contributions' => $playerContributions,
        ];
    }

    public function buildLeaderboard(SilhouetteRoom $room): array
    {
        if ($room->mode === 'teams') {
            return $this->buildTeamLeaderboard($room);
        }

        return $this->buildIndividualLeaderboard($room);
    }

    private function buildIndividualLeaderboard(SilhouetteRoom $room): array
    {
        return $room->players()
            ->with('user:id,name,avatar')
            ->orderByDesc('total_score')
            ->get()
            ->map(fn(SilhouettePlayer $p, int $index) => [
                'rank' => $index + 1,
                'player_id' => $p->id,
                'user_id' => $p->user_id,
                'name' => $p->user->name,
                'avatar' => $p->user->avatar,
                'score' => $p->total_score,
                'is_owner' => $p->is_owner,
            ])
            ->toArray();
    }

    private function buildTeamLeaderboard(SilhouetteRoom $room): array
    {
        $teams = $room->teams()->with('players.user:id,name,avatar')->get();

        $teamResults = $teams->map(function ($team) use ($room) {
            $roomQuestionIds = $room->roomQuestions()->pluck('id');
            
            // Total team score is the sum of wins in room questions
            $totalTeamScore = SilhouetteAnswer::whereIn('room_question_id', $roomQuestionIds)
                ->whereIn('player_id', $team->players->pluck('id'))
                ->where('is_winning', true)
                ->count();

            return [
                'team_id' => $team->id,
                'team_name' => $team->name,
                'team_color' => $team->color,
                'score' => $totalTeamScore,
                'members' => $team->players
                    ->sortByDesc('total_score')
                    ->values()
                    ->map(fn(SilhouettePlayer $p) => [
                        'player_id' => $p->id,
                        'name' => $p->user->name,
                        'avatar' => $p->user->avatar,
                        'score' => $p->total_score,
                    ])
                    ->toArray(),
            ];
        })
        ->sortByDesc('score')
        ->values();

        return $teamResults->map(fn($t, $i) => array_merge($t, ['rank' => $i + 1]))->toArray();
    }
}
