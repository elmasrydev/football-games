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
        background: white; border: 1px solid var(--glass-border);
        box-shadow: var(--shadow); border-radius: 20px; padding: 3rem;
        display: flex; flex-direction: column; justify-content: center; align-items: center; margin-bottom: 1rem;
        min-height: 300px;
    }
    
    /* Vowel Void in Scrambled container fallback */
    .consonant-display { font-size: 3.5rem; font-weight: 900; letter-spacing: 8px; color: var(--pitch-dark); font-family: 'Courier New', Courier, monospace; }
    .category-badge { margin-top: 1rem; padding: 0.5rem 1rem; background: #f3f4f6; border-radius: 20px; font-weight: 600; font-size: 0.9rem; }

    /* Anagrams */
    .anagram-alphabet { display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center; }
    .letter-tile {
        width: 60px; height: 60px; background: white; color: var(--stadium-blue);
        display: flex; justify-content: center; align-items: center;
        font-size: 2rem; font-weight: 800; border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1); transform: rotate(-2deg);
    }
    .letter-tile:nth-child(even) { transform: rotate(3deg); }
    
    .stimulus-instruction { margin-top: 2rem; color: var(--text-dim); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; font-size: 0.8rem; }
</style>
