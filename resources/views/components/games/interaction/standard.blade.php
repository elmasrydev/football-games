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
        <h2>Enter your answer below:</h2>
        @if($challenge->question || $challenge->clue)
            <p class="clue-text">{{ $challenge->question ?? $challenge->clue }}</p>
        @endif
    </div>

    <x-player-answer-form 
        :placeholder="'Your answer here...'" 
        :answerType="$challenge->autocomplete_type ?? $challenge->answer_type ?? $game->answer_type ?? 'player'" 
    />

    <div id="feedback" class="feedback"></div>
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

    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .title-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .title-row h3 {
        color: var(--stadium-green);
        font-weight: 800;
        letter-spacing: 1px;
        font-size: 1.1rem;
        margin: 0;
    }

    .difficulty-badge {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 800;
    }

    .difficulty-badge.easy { background: #dcfce7; color: #166534; }
    .difficulty-badge.medium { background: #fef9c3; color: #854d0e; }
    .difficulty-badge.hard { background: #fee2e2; color: #991b1b; }

    .question-body h2 {
        font-size: 1.8rem;
        font-weight: 900;
        color: var(--pitch-dark);
        margin-bottom: 1.5rem;
    }

    .clue-text {
        font-size: 1.1rem;
        color: var(--text-dim);
        margin-bottom: 2rem;
        line-height: 1.6;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 12px;
        border-left: 4px solid var(--stadium-green);
    }

    .feedback {
        margin-top: 1.5rem;
        padding: 1rem;
        border-radius: 12px;
        font-weight: 700;
        text-align: center;
        display: none;
        animation: slideUp 0.3s ease-out;
    }

    .feedback.correct { background: #2ea043; color: white; }
    .feedback.wrong { background: #cf222e; color: white; }
    .feedback.revealed { background: #0969da; color: white; }

    /* Hints Side Block */
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

    @keyframes slideUp {
        from { transform: translateY(10px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    @keyframes slideIn { from { transform: translateX(10px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
</style>
