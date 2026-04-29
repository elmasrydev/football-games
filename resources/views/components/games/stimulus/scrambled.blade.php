@props(['challenge', 'game'])

<div class="scrambled-box">
    @if($game->slug === 'vowel-void')
        <div class="consonant-display">
            {{ $challenge->consonant_display ?? $challenge->stimulus_data['consonant_display'] ?? '' }}
        </div>
        @if(isset($challenge->stimulus_data['category']))
            <div class="category-badge">Category: {{ $challenge->stimulus_data['category'] }}</div>
        @endif
        <div class="stimulus-instruction">Fill in the missing vowels!</div>
    @else
        <div class="anagram-alphabet">
            @foreach(str_split($challenge->scrambled_word ?? $challenge->stimulus_data['scrambled_word'] ?? '') as $letter)
                <div class="letter-tile">{{ strtoupper($letter) }}</div>
            @endforeach
        </div>
        <div class="stimulus-instruction">Unscramble the letters!</div>
    @endif
</div>

<style>
    .scrambled-box {
        background: var(--surface); border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-soft); border-radius: 28px; padding: clamp(1rem, 3vw, 2rem);
        display: flex; flex-direction: column; justify-content: center; align-items: center; margin-bottom: 0.5rem;
        min-height: 220px;
    }
    
    /* Vowel Void in Scrambled container fallback */
    .consonant-display { font-size: clamp(2rem, 7vw, 3.5rem); font-weight: 900; letter-spacing: 8px; color: var(--text); font-family: 'Courier New', Courier, monospace; text-align: center; }
    .category-badge { margin-top: 1rem; padding: 0.5rem 1rem; background: rgba(var(--surface-muted-rgb), 0.9); border-radius: 20px; font-weight: 700; font-size: 0.9rem; color: var(--text-muted); border: 1px solid var(--border-soft); }

    /* Anagrams */
    .anagram-alphabet { display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center; }
    .letter-tile {
        width: 60px; height: 60px; background: rgba(var(--surface-rgb), 0.7); color: var(--accent-strong);
        display: flex; justify-content: center; align-items: center;
        font-size: 2rem; font-weight: 800; border-radius: 12px;
        box-shadow: var(--shadow-soft); transform: rotate(-2deg);
        border: 1px solid var(--border-soft);
    }
    .letter-tile:nth-child(even) { transform: rotate(3deg); }
    
    .stimulus-instruction { margin-top: 1.5rem; color: var(--text-soft); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.75rem; text-align: center; }
</style>
