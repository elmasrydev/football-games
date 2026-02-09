<div class="answer-form">
    <div class="autocomplete-wrapper">
        <input type="text" id="answer-input" placeholder="{{ $placeholder ?? 'Write your answer here...' }}"
            autocomplete="off">
        <div id="autocomplete-list" class="autocomplete-items"></div>
    </div>
    <div class="form-actions" style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <button id="submit-btn" class="btn btn-primary">{{ $submitLabel ?? 'Check Answer' }}</button>
        <button id="clear-btn" class="btn btn-outline" style="border-color: #6b7280; color: #6b7280;">Clear</button>
        <button id="give-up-btn" class="btn btn-outline" style="border-color: #ef4444; color: #ef4444;">Give Up</button>
    </div>
</div>

<style>
    .answer-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .form-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .answer-form input {
        width: 100%;
        padding: 1rem;
        background: #f8faf9;
        border: 1px solid var(--glass-border);
        border-radius: 10px;
        font-size: 1rem;
        color: var(--text-main);
        font-family: inherit;
        transition: var(--transition);
    }

    .answer-form input:focus {
        outline: none;
        border-color: var(--stadium-green);
        background: #fff;
        box-shadow: 0 0 12px rgba(63, 185, 80, 0.1);
    }
</style>