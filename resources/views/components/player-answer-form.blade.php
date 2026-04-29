@props(['placeholder' => __('Your answer here...'), 'answerType' => 'player', 'submitLabel' => __('Check Answer')])

<div class="answer-form">
    <div class="autocomplete-wrapper">
        <label for="answer-input" class="answer-label">{{ __('Type your answer') }}</label>
        <input type="text" id="answer-input" placeholder="{{ $placeholder }}"
            data-answer-type="{{ $answerType }}"
            autocomplete="off">
        <div id="autocomplete-list" class="autocomplete-items"></div>
    </div>

    <div class="form-actions">
        <button id="submit-btn" class="btn btn-primary">{{ $submitLabel }}</button>
        <button id="clear-btn" class="btn btn-outline-grey">{{ __('Clear') }}</button>
        <button id="give-up-btn" class="btn btn-outline-red">{{ __('Give Up') }}</button>
    </div>
</div>

<style>
    .answer-form {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        width: 100%;
    }

    .autocomplete-wrapper {
        position: relative;
        width: 100%;
    }

    .answer-label {
        display: inline-flex;
        margin-bottom: 0.65rem;
        color: var(--text-soft);
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }
    
    .answer-form input {
        width: 100%;
        padding: 1.15rem 1.2rem;
        background: linear-gradient(180deg, rgba(var(--surface-muted-rgb), 0.92), rgba(var(--surface-rgb), 0.82));
        border: 1px solid var(--border-strong);
        border-radius: 20px;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text);
        transition: all 0.2s ease;
        box-sizing: border-box;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.12), 0 10px 24px rgba(15, 23, 42, 0.04);
    }

    .answer-form input:focus {
        outline: none;
        border-color: rgba(59, 130, 246, 0.4);
        background: var(--surface-strong);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12), 0 16px 34px rgba(59, 130, 246, 0.08);
    }

    .form-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-outline-grey {
        background: rgba(var(--surface-rgb), 0.6);
        border: 1px solid var(--border-strong);
        color: var(--text-muted);
        font-weight: 800;
        padding: 0.8rem 1.5rem;
        border-radius: 16px;
        transition: all 0.2s;
    }

    .btn-outline-grey:hover {
        background: rgba(59, 130, 246, 0.08);
        border-color: rgba(59, 130, 246, 0.32);
    }

    .btn-outline-red {
        background: rgba(239, 68, 68, 0.08);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #ef4444;
        font-weight: 800;
        padding: 0.8rem 1.5rem;
        border-radius: 16px;
        transition: all 0.2s;
    }

    .btn-outline-red:hover {
        background: rgba(239, 68, 68, 0.12);
        border-color: rgba(239, 68, 68, 0.3);
    }

    @media (max-width: 640px) {
        .form-actions > * {
            flex: 1 1 100%;
        }
    }
</style>
