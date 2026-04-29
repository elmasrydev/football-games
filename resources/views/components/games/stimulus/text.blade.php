@props(['challenge', 'game'])

<div class="text-shell">
    {{-- Check for image even in text challenges --}}
    @php 
        $imagePath = $challenge->image_path ?? $challenge->stimulus_data['image_path'] ?? null;
    @endphp

    <div class="text-stage-meta">
        <span class="stimulus-tag">{{ __('Challenge Mode') }}</span>
        <strong>{{ $game->localized_title }}</strong>
    </div>

    <div class="text-box {{ $game->slug === 'vowel-void' ? 'vowel-void-mode' : '' }}">
        <div class="text-panel-glow"></div>
    
        @if($imagePath)
            <div class="embedded-image-wrapper">
                <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ __('Challenge') }}" class="embedded-image">
            </div>
        @endif

        @if($game->slug === 'vowel-void')
            <div class="consonant-display">
                {{ $challenge->consonant_display ?? $challenge->stimulus_data['consonant_display'] ?? '' }}
            </div>
            @if(isset($challenge->stimulus_data['category']))
                <div class="category-badge">{{ __('Category:') }} {{ $challenge->stimulus_data['category'] }}</div>
            @endif
        @elseif($game->slug === 'missing-link')
            <div class="missing-link-container">
                <div class="clues-grid">
                    @php
                        $clues = $challenge->stimulus_data['clues'] ?? [
                            $challenge->part_a ?? $challenge->stimulus_data['part_a'] ?? null,
                            $challenge->part_b ?? $challenge->stimulus_data['part_b'] ?? null,
                            $challenge->part_c ?? $challenge->stimulus_data['part_c'] ?? null,
                            $challenge->part_d ?? $challenge->stimulus_data['part_d'] ?? null,
                        ];
                        $clues = array_filter($clues);
                    @endphp
                    @foreach($clues as $clue)
                        <div class="clue-bubble">
                            <span class="clue-text">{{ $clue }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="link-icon-wrapper">
                    <span class="material-symbols-outlined link-icon">link</span>
                </div>
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
                <h2 class="group-title">{{ $challenge->stimulus_data['title'] ?? __('Mystery Group') }}</h2>
            </div>
        @else
            <div class="generic-text">
                <p class="puzzle-clue">{{ $challenge->question ?? $challenge->stimulus_data['question'] ?? $challenge->stimulus_data['clue'] ?? __('Solve the mystery!') }}</p>
            </div>
        @endif
    </div>
</div>

<style>
    .text-shell {
        display: grid;
        gap: 0.9rem;
    }

    .text-stage-meta {
        display: grid;
        gap: 0.35rem;
        padding-inline: 0.2rem;
    }

    .stimulus-tag {
        display: inline-flex;
        width: fit-content;
        padding: 0.42rem 0.75rem;
        border-radius: 999px;
        background: rgba(var(--surface-rgb), 0.75);
        border: 1px solid var(--border-soft);
        color: var(--text-soft);
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        backdrop-filter: blur(10px);
    }

    .text-stage-meta strong {
        color: var(--text);
        font-family: var(--font-display);
        font-size: clamp(1.05rem, 2vw, 1.35rem);
        line-height: 1.1;
        letter-spacing: -0.03em;
    }

    .text-box {
        background:
            radial-gradient(circle at top right, rgba(59, 130, 246, 0.12), transparent 28%),
            radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.1), transparent 24%),
            var(--surface);
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-soft);
        border-radius: 28px;
        padding: clamp(1.5rem, 4vw, 3rem);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 300px;
        position: relative;
        overflow: hidden;
    }

    .text-panel-glow {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.06), transparent 40%);
        pointer-events: none;
    }
    
    .embedded-image-wrapper { margin-bottom: 2rem; max-width: 100%; border-radius: 20px; overflow: hidden; box-shadow: 0 18px 30px rgba(15,23,42,0.14); border: 1px solid var(--border-soft); position: relative; z-index: 1; }
    .embedded-image { max-width: 100%; max-height: 300px; object-fit: contain; background: rgba(var(--surface-rgb), 0.5); }

    /* Vowel Void */
    .consonant-display { font-size: clamp(2rem, 7vw, 3.5rem); font-weight: 900; letter-spacing: 8px; color: var(--text); font-family: 'Courier New', Courier, monospace; text-align: center; position: relative; z-index: 1; }
    .category-badge { margin-top: 1rem; padding: 0.5rem 1rem; background: rgba(var(--surface-muted-rgb), 0.9); border-radius: 20px; font-weight: 700; font-size: 0.9rem; color: var(--text-muted); border: 1px solid var(--border-soft); position: relative; z-index: 1; }
    
    /* Missing Link Improvements */
    .missing-link-container { display: flex; flex-direction: column; align-items: center; gap: 2rem; width: 100%; position: relative; z-index: 1; }
    .clues-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 1rem; max-width: 600px; }
    .clue-bubble { padding: 1rem 2rem; background: rgba(var(--primary-rgb), 0.1); border: 1px solid rgba(var(--primary-rgb), 0.2); border-radius: 20px; box-shadow: 0 8px 20px rgba(0,0,0,0.05); transition: all 0.3s ease; }
    .clue-bubble:hover { transform: translateY(-4px); background: rgba(var(--primary-rgb), 0.15); border-color: rgba(var(--primary-rgb), 0.3); }
    .clue-text { font-size: clamp(1.1rem, 2.5vw, 1.5rem); font-weight: 800; color: var(--text); text-align: center; }
    .link-icon-wrapper { width: 60px; height: 60px; border-radius: 50%; background: var(--primary); display: flex; items-center; justify-content: center; color: var(--on-primary); box-shadow: 0 10px 20px rgba(var(--primary-rgb), 0.3); }
    .link-icon { font-size: 32px !important; }

    /* Transfer Chain */
    .transfer-display { display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; justify-content: center; position: relative; z-index: 1; }
    .club-name { font-size: clamp(1.4rem, 4vw, 2rem); font-weight: 800; color: var(--text); text-align: center; }
    .transfer-icon { width: 48px; height: 48px; color: var(--accent); }

    /* Group Players */
    .group-title { font-size: clamp(2rem, 6vw, 3rem); font-weight: 900; color: var(--text); text-align: center; position: relative; z-index: 1; }

    /* Generic Clue */
    .puzzle-clue { font-size: clamp(1.15rem, 3vw, 1.6rem); font-weight: 700; color: var(--text); text-align: center; line-height: 1.5; position: relative; z-index: 1; }

    @media (max-width: 640px) {
        .text-box {
            padding: 1.25rem;
            min-height: 260px;
        }
        .clue-bubble { padding: 0.75rem 1.25rem; }
    }
</style>
