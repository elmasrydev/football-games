@props(['challenge', 'game'])

<div class="sequence-box">
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
    
    @if($playerImage)
        <div class="player-avatar">
            <img src="{{ asset('storage/' . $playerImage) }}" alt="Mystery Player">
        </div>
    @endif
    
    <div class="club-timeline">
        @foreach($resolvedClubs as $club)
            <div class="timeline-item">
                <span class="timeline-year">{{ $club['year'] ?? '' }}</span>
                <span class="timeline-dot"></span>
                <div class="club-info-card">
                    @if(!empty($club['logo']))
                        <img src="{{ $club['logo'] }}" alt="{{ $club['name'] ?? 'Club' }}" class="club-logo">
                    @elseif(!empty($club['club_id']))
                         <div class="club-logo-placeholder">{{ substr($club['name'] ?? '?', 0, 1) }}</div>
                    @else
                        <div class="club-logo-placeholder">?</div>
                    @endif
                    <span class="club-name">{{ $club['name'] ?? 'Unknown Club' }}</span>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="stimulus-instruction">Follow the career path!</div>
</div>

<style>
    .sequence-box {
        background: white; border: 1px solid var(--glass-border);
        box-shadow: var(--shadow); border-radius: 20px; padding: 3rem;
        display: flex; flex-direction: column; justify-content: center; align-items: center; margin-bottom: 1rem;
        min-height: 350px;
    }
    .player-avatar img { width: 100px; height: 100px; border-radius: 50%; border: 4px solid var(--stadium-green); margin-bottom: 2.5rem; }
    
    .club-timeline { display: flex; gap: 3rem; flex-wrap: wrap; justify-content: center; align-items: start; }
    .timeline-item { display: flex; flex-direction: column; align-items: center; gap: 0.75rem; position: relative; }
    .timeline-year { font-weight: 800; font-size: 1.1rem; color: var(--pitch-dark); }
    .timeline-dot { width: 16px; height: 16px; background: var(--stadium-green); border-radius: 50%; box-shadow: 0 0 10px var(--stadium-glow); }
    
    .club-info-card {
        background: #f8fafc; border: 1px solid var(--glass-border); border-radius: 12px;
        padding: 0.75rem; display: flex; flex-direction: column; align-items: center; gap: 0.5rem;
        min-width: 100px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: transform 0.2s;
    }
    .club-info-card:hover { transform: translateY(-5px); }
    
    .club-logo { width: 48px; height: 48px; object-fit: contain; }
    .club-logo-placeholder { width: 48px; height: 48px; background: #e2e8f0; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-weight: 800; color: #64748b; font-size: 1.5rem; }
    .club-name { font-size: 0.85rem; font-weight: 700; color: var(--pitch-dark); text-align: center; }

    .timeline-item:not(:last-child)::after {
        content: ''; position: absolute; top: 35px; left: calc(50% + 8px); width: calc(100% + 1.5rem); height: 2px;
        background: var(--glass-border); z-index: 0;
    }

    .stimulus-instruction { margin-top: 3rem; color: var(--text-dim); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; font-size: 0.8rem; }
</style>
