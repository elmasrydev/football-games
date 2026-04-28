@props(['challenge', 'game'])

<div class="question-card">
    <div class="question-header">
        <div class="title-row">
            <span class="icon">🔍</span>
            <h3>{{ strtoupper($game->title) }}</h3>
        </div>
        <span class="difficulty-badge {{ $challenge->difficulty }}">
            {{ strtoupper($challenge->difficulty) }}
        </span>
    </div>
    <div class="question-body">
        <p class="group-instruction">Find all members of this group:</p>
        @php 
            $totalPlayers = count($challenge->answers_array);
        @endphp
        <div class="progress-container">
            <div class="progress-info">
                <span id="found-count">0</span> / <span>{{ $totalPlayers }}</span> found
            </div>
            <div class="progress-bar">
                <div id="progress-fill" class="progress-fill" style="width: 0%"></div>
            </div>
        </div>
    </div>

    <x-player-answer-form 
        :placeholder="'Type a player name...'" 
        :answerType="(!empty($challenge->answer_type)) ? $challenge->answer_type : ((!empty($game->answer_type)) ? $game->answer_type : 'player')" 
    />

    <div id="feedback" class="feedback"></div>
    <div id="found-players" class="found-players-list"></div>
</div>

<div class="hints-section">
    <div class="hints-card">
        <div class="hints-header">
            <h4>💡 HINTS</h4>
        </div>
        <button id="hint-btn" class="btn-hint">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-3m0 0a8.1 8.1 0 0 0 4.5-1.55c3.3-2.45 3.3-6.45 0-8.9A8.1 8.1 0 0 0 12 3a8.1 8.1 0 0 0-4.5 1.55c-3.3 2.45-3.3 6.45 0 8.9A8.1 8.1 0 0 0 12 15Zm0 3v2m0 0h-3m3 0h3" /></svg>
            <span>Unlock Hint</span>
        </button>
        <div id="hints-display" class="hints-display"></div>
    </div>
</div>

<style>
    .question-card {
        background: white;
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        padding: 2.5rem;
        box-shadow: var(--shadow);
    }
    
    .question-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .title-row { display: flex; align-items: center; gap: 0.5rem; }
    .title-row h3 { color: var(--stadium-green); font-weight: 800; letter-spacing: 1px; font-size: 1.1rem; margin: 0; }
    
    .difficulty-badge { padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.75rem; font-weight: 800; }
    .difficulty-badge.easy { background: #dcfce7; color: #166534; }
    .difficulty-badge.medium { background: #fef9c3; color: #854d0e; }
    .difficulty-badge.hard { background: #fee2e2; color: #991b1b; }

    .group-instruction { font-size: 1.2rem; font-weight: 700; color: var(--pitch-dark); margin-bottom: 1rem; }
    .progress-container { width: 100%; margin: 1.5rem 0; }
    .progress-info { font-weight: 700; margin-bottom: 0.5rem; font-size: 0.9rem; color: var(--text-dim); }
    .progress-bar { width: 100%; height: 10px; background: #e5e7eb; border-radius: 5px; overflow: hidden; }
    .progress-fill { height: 100%; background: var(--stadium-green); transition: width 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    
    .found-players-list { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 1.5rem; }
    .found-chip { background: #d1fae5; color: #065f46; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 700; font-size: 0.85rem; animation: popIn 0.3s ease-out; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }

    .hints-card {
        background: #f8fafc;
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        padding: 2rem;
        height: 100%;
    }
    .hints-header h4 { margin: 0 0 1.5rem 0; font-weight: 800; color: #64748b; letter-spacing: 1px; }
    .btn-hint {
        width: 100%; background: white; border: 2px solid #e2e8f0; border-radius: 12px;
        padding: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.75rem;
        font-weight: 700; color: #475569; transition: all 0.2s; cursor: pointer;
    }
    .btn-hint:hover { border-color: var(--stadium-green); color: var(--stadium-green); transform: translateY(-2px); }
    .btn-hint svg { width: 20px; height: 20px; }
    
    .hints-display { margin-top: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem; }
    .hint-item { background: white; padding: 1rem; border-radius: 12px; border-left: 4px solid var(--stadium-green); box-shadow: 0 2px 4px rgba(0,0,0,0.05); animation: slideIn 0.3s ease-out; }

    @keyframes popIn { 0% { transform: scale(0.8); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
    @keyframes slideIn { from { transform: translateX(10px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
</style>

<script>
    window.revealedOrders = [];
    const totalToFind = {{ count($challenge->answers_array) }};

    window.updateProgress = function(name, order) {
        if (window.revealedOrders.includes(order)) return;
        window.revealedOrders.push(order);
        
        const countSpan = document.getElementById('found-count');
        if (countSpan) countSpan.textContent = window.revealedOrders.length;
        
        const fill = document.getElementById('progress-fill');
        if (fill) fill.style.width = (window.revealedOrders.length / totalToFind * 100) + '%';

        const chip = document.createElement('div');
        chip.className = 'found-chip';
        chip.textContent = name;
        document.getElementById('found-players').appendChild(chip);

        if (window.revealedOrders.length >= totalToFind) {
            document.getElementById('submit-btn').disabled = true;
            document.getElementById('feedback').textContent = "All found! Outstanding!";
            if (window.highlightSuccess) window.highlightSuccess();
        }
    };
</script>
