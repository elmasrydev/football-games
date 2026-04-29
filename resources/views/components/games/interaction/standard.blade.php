@props(['challenge', 'game'])

<div class="question-card">
    <div class="question-header">
        <div class="title-row">
            <span class="icon">🔍</span>
            <div>
                <span class="eyebrow">{{ __('Challenge Mode') }}</span>
                <h3>{{ app()->getLocale() === 'ar' ? $game->localized_title : strtoupper($game->localized_title) }}</h3>
            </div>
        </div>
        <span class="difficulty-badge {{ $challenge->difficulty }}">
            {{ strtoupper($challenge->difficulty) }}
        </span>
    </div>
    
    <div class="question-body">
        <h2>{{ __('Enter your answer below:') }}</h2>
        @if($challenge->question || $challenge->clue)
            <p class="clue-text">{{ $challenge->question ?? $challenge->clue }}</p>
        @endif
    </div>

    <div class="answer-surface">
        <div class="answer-surface-head">
            <div>
                <span class="mini-label">{{ __('Answer Zone') }}</span>
                <strong>{{ __('Submit when you\'re confident') }}</strong>
            </div>
            <span class="answer-type-pill">{{ strtoupper($challenge->autocomplete_type ?? $challenge->answer_type ?? $game->answer_type ?? 'player') }}</span>
        </div>

        <x-player-answer-form 
            :placeholder="__('Your answer here...')" 
            :answerType="$challenge->autocomplete_type ?? $challenge->answer_type ?? $game->answer_type ?? 'player'" 
        />
    </div>

    <div id="feedback" class="feedback"></div>
</div>

<div class="hints-section">
    <div class="hints-card">
        <div class="hints-header">
            <span class="eyebrow">{{ __('Support') }}</span>
            <h4>{{ __('Hints & Rescue') }}</h4>
            <p>{{ __('Stuck on this one? Reveal clues one by one before giving up the full answer.') }}</p>
        </div>
        <button id="hint-btn" class="btn-hint">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-3m0 0a8.1 8.1 0 0 0 4.5-1.55c3.3-2.45 3.3-6.45 0-8.9A8.1 8.1 0 0 0 12 3a8.1 8.1 0 0 0-4.5 1.55c-3.3 2.45-3.3 6.45 0 8.9A8.1 8.1 0 0 0 12 15Zm0 3v2m0 0h-3m3 0h3" /></svg>
            <span>{{ __('Unlock Hint') }}</span>
        </button>
        <div class="hint-note">
            <span class="hint-note-dot"></span>
            {{ __('Hints appear here in the order they were curated.') }}
        </div>
        <div id="hints-display" class="hints-display"></div>
    </div>
</div>

<style>
    .question-card {
        background: var(--surface);
        border: 1px solid var(--border-soft);
        border-radius: 28px;
        padding: clamp(1.4rem, 3vw, 2.1rem);
        box-shadow: var(--shadow-soft);
        backdrop-filter: blur(18px);
    }

    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.6rem;
        flex-wrap: wrap;
    }

    .title-row {
        display: flex;
        align-items: flex-start;
        gap: 0.7rem;
    }

    .eyebrow {
        display: inline-flex;
        margin-bottom: 0.35rem;
        color: var(--text-soft);
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .title-row h3 {
        color: var(--accent-strong);
        font-weight: 800;
        letter-spacing: 1px;
        font-size: 1rem;
        margin: 0;
    }

    .icon {
        width: 2.4rem;
        height: 2.4rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        background: rgba(59, 130, 246, 0.1);
    }

    .difficulty-badge {
        padding: 0.45rem 0.9rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 0.05em;
    }

    .difficulty-badge.easy { background: rgba(34, 197, 94, 0.14); color: #15803d; }
    .difficulty-badge.medium { background: rgba(245, 158, 11, 0.16); color: #b45309; }
    .difficulty-badge.hard { background: rgba(239, 68, 68, 0.14); color: #b91c1c; }

    .question-body h2 {
        font-family: var(--font-display);
        font-size: clamp(1.5rem, 3vw, 2rem);
        font-weight: 900;
        color: var(--text);
        margin-bottom: 1rem;
        letter-spacing: -0.03em;
    }

    .clue-text {
        font-size: 1.02rem;
        color: var(--text-muted);
        margin-bottom: 1.6rem;
        line-height: 1.6;
        padding: 1rem;
        background: rgba(var(--surface-muted-rgb), 0.85);
        border-radius: 18px;
        border-inline-start: 4px solid var(--accent);
    }

    .answer-surface {
        padding: 1rem;
        border-radius: 22px;
        background: linear-gradient(180deg, rgba(var(--surface-rgb), 0.34), rgba(var(--surface-muted-rgb), 0.58));
        border: 1px solid var(--border-soft);
    }

    .answer-surface-head {
        display: flex;
        justify-content: space-between;
        align-items: start;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .mini-label {
        display: inline-flex;
        margin-bottom: 0.3rem;
        color: var(--text-soft);
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.09em;
        text-transform: uppercase;
    }

    .answer-surface-head strong {
        display: block;
        color: var(--text);
        font-size: 0.98rem;
    }

    .answer-type-pill {
        display: inline-flex;
        align-items: center;
        padding: 0.45rem 0.8rem;
        border-radius: 999px;
        background: rgba(59, 130, 246, 0.1);
        color: var(--accent-strong);
        font-size: 0.74rem;
        font-weight: 800;
        letter-spacing: 0.08em;
    }

    .feedback {
        margin-top: 1.5rem;
        padding: 1rem 1.1rem;
        border-radius: 20px;
        font-weight: 800;
        text-align: start;
        display: none;
        animation: slideUp 0.3s ease-out;
        border: 1px solid transparent;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
    }

    .feedback.correct { background: rgba(34, 197, 94, 0.14); color: #166534; border-color: rgba(34, 197, 94, 0.18); }
    .feedback.wrong { background: rgba(239, 68, 68, 0.12); color: #b91c1c; border-color: rgba(239, 68, 68, 0.18); }
    .feedback.revealed { background: rgba(59, 130, 246, 0.12); color: #1d4ed8; border-color: rgba(59, 130, 246, 0.18); }

    .hints-display { margin-top: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem; }
    .hint-item { background: rgba(var(--surface-rgb), 0.74); padding: 1rem; border-radius: 18px; border-inline-start: 4px solid var(--accent); box-shadow: 0 8px 18px rgba(15,23,42,0.06); animation: slideIn 0.3s ease-out; color: var(--text-muted); }

    .hints-card {
        background: linear-gradient(180deg, rgba(var(--surface-rgb), 0.72), rgba(var(--surface-muted-rgb), 0.82));
        border: 1px solid var(--border-soft);
        border-radius: 28px;
        padding: 1.5rem;
        height: 100%;
        box-shadow: var(--shadow-soft);
    }

    .hints-header h4 {
        margin: 0 0 0.45rem 0;
        font-family: var(--font-display);
        font-size: 1.45rem;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.03em;
    }

    .hints-header p {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.55;
        margin-bottom: 1rem;
    }

    .btn-hint {
        width: 100%;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(16, 185, 129, 0.12));
        border: 1px solid rgba(59, 130, 246, 0.18);
        border-radius: 20px;
        padding: 1rem 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        font-weight: 800;
        color: var(--text);
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-hint:hover {
        border-color: rgba(59, 130, 246, 0.34);
        color: var(--accent-strong);
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(59, 130, 246, 0.12);
    }

    .btn-hint svg {
        width: 20px;
        height: 20px;
    }

    .hint-note {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        margin-top: 0.9rem;
        color: var(--text-soft);
        font-size: 0.88rem;
        font-weight: 600;
    }

    .hint-note-dot {
        width: 0.55rem;
        height: 0.55rem;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--accent), #14b8a6);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08);
        flex: 0 0 auto;
    }

    @media (max-width: 640px) {
        .answer-surface-head {
            flex-direction: column;
        }
    }

    @keyframes slideUp {
        from { transform: translateY(10px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    @keyframes slideIn { from { transform: translateX(10px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
</style>
