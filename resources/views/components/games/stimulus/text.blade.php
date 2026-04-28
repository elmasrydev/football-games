@props(['challenge', 'game'])

<div class="text-box {{ $game->slug === 'vowel-void' ? 'vowel-void-mode' : '' }}">
    {{-- Check for image even in text challenges --}}
    @php 
        $imagePath = $challenge->image_path ?? $challenge->stimulus_data['image_path'] ?? null;
    @endphp
    
    @if($imagePath)
        <div class="embedded-image-wrapper">
            <img src="{{ asset('storage/' . $imagePath) }}" alt="Challenge Context" class="embedded-image">
        </div>
    @endif

    @if($game->slug === 'vowel-void')
        <div class="consonant-display">
            {{ $challenge->consonant_display ?? $challenge->stimulus_data['consonant_display'] ?? '' }}
        </div>
        @if(isset($challenge->stimulus_data['category']))
            <div class="category-badge">Category: {{ $challenge->stimulus_data['category'] }}</div>
        @endif
    @elseif($game->slug === 'missing-link')
        <div class="missing-link-display">
            <span class="link-part">{{ $challenge->part_a ?? $challenge->stimulus_data['part_a'] ?? '' }}</span>
            <span class="link-connector">?</span>
            <span class="link-part">{{ $challenge->part_b ?? $challenge->stimulus_data['part_b'] ?? '' }}</span>
        </div>
    @elseif($game->slug === 'transfer-chain')
        <div class="transfer-display">
            <div class="club-name">{{ $challenge->club_a ?? $challenge->stimulus_data['club_a'] ?? '' }}</div>
            <div class="transfer-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" /></svg>
            </div>
            <div class="club-name">{{ $club_b ?? $challenge->club_b ?? $challenge->stimulus_data['club_b'] ?? '' }}</div>
        </div>
    @elseif($game->slug === 'group-players')
        <div class="group-display">
            <h2 class="group-title">{{ $challenge->stimulus_data['title'] ?? 'Mystery Group' }}</h2>
        </div>
    @else
        <div class="generic-text">
            <p class="puzzle-clue">{{ $challenge->question ?? $challenge->stimulus_data['question'] ?? $challenge->stimulus_data['clue'] ?? 'Solve the mystery!' }}</p>
        </div>
    @endif
</div>

<style>
    .text-box {
        background: white; border: 1px solid var(--glass-border);
        box-shadow: var(--shadow); border-radius: 20px; padding: 3rem;
        display: flex; flex-direction: column; justify-content: center; align-items: center; margin-bottom: 1rem;
        min-height: 300px;
    }
    
    .embedded-image-wrapper { margin-bottom: 2rem; max-width: 100%; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .embedded-image { max-width: 100%; max-height: 300px; object-fit: contain; }

    /* Vowel Void */
    .consonant-display { font-size: 3.5rem; font-weight: 900; letter-spacing: 8px; color: var(--pitch-dark); font-family: 'Courier New', Courier, monospace; }
    .category-badge { margin-top: 1rem; padding: 0.5rem 1rem; background: #f3f4f6; border-radius: 20px; font-weight: 600; font-size: 0.9rem; }
    
    /* Missing Link */
    .missing-link-display { display: flex; align-items: center; gap: 2rem; }
    .link-part { font-size: 2.2rem; font-weight: 800; color: var(--pitch-dark); }
    .link-connector { font-size: 4rem; font-weight: 900; color: var(--stadium-green); }

    /* Transfer Chain */
    .transfer-display { display: flex; align-items: center; gap: 2rem; }
    .club-name { font-size: 2rem; font-weight: 800; color: var(--pitch-dark); text-align: center; }
    .transfer-icon { width: 48px; height: 48px; color: var(--stadium-green); }

    /* Group Players */
    .group-title { font-size: 2.5rem; font-weight: 900; color: var(--pitch-dark); text-align: center; }

    /* Generic Clue */
    .puzzle-clue { font-size: 1.5rem; font-weight: 700; color: var(--pitch-dark); text-align: center; line-height: 1.4; }
</style>
