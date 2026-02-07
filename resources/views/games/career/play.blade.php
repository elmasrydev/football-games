@extends('layouts.app')

@section('content')
    <div class="container play-container">
        <div class="career-section">
            <div class="career-header">
                <h2>Career Path Challenge</h2>
                <span class="difficulty-badge {{ $challenge->difficulty }}">
                    {{ ucfirst($challenge->difficulty) }}
                </span>
            </div>

            <div class="career-chain" id="career-chain">
                @foreach($challenge->careerClubs->sortBy('sort_order') as $index => $careerClub)
                    @if($index > 0)
                        <span class="chain-arrow">→</span>
                    @endif
                    <div class="club-item">
                        <div class="club-logo-container">
                            <img src="{{ $careerClub->club->logo_url ?: 'https://placehold.co/60x60/f8fafc/6366f1?text=' . urlencode(substr($careerClub->club->name, 0, 1)) }}"
                                alt="{{ $careerClub->club->name }}" class="club-logo"
                                onerror="this.onerror=null; this.src='https://placehold.co/60x60/f8fafc/6366f1?text=' + encodeURIComponent(this.alt.substring(0, 1));">
                        </div>
                        <div class="club-name" title="{{ $careerClub->club->name }}">{{ $careerClub->club->name }}</div>
                        <div class="club-year">{{ $careerClub->join_year }}</div>
                    </div>
                @endforeach
            </div>

            <div class="controls">
                <a href="{{ route('games.career.play') }}" class="btn btn-outline">
                    Try Another Player
                </a>
            </div>
        </div>

        <div class="interaction-section">
            <div class="question-card">
                <div class="question-header">
                    <h3>Who Is This Player?</h3>
                </div>
                <div class="question-body">
                    <p>Guess the player from their career history!</p>
                </div>

                <div class="answer-form">
                    <div class="autocomplete-wrapper">
                        <input type="text" id="answer-input" placeholder="Type player name..." autocomplete="off">
                        <div id="autocomplete-list" class="autocomplete-items"></div>
                    </div>
                    <button id="submit-btn" class="btn btn-primary">Check Answer</button>
                </div>

                <div id="feedback" class="feedback"></div>
            </div>

            <div class="hints-section">
                <button id="hint-btn" class="btn btn-outline">Get a Hint</button>
                <div id="hints-display" class="hints-display"></div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            :root {
                --career-primary: #6366f1;
                --career-secondary: #818cf8;
                --career-accent: #4f46e5;
                --career-gradient: linear-gradient(135deg, #6366f1, #8b5cf6);
            }

            .play-container {
                display: flex;
                flex-direction: column;
                gap: 2rem;
            }

            .career-section {
                margin-bottom: 1rem;
            }

            .career-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 2rem;
            }

            .career-header h2 {
                font-family: 'Outfit', sans-serif;
                font-size: 1.75rem;
                font-weight: 700;
                color: var(--pitch-dark);
                margin: 0;
                background: var(--career-gradient);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .career-chain {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                min-height: 150px;
                padding: 2rem;
                background: linear-gradient(135deg, #f8f9ff, #f0f1ff);
                border-radius: 24px;
                border: 2px dashed var(--career-secondary);
            }

            .club-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
                padding: 1rem;
                background: white;
                border-radius: 16px;
                box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
                animation: clubAppear 0.5s ease-out;
                min-width: 100px;
            }

            @keyframes clubAppear {
                0% {
                    transform: scale(0) rotate(-10deg);
                    opacity: 0;
                }

                50% {
                    transform: scale(1.1) rotate(5deg);
                }

                100% {
                    transform: scale(1) rotate(0deg);
                    opacity: 1;
                }
            }

            .club-logo-container {
                width: 60px;
                height: 60px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #f8fafc;
                border: 1px solid #f1f5f9;
                border-radius: 12px;
                overflow: hidden;
            }

            .club-logo {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
                filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.05));
            }

            .club-name {
                font-family: 'Outfit', sans-serif;
                font-size: 0.8rem;
                font-weight: 600;
                color: var(--pitch-dark);
                text-align: center;
                max-width: 90px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .club-year {
                font-size: 0.7rem;
                color: var(--career-primary);
                font-weight: 700;
                padding: 0.2rem 0.5rem;
                background: #ede9fe;
                border-radius: 8px;
            }

            .chain-arrow {
                font-size: 1.5rem;
                color: var(--career-secondary);
                animation: arrowPulse 1.5s ease-in-out infinite;
            }

            @keyframes arrowPulse {

                0%,
                100% {
                    opacity: 0.5;
                    transform: translateX(0);
                }

                50% {
                    opacity: 1;
                    transform: translateX(3px);
                }
            }

            .controls {
                margin-top: 1.5rem;
                display: flex;
                justify-content: center;
            }

            .interaction-section {
                display: grid;
                grid-template-columns: 1.5fr 1fr;
                gap: 2.5rem;
                align-items: start;
            }

            .question-card {
                background: white;
                border-radius: 20px;
                border: 1px solid var(--glass-border);
                box-shadow: var(--shadow);
                padding: 2rem;
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
                transition: var(--transition);
            }

            .question-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .question-header h3 {
                font-family: 'Outfit', sans-serif;
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 2px;
                color: var(--career-primary);
                margin: 0;
            }

            .difficulty-badge {
                padding: 0.3rem 0.75rem;
                border-radius: 12px;
                font-size: 0.7rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .difficulty-badge.easy {
                background: #d4edda;
                color: #155724;
            }

            .difficulty-badge.medium {
                background: #fff3cd;
                color: #856404;
            }

            .difficulty-badge.hard {
                background: #f8d7da;
                color: #721c24;
            }

            .question-body p {
                font-family: 'Outfit', sans-serif;
                font-size: 1.4rem;
                font-weight: 700;
                color: var(--pitch-dark);
                line-height: 1.3;
                margin: 0;
            }

            .answer-form {
                display: flex;
                gap: 0.75rem;
            }

            .answer-form input {
                flex: 1;
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
                border-color: var(--career-primary);
                background: #fff;
                box-shadow: 0 0 12px rgba(99, 102, 241, 0.1);
            }

            /* Autocomplete Styles */
            .autocomplete-wrapper {
                position: relative;
                flex: 1;
            }

            .autocomplete-items {
                position: absolute;
                border: 1px solid var(--glass-border);
                border-bottom: none;
                border-top: none;
                z-index: 99;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                border-radius: 0 0 12px 12px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            .autocomplete-item {
                padding: 12px 16px;
                cursor: pointer;
                border-bottom: 1px solid var(--glass-border);
                font-size: 0.95rem;
                color: var(--text-main);
                transition: background 0.2s;
            }

            .autocomplete-item:hover {
                background-color: #f1f5f9;
                color: var(--career-primary);
            }

            .autocomplete-active {
                background-color: var(--career-primary) !important;
                color: white !important;
            }

            .feedback {
                min-height: 1.5rem;
                font-weight: 700;
                padding: 0.75rem;
                border-radius: 10px;
                display: none;
                text-align: center;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                font-size: 0.85rem;
                animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }

            @keyframes popIn {
                0% {
                    transform: scale(0.95);
                    opacity: 0;
                }

                100% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            .feedback.success {
                display: block;
                color: #fff;
                background: linear-gradient(135deg, #2ea043, #238636);
                box-shadow: 0 4px 12px rgba(46, 160, 67, 0.2);
            }

            .feedback.error {
                display: block;
                color: #fff;
                background: linear-gradient(135deg, #da3633, #b62324);
                box-shadow: 0 4px 12px rgba(218, 54, 51, 0.2);
            }

            .hints-section {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            #hint-btn {
                width: 100%;
                padding: 1rem;
            }

            .hints-display {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .hint-item {
                background: white;
                padding: 1rem;
                border-radius: 12px;
                border-left: 4px solid var(--career-primary);
                border-right: 1px solid var(--glass-border);
                border-top: 1px solid var(--glass-border);
                border-bottom: 1px solid var(--glass-border);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
                animation: slideIn 0.3s ease-out;
                font-size: 0.9rem;
                color: var(--text-main);
            }

            @keyframes slideIn {
                from {
                    transform: translateY(5px);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            @media (max-width: 900px) {
                .interaction-section {
                    grid-template-columns: 1fr;
                }

                .question-body p {
                    font-size: 1.25rem;
                }

                .career-chain {
                    padding: 1rem;
                }

                .club-item {
                    min-width: 80px;
                    padding: 0.75rem;
                }

                .club-logo {
                    width: 45px;
                    height: 45px;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            const challengeId = {{ $challenge->id }};
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const shownHints = [];
            document.getElementById('submit-btn').addEventListener('click', checkAnswer);
            document.getElementById('answer-input').addEventListener('keypress', (e) => {
                if (e.key === 'Enter') checkAnswer();
            });
            document.getElementById('hint-btn').addEventListener('click', getHint);

            // Autocomplete Logic
            const answerInput = document.getElementById('answer-input');
            const autocompleteList = document.getElementById('autocomplete-list');
            let currentFocus = -1;

            answerInput.addEventListener('input', function (e) {
                const val = this.value;
                closeAllLists();
                if (!val || val.length < 2) return false;

                currentFocus = -1;
                fetchSuggestions(val);
            });

            answerInput.addEventListener('keydown', function (e) {
                let x = document.getElementById('autocomplete-list');
                if (x) x = x.getElementsByTagName('div');
                if (e.keyCode == 40) { // Down
                    currentFocus++;
                    addActive(x);
                } else if (e.keyCode == 38) { // Up
                    currentFocus--;
                    addActive(x);
                } else if (e.keyCode == 13) { // Enter
                    if (currentFocus > -1) {
                        e.preventDefault();
                        if (x) x[currentFocus].click();
                    }
                }
            });

            async function fetchSuggestions(val) {
                try {
                    const response = await fetch(`/career/players/search?query=${encodeURIComponent(val)}`);
                    const suggestions = await response.json();

                    if (suggestions.length === 0) return;

                    closeAllLists();

                    suggestions.forEach(name => {
                        const b = document.createElement('div');
                        b.className = 'autocomplete-item';
                        b.innerHTML = `<strong>${name.substr(0, val.length)}</strong>${name.substr(val.length)}`;
                        b.innerHTML += `<input type='hidden' value="${name.replace('"', '&quot;')}">`;

                        b.addEventListener('click', function (e) {
                            answerInput.value = this.getElementsByTagName('input')[0].value;
                            closeAllLists();
                        });

                        autocompleteList.appendChild(b);
                    });
                } catch (error) {
                    console.error('Error fetching suggestions:', error);
                }
            }

            function addActive(x) {
                if (!x) return false;
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                x[currentFocus].classList.add('autocomplete-active');
            }

            function removeActive(x) {
                for (let i = 0; i < x.length; i++) {
                    x[i].classList.remove('autocomplete-active');
                }
            }

            function closeAllLists(elmnt) {
                const x = document.getElementsByClassName('autocomplete-items');
                for (let i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != answerInput) {
                        x[i].innerHTML = '';
                    }
                }
            }

            document.addEventListener('click', function (e) {
                closeAllLists(e.target);
            });

            async function checkAnswer() {
                const answer = document.getElementById('answer-input').value;
                const feedback = document.getElementById('feedback');

                if (!answer.trim()) return;

                const response = await fetch(`/career/${challengeId}/check`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ answer })
                });

                const data = await response.json();
                feedback.innerText = data.message;
                feedback.className = 'feedback ' + (data.correct ? 'success' : 'error');

                if (data.correct) {
                    document.getElementById('submit-btn').disabled = true;
                    document.getElementById('answer-input').disabled = true;
                    highlightSuccess();
                }
            }

            async function getHint() {
                const response = await fetch(`/career/${challengeId}/hint`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ shown_hints: shownHints })
                });

                const data = await response.json();

                if (data.hint) {
                    shownHints.push(data.id);
                    const hintDiv = document.createElement('div');
                    hintDiv.className = 'hint-item';
                    hintDiv.innerHTML = `<strong>Hint ${shownHints.length}:</strong> ${data.hint}`;
                    document.getElementById('hints-display').appendChild(hintDiv);
                } else {
                    alert(data.message);
                    document.getElementById('hint-btn').disabled = true;
                }
            }

            function highlightSuccess() {
                document.querySelector('.question-card').style.borderColor = '#2ea043';
                document.querySelector('.question-card').style.borderStyle = 'solid';
                document.querySelector('.question-card').style.borderWidth = '2px';
            }

            // Update URL for shareability
            if (!window.location.pathname.endsWith('/' + challengeId)) {
                const shareableUrl = `/games/career/${challengeId}`;
                window.history.replaceState({ path: shareableUrl }, '', shareableUrl);
            }
        </script>
    @endpush
@endsection