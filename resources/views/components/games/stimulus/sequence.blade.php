@props(['challenge', 'game'])

<div class="sequence-shell">
    @php 
        $clubsData = $challenge->stimulus_data['clubs'] ?? [];
        $playerImage = $challenge->stimulus_data['player_image'] ?? null;
        
        // Resolve club details if they are just IDs
        $resolvedClubs = collect($clubsData)->map(function($club) {
            if (!isset($club['name']) && isset($club['club_id'])) {
                // Try new unified table first (using external_id mapping)
                $dbItem = \App\Models\GameItem::ofType('club')->where('external_id', $club['club_id'])->first();
                if ($dbItem) {
                    $club['name'] = $dbItem->name_en;
                    $club['logo'] = $dbItem->getFirstMediaUrl('image');
                } else {
                    // Fallback to legacy table if seeder hasn't run or item missing
                    $dbClub = \App\Models\Club::find($club['club_id']);
                    if ($dbClub) {
                        $club['name'] = $dbClub->name;
                        $club['logo'] = $dbClub->logo ? asset('storage/' . $dbClub->logo) : null;
                    }
                }
            }
            return $club;
        });
    @endphp

    <div class="sequence-stage-meta">
        <span class="stimulus-tag">{{ __('Challenge Mode') }}</span>
        <strong>{{ $game->localized_title }}</strong>
    </div>

    <div class="sequence-box">
        <div class="sequence-panel-glow"></div>
    
        @if($playerImage)
            <div class="player-avatar">
                <img src="{{ asset('storage/' . $playerImage) }}" alt="{{ __('Mystery Player') }}">
            </div>
        @endif
    
        <div class="club-timeline">
            @foreach($resolvedClubs as $club)
                <div class="timeline-item">
                    <span class="timeline-year">{{ $club['year'] ?? '' }}</span>
                    <span class="timeline-dot"></span>
                    <div class="club-info-card">
                        @if(!empty($club['logo']))
                            <img src="{{ $club['logo'] }}" alt="{{ $club['name'] ?? __('Club') }}" class="club-logo">
                        @elseif(!empty($club['club_id']))
                             <div class="club-logo-placeholder">{{ substr($club['name'] ?? '?', 0, 1) }}</div>
                        @else
                            <div class="club-logo-placeholder">?</div>
                        @endif
                        <span class="club-name">{{ $club['name'] ?? __('Unknown Club') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    
        <div class="stimulus-instruction">{{ __('Follow the career path!') }}</div>
    </div>
</div>

<style>
    .sequence-shell {
        display: grid;
        gap: 0.9rem;
    }

    .sequence-stage-meta {
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

    .sequence-stage-meta strong {
        color: var(--text);
        font-family: var(--font-display);
        font-size: clamp(1.05rem, 2vw, 1.35rem);
        line-height: 1.1;
        letter-spacing: -0.03em;
    }

    .sequence-box {
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
        min-height: 350px;
        position: relative;
        overflow: hidden;
    }

    .sequence-panel-glow {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.06), transparent 40%);
        pointer-events: none;
    }

    .player-avatar img { width: 100px; height: 100px; border-radius: 50%; border: 4px solid var(--accent); margin-bottom: 2.5rem; box-shadow: 0 18px 30px rgba(15,23,42,0.18); position: relative; z-index: 1; }
    
    .club-timeline { display: flex; gap: 3rem; flex-wrap: wrap; justify-content: center; align-items: start; position: relative; z-index: 1; }
    .timeline-item { display: flex; flex-direction: column; align-items: center; gap: 0.75rem; position: relative; }
    .timeline-year { font-weight: 800; font-size: 1.1rem; color: var(--text); }
    .timeline-dot { width: 16px; height: 16px; background: var(--accent); border-radius: 50%; box-shadow: 0 0 10px rgba(59, 130, 246, 0.25); }
    
    .club-info-card {
        background: rgba(var(--surface-muted-rgb), 0.9); border: 1px solid var(--border-soft); border-radius: 18px;
        padding: 0.75rem; display: flex; flex-direction: column; align-items: center; gap: 0.5rem;
        min-width: 100px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: transform 0.2s;
    }
    .club-info-card:hover { transform: translateY(-5px); }
    
    .club-logo { width: 48px; height: 48px; object-fit: contain; }
    .club-logo-placeholder { width: 48px; height: 48px; background: rgba(59, 130, 246, 0.12); border-radius: 50%; display: flex; justify-content: center; align-items: center; font-weight: 800; color: var(--accent-strong); font-size: 1.5rem; }
    .club-name { font-size: 0.85rem; font-weight: 700; color: var(--text); text-align: center; }

    .timeline-item:not(:last-child)::after {
        content: ''; position: absolute; top: 35px; left: calc(50% + 8px); width: calc(100% + 1.5rem); height: 2px;
        background: var(--border-strong); z-index: 0;
    }

    .stimulus-instruction { margin-top: 3rem; color: var(--text-soft); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.8rem; position: relative; z-index: 1; }

    @media (max-width: 640px) {
        .sequence-box {
            padding: 1.25rem;
            min-height: 280px;
        }

        .club-timeline {
            gap: 1.6rem;
        }

        .timeline-item:not(:last-child)::after {
            width: calc(100% + 0.8rem);
        }
    }
</style>
