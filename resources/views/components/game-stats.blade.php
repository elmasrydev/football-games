@php
    $displayStats = $stats ?? $global_stats ?? [
        'streak' => 0,
        'games_played' => 0,
        'total_correct' => 0,
        'total_questions' => 0
    ];
@endphp

<div class="game-stats-hud">
    <div class="stat-pill streak">
        <span class="stat-label">{{ __('Day') }}</span>
        <span class="stat-value" id="hud-streak">{{ $displayStats['streak'] }}</span>
    </div>
    <div class="stat-pill games">
        <span class="stat-label">{{ __('Played') }}</span>
        <span class="stat-value" id="hud-played">{{ $displayStats['games_played'] }}</span>
    </div>
    <div class="stat-pill score">
        <span class="stat-label">{{ __('Score') }}</span>
        <span class="stat-value" id="hud-score">{{ $displayStats['total_correct'] }}/{{ $displayStats['total_questions'] }}</span>
    </div>
</div>

<style>
    .game-stats-hud {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .stat-pill {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--surface);
        padding: 0.65rem 0.95rem;
        border-radius: 99px;
        box-shadow: var(--shadow-soft);
        border: 1px solid var(--border-soft);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
    }

    .stat-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        font-weight: 700;
        color: var(--text-soft);
        letter-spacing: 0.05em;
    }

    .stat-value {
        font-family: var(--font-display);
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--text);
    }

    .stat-pill.streak {
        border-color: rgba(244, 63, 94, 0.2);
        background: rgba(244, 63, 94, 0.08);
    }

    .stat-pill.streak .stat-label {
        color: #e11d48;
    }
    
    .stat-pill.games {
        border-color: rgba(59, 130, 246, 0.2);
        background: rgba(59, 130, 246, 0.08);
    }

    .stat-pill.games .stat-label {
        color: #2563eb;
    }

    .stat-pill.score {
        border-color: rgba(34, 197, 94, 0.2);
        background: rgba(34, 197, 94, 0.08);
    }

    .stat-pill.score .stat-label {
        color: #16a34a;
    }
</style>

<script>
    window.updateHUD = function(stats) {
        console.log('Updating HUD with stats:', stats);
        if (!stats) return;
        document.getElementById('hud-streak').innerText = stats.streak;
        document.getElementById('hud-played').innerText = stats.games_played;
        document.getElementById('hud-score').innerText = stats.total_correct + '/' + stats.total_questions;
        
        // Add a little pop animation
        const pills = document.querySelectorAll('.stat-pill');
        pills.forEach(pill => {
            pill.style.transform = 'scale(1.05)';
            setTimeout(() => pill.style.transform = 'scale(1)', 200);
        });
    };
</script>
