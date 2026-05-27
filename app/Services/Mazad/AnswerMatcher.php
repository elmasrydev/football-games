<?php

namespace App\Services\Mazad;

class AnswerMatcher
{
    /**
     * Check if the player's input matches any accepted answer (by GameItem IDs).
     * Returns the matched GameItem ID or null.
     */
    public function match(string $input, array $acceptedAnswerIds): ?int
    {
        $normalized = $this->normalize($input);

        if ($normalized === '' || empty($acceptedAnswerIds)) {
            return null;
        }

        // Fetch matching items
        $items = \App\Models\GameItem::whereIn('id', $acceptedAnswerIds)->get();

        // 1. Exact match (after normalization)
        foreach ($items as $item) {
            $options = [$item->name_en, $item->name_ar];
            if (isset($item->metadata['synonyms']) && is_array($item->metadata['synonyms'])) {
                $options = array_merge($options, $item->metadata['synonyms']);
            }

            foreach ($options as $option) {
                if ($option && $this->normalize($option) === $normalized) {
                    return $item->id;
                }
            }
        }

        // 2. Fuzzy match (Levenshtein)
        $threshold = mb_strlen($normalized) >= 5 ? 2 : 1;
        $bestMatchId = null;
        $bestDistance = PHP_INT_MAX;

        foreach ($items as $item) {
            $options = [$item->name_en, $item->name_ar];
            if (isset($item->metadata['synonyms']) && is_array($item->metadata['synonyms'])) {
                $options = array_merge($options, $item->metadata['synonyms']);
            }

            foreach ($options as $option) {
                if (!$option) continue;
                
                $normalizedOption = $this->normalize($option);
                $distance = $this->mbLevenshtein($normalizedOption, $normalized);

                if ($distance <= $threshold && $distance < $bestDistance) {
                    $bestDistance = $distance;
                    $bestMatchId = $item->id;
                }
            }
        }

        return $bestMatchId;
    }

    /**
     * Normalize text for comparison.
     * Handles Arabic diacritics, character normalization, and casing.
     */
    public function normalize(string $text): string
    {
        $text = mb_strtolower(trim($text));

        // Remove Arabic diacritics (tashkeel)
        $text = preg_replace('/[\x{064B}-\x{065F}\x{0670}]/u', '', $text);

        // Normalize Arabic characters
        $text = str_replace(['أ', 'إ', 'آ'], 'ا', $text);
        $text = str_replace('ة', 'ه', $text);
        $text = str_replace('ى', 'ي', $text);

        // Remove redundant whitespace
        $text = preg_replace('/\s+/', ' ', $text);

        return $text;
    }

    /**
     * Multibyte-safe Levenshtein distance.
     * PHP's built-in levenshtein() works at byte-level which breaks with Arabic/UTF-8.
     */
    private function mbLevenshtein(string $s1, string $s2): int
    {
        $chars1 = mb_str_split($s1);
        $chars2 = mb_str_split($s2);
        $len1 = count($chars1);
        $len2 = count($chars2);

        // Early exit for obvious cases
        if ($len1 === 0) return $len2;
        if ($len2 === 0) return $len1;
        if ($s1 === $s2) return 0;

        // Use a single-row DP approach for memory efficiency
        $previousRow = range(0, $len2);

        for ($i = 0; $i < $len1; $i++) {
            $currentRow = [$i + 1];

            for ($j = 0; $j < $len2; $j++) {
                $cost = ($chars1[$i] === $chars2[$j]) ? 0 : 1;
                $currentRow[] = min(
                    $currentRow[$j] + 1,       // insertion
                    $previousRow[$j + 1] + 1,   // deletion
                    $previousRow[$j] + $cost     // substitution
                );
            }

            $previousRow = $currentRow;
        }

        return $previousRow[$len2];
    }
}
