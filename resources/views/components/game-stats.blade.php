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
        <span class="stat-label">Day</span>
        <span class="stat-value" id="hud-streak">{{ $displayStats['streak'] }}</span>
    </div>
    <div class="stat-pill games">
        <span class="stat-label">Played</span>
        <span class="stat-value" id="hud-played">{{ $displayStats['games_played'] }}</span>
    </div>
    <div class="stat-pill score">
        <span class="stat-label">Score</span>
        <span class="stat-value" id="hud-score">{{ $displayStats['total_correct'] }}/{{ $displayStats['total_questions'] }}</span>
    </div>
</div>

<style>
    .game-stats-hud {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        justify-content: center;
    }

    .stat-pill {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: white;
        padding: 0.4rem 0.8rem;
        border-radius: 99px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
    }

    .stat-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        font-weight: 700;
        color: #64748b;
        letter-spacing: 0.05em;
    }

    .stat-value {
        font-family: 'Outfit', sans-serif;
        font-size: 0.9rem;
        font-weight: 800;
        color: #0f172a;
    }

    .stat-pill.streak { border-color: #fca5a5; background: #fff1f2; }
    .stat-pill.streak .stat-label { color: #e11d48; }
    
    .stat-pill.games { border-color: #93c5fd; background: #eff6ff; }
    .stat-pill.games .stat-label { color: #2563eb; }

    .stat-pill.score { border-color: #86efac; background: #f0fdf4; }
    .stat-pill.score .stat-label { color: #16a34a; }
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
