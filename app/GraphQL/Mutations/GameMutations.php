<?php

namespace App\GraphQL\Mutations;

use App\Models\Challenge;

class GameMutations
{
    /**
     * Check string similarity with levenshtein distance.
     */
    private function checkSimilarity(string $userAnswer, string $correctAnswer, int $threshold = 2): bool
    {
        $userAnswer = strtolower(trim($userAnswer));
        $correctAnswer = strtolower(trim($correctAnswer));

        if ($userAnswer === $correctAnswer 
            || str_contains($correctAnswer, $userAnswer) 
            || str_contains($userAnswer, $correctAnswer)) {
            return true;
        }

        return levenshtein($userAnswer, $correctAnswer) <= $threshold;
    }

    /**
     * Unified answer checking — works for ALL game types.
     */
    public function checkAnswer($rootValue, array $args): array
    {
        $challenge = Challenge::with('game')->findOrFail($args['id']);
        $userAnswer = $args['answer'];
        $gameType = $challenge->game->game_type;
        $gameSlug = $challenge->game->slug;

        // ── Connection Guess: Group Challenge (multi-answer with order tracking) ──
        if ($gameSlug === 'group-players') {
            return $this->checkGroupAnswer($challenge, $userAnswer, $args['revealed_orders'] ?? []);
        }

        // ── Connection Guess: Transfer Chain (multiple valid answers) ──
        if ($gameSlug === 'transfer-chain') {
            return $this->checkMultiAnswer($challenge, $userAnswer);
        }

        // ── All other games: single answer check ──
        $correctAnswer = $challenge->answer;
        $threshold = in_array($gameSlug, ['career', 'stadium-spotter']) ? 3 : 2;
        $correct = $this->checkSimilarity($userAnswer, $correctAnswer, $threshold);

        $successMessages = [
            'stadium-spotter' => "Correct! Well done!",
            'kit-detective' => "Correct! That's the {$correctAnswer} kit!",
            'guess-silhouette' => "Correct! It's {$correctAnswer}!",
            'career' => "Correct! Well done!",
        ];

        return [
            'correct' => $correct,
            'message' => $correct 
                ? ($successMessages[$gameSlug] ?? 'Correct!') 
                : ($correct ? 'Correct!' : 'Wrong answer. Try again!'),
            'matched_sort_order' => null,
        ];
    }

    /**
     * Group Challenge: check if answer matches any unrevealed player.
     */
    private function checkGroupAnswer(Challenge $challenge, string $userAnswer, array $revealedOrders): array
    {
        $players = $challenge->stimulus_data['players'] ?? [];

        foreach ($players as $index => $playerName) {
            if (in_array($index, $revealedOrders)) continue;
            
            if ($this->checkSimilarity($userAnswer, $playerName, 2)) {
                return [
                    'correct' => true,
                    'message' => "Correct! That's {$playerName}!",
                    'matched_sort_order' => $index,
                ];
            }
        }

        return [
            'correct' => false,
            'message' => "Wrong answer or already revealed. Try again!",
            'matched_sort_order' => null,
        ];
    }

    /**
     * Transfer Chain: check against array of valid answers.
     */
    private function checkMultiAnswer(Challenge $challenge, string $userAnswer): array
    {
        $validAnswers = $challenge->answers ?? [$challenge->answer];
        
        foreach ($validAnswers as $ans) {
            if ($this->checkSimilarity($userAnswer, $ans)) {
                return [
                    'correct' => true,
                    'message' => 'Correct!',
                    'matched_sort_order' => null,
                ];
            }
        }

        return [
            'correct' => false,
            'message' => 'Wrong!',
            'matched_sort_order' => null,
        ];
    }

    /**
     * Unified hint retrieval — works for ALL game types.
     */
    public function getHint($rootValue, array $args): array
    {
        $challenge = Challenge::with('hints')->findOrFail($args['id']);
        $shownHints = $args['shown_hints'] ?? [];

        $nextHint = $challenge->hints()
            ->whereNotIn('id', $shownHints)
            ->orderBy('sort_order')
            ->first();

        return [
            'id' => $nextHint?->id,
            'hint' => $nextHint?->content,
            'message' => $nextHint ? null : 'No more hints available!',
        ];
    }

    /**
     * Unified reveal — works for ALL game types.
     */
    public function revealAnswer($rootValue, array $args): array
    {
        $challenge = Challenge::findOrFail($args['id']);

        return [
            'answer' => $challenge->answer,
            'answers' => $challenge->answers,
            'message' => null,
        ];
    }
}
