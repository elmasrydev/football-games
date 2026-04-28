@props(['placeholder' => 'Write your answer here...', 'answerType' => 'player', 'submitLabel' => 'Check Answer'])

<div class="answer-form">
    <div class="autocomplete-wrapper">
        <input type="text" id="answer-input" placeholder="{{ $placeholder }}"
            data-answer-type="{{ $answerType }}"
            autocomplete="off">
        <div id="autocomplete-list" class="autocomplete-items"></div>
    </div>

    <div class="form-actions">
        <button id="submit-btn" class="btn btn-primary">{{ $submitLabel }}</button>
        <button id="clear-btn" class="btn btn-outline-grey">Clear</button>
        <button id="give-up-btn" class="btn btn-outline-red">Give Up</button>
    </div>
</div>

<style>
    .answer-form { display: flex; flex-direction: column; gap: 1.25rem; width: 100%; }
    .autocomplete-wrapper { position: relative; width: 100%; }
    
    .answer-form input {
        width: 100%;
        padding: 1.1rem 1.5rem;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--pitch-dark);
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .answer-form input:focus {
        outline: none;
        border-color: var(--stadium-green);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(63, 185, 80, 0.1);
    }

    .form-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-outline-grey {
        background: white;
        border: 2px solid #e2e8f0;
        color: #64748b;
        font-weight: 700;
        padding: 0.8rem 1.5rem;
        border-radius: 12px;
        transition: all 0.2s;
    }
    .btn-outline-grey:hover { background: #f8fafc; border-color: #cbd5e1; }

    .btn-outline-red {
        background: white;
        border: 2px solid #fee2e2;
        color: #ef4444;
        font-weight: 700;
        padding: 0.8rem 1.5rem;
        border-radius: 12px;
        transition: all 0.2s;
    }
    .btn-outline-red:hover { background: #fef2f2; border-color: #fca5a5; }
</style>