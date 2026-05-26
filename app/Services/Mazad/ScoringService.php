<?php

namespace App\Services\Mazad;

use App\Models\MazadAnswer;
use App\Models\MazadPlayer;
use App\Models\MazadRoom;
use App\Models\MazadRoomQuestion;

class ScoringService
{
    /**
     * Calculate scores for a completed question round (individual mode).
     * Returns array of ['player_id' => score] for this round.
     */
    public function scoreIndividualRound(MazadRoomQuestion $roomQuestion): array
    {
        $room = $roomQuestion->room;
        $scores = [];

        foreach ($room->players as $player) {
            $uniqueCorrect = $this->getUniqueCorrectCount($player, $roomQuestion);
            $player->increment('total_score', $uniqueCorrect);
            $scores[$player->id] = $uniqueCorrect;
        }

        return $scores;
    }

    /**
     * Calculate scores for a completed question round (teams mode).
     * Returns array of ['team_id' => score] for this round, plus individual contributions.
     */
    public function scoreTeamRound(MazadRoomQuestion $roomQuestion): array
    {
        $room = $roomQuestion->room;
        $teamScores = [];
        $playerContributions = [];

        foreach ($room->teams as $team) {
            // Collect ALL correct answers from all team members
            $allTeamAnswers = MazadAnswer::where('room_question_id', $roomQuestion->id)
                ->whereIn('player_id', $team->players->pluck('id'))
                ->where('is_correct', true)
                ->pluck('matched_answer')
                ->map(fn($a) => mb_strtolower(trim($a)))
                ->unique();

            $teamScore = $allTeamAnswers->count();
            $teamScores[$team->id] = $teamScore;

            // Track individual contributions (unique answers each player provided)
            foreach ($team->players as $player) {
                $playerContributions[$player->id] = $this->getUniqueCorrectCount($player, $roomQuestion);
            }
        }

        // Update player total scores with their individual contributions
        foreach ($playerContributions as $playerId => $contribution) {
            MazadPlayer::where('id', $playerId)->increment('total_score', $contribution);
        }

        return [
            'team_scores' => $teamScores,
            'player_contributions' => $playerContributions,
        ];
    }

    /**
     * Build the final leaderboard for a finished game.
     */
    public function buildLeaderboard(MazadRoom $room): array
    {
        if ($room->mode === 'teams') {
            return $this->buildTeamLeaderboard($room);
        }

        return $this->buildIndividualLeaderboard($room);
    }

    private function buildIndividualLeaderboard(MazadRoom $room): array
    {
        return $room->players()
            ->with('user:id,name,avatar')
            ->orderByDesc('total_score')
            ->get()
            ->map(fn(MazadPlayer $p, int $index) => [
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

    private function buildTeamLeaderboard(MazadRoom $room): array
    {
        $teams = $room->teams()->with('players.user:id,name,avatar')->get();

        $teamResults = $teams->map(function ($team) use ($room) {
            $roomQuestionIds = $room->roomQuestions()->pluck('id');
            $totalTeamScore = 0;

            foreach ($roomQuestionIds as $rqId) {
                $totalTeamScore += MazadAnswer::where('room_question_id', $rqId)
                    ->whereIn('player_id', $team->players->pluck('id'))
                    ->where('is_correct', true)
                    ->pluck('matched_answer')
                    ->map(fn($a) => mb_strtolower(trim($a)))
                    ->unique()
                    ->count();
            }

            return [
                'team_id' => $team->id,
                'team_name' => $team->name,
                'team_color' => $team->color,
                'score' => $totalTeamScore,
                'members' => $team->players
                    ->sortByDesc('total_score')
                    ->values()
                    ->map(fn(MazadPlayer $p) => [
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

    private function getUniqueCorrectCount(MazadPlayer $player, MazadRoomQuestion $roomQuestion): int
    {
        return $player->answers()
            ->where('room_question_id', $roomQuestion->id)
            ->where('is_correct', true)
            ->distinct('matched_answer')
            ->count('matched_answer');
    }
}
