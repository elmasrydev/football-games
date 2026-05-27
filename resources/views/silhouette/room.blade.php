@extends('layouts.app')

@section('content')
<div id="silhouette-app" class="min-h-screen" data-code="{{ $code }}" data-locale="{{ app()->getLocale() }}" data-user-id="{{ auth()->id() }}" data-csrf="{{ csrf_token() }}">

    {{-- ═══ WAITING ROOM STATE ═══ --}}
    <div id="state-waiting" class="hidden py-8 px-4 sm:px-8">
        <div class="max-w-[900px] mx-auto">
            {{-- Room Header --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary/10 border border-primary/20 mb-4">
                    <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1">meeting_room</span>
                    <span class="text-[10px] font-display font-black uppercase tracking-[0.2em] text-primary">{{ __('Room') }} <span id="room-code-display" class="text-base">{{ $code }}</span></span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-display font-black uppercase tracking-tight text-on-surface mb-2">{{ __('Waiting for Players') }}</h1>
                <p class="text-on-surface-variant text-sm" id="player-count-text">0 / 0 {{ __('players') }}</p>
            </div>

            {{-- Share Link --}}
            <div id="share-section" class="mb-8">
                <div class="bg-surface-variant/30 dark:bg-surface-variant/20 border border-outline-variant/20 rounded-2xl p-5 flex items-center gap-4">
                    <span class="material-symbols-outlined text-on-surface-variant">link</span>
                    <input type="text" id="share-link" readonly class="flex-1 bg-transparent text-sm font-mono text-on-surface-variant truncate focus:outline-none">
                    <button id="copy-link-btn" class="px-4 py-2 rounded-xl bg-primary/10 text-primary font-display font-bold text-xs uppercase tracking-widest hover:bg-primary hover:text-on-primary transition-all active:scale-95">
                        {{ __('Copy') }}
                    </button>
                </div>
            </div>

            {{-- Room Config Summary --}}
            <div id="room-config" class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-8">
                {{-- Filled by JS --}}
            </div>

            {{-- Players List --}}
            <div class="mb-8">
                <h3 class="font-display font-black uppercase tracking-tight text-sm text-on-surface-variant mb-4">{{ __('Players') }}</h3>
                <div id="players-list" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    {{-- Filled by JS --}}
                </div>
            </div>

            {{-- Teams Section (teams mode only) --}}
            <div id="teams-section" class="hidden mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display font-black uppercase tracking-tight text-sm text-on-surface-variant">{{ __('Teams') }}</h3>
                    <button id="auto-teams-btn" class="hidden px-4 py-2 rounded-xl bg-secondary/10 text-secondary font-display font-bold text-[10px] uppercase tracking-widest hover:bg-secondary hover:text-on-secondary transition-all">
                        {{ __('Auto-Assign') }}
                    </button>
                </div>
                <div id="teams-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Filled by JS --}}
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-4 justify-center">
                <button id="start-game-btn" class="hidden px-8 py-4 rounded-2xl bg-primary text-on-primary font-display font-black uppercase tracking-widest text-sm shadow-xl shadow-primary/20 hover:brightness-110 active:scale-[0.98] transition-all">
                    <span class="material-symbols-outlined align-middle me-2">play_arrow</span>
                    {{ __('Start Game') }}
                </button>
                <button id="leave-room-btn" class="px-6 py-3 rounded-xl bg-error/10 text-error font-display font-bold text-xs uppercase tracking-widest hover:bg-error hover:text-on-error transition-all">
                    {{ __('Leave Room') }}
                </button>
            </div>
        </div>
    </div>

    {{-- ═══ COUNTDOWN STATE ═══ --}}
    <div id="state-countdown" class="hidden min-h-[80vh] flex items-center justify-center">
        <div class="text-center">
            <h2 class="text-2xl font-display font-black uppercase tracking-widest text-on-surface-variant mb-6">{{ __('Game Starting') }}</h2>
            <div id="countdown-number" class="text-[120px] font-display font-black text-primary leading-none animate-pulse">3</div>
        </div>
    </div>

    {{-- ═══ GAME STATE ═══ --}}
    <div id="state-game" class="hidden py-6 px-4 sm:px-8">
        <div class="max-w-[900px] mx-auto">
            {{-- Question Header --}}
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-display font-black uppercase tracking-[0.2em] text-on-surface-variant">{{ __('Question') }}</span>
                    <span id="question-counter" class="px-3 py-1 rounded-full bg-primary/10 text-primary font-display font-bold text-sm">1/5</span>
                </div>
                <div id="timer-display" class="flex items-center gap-2 px-4 py-2 rounded-full bg-error/10 border border-error/20">
                    <span class="material-symbols-outlined text-error text-lg">timer</span>
                    <span id="timer-seconds" class="font-display font-black text-xl text-error tabular-nums">60</span>
                </div>
            </div>

            {{-- Timer Bar --}}
            <div class="w-full h-1.5 bg-surface-variant/50 rounded-full mb-8 overflow-hidden">
                <div id="timer-bar" class="h-full bg-gradient-to-r from-primary to-error rounded-full transition-all duration-1000 ease-linear" style="width: 100%"></div>
            </div>

            {{-- Silhouette Image --}}
            <div id="silhouette-image-container" class="hidden flex justify-center mb-6">
                <img id="silhouette-image" class="max-h-[320px] max-w-full object-contain rounded-3xl border border-outline-variant/10 shadow-2xl transition-all duration-500" src="" alt="Silhouette">
            </div>

            {{-- Question Clue/Text --}}
            <div class="bg-surface-variant/30 dark:bg-surface-variant/20 border border-outline-variant/20 rounded-3xl p-8 mb-6 text-center">
                <p id="question-text" class="text-2xl sm:text-3xl font-display font-black text-on-surface leading-snug"></p>
            </div>

            {{-- Answer Input --}}
            <div class="relative mb-6">
                <input type="text" id="answer-input" placeholder="{{ __('Type your answer and press Enter...') }}" autocomplete="off"
                    class="w-full bg-surface-variant/50 border-2 border-outline-variant/30 rounded-2xl px-6 py-4 text-lg font-display font-bold focus:outline-none focus:border-primary transition-all placeholder:text-on-surface-variant/40"
                    autofocus>
                <div id="answer-feedback" class="absolute end-4 top-1/2 -translate-y-1/2 hidden">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1"></span>
                </div>
            </div>

            {{-- Status Alert --}}
            <div id="game-status-alert" class="hidden p-4 rounded-xl border mb-6 text-center text-sm font-display font-bold uppercase tracking-wider">
                {{-- Filled dynamically --}}
            </div>

            {{-- Live Scoreboard --}}
            <div class="bg-surface-variant/20 border border-outline-variant/10 rounded-2xl p-4">
                <h4 class="text-[10px] font-display font-black uppercase tracking-[0.2em] text-on-surface-variant mb-3">{{ __('Live Scores') }}</h4>
                <div id="live-scores" class="space-y-2">
                    {{-- Filled by JS --}}
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ REST STATE (between questions) ═══ --}}
    <div id="state-rest" class="hidden min-h-[80vh] flex items-center justify-center py-8 px-4">
        <div class="max-w-[600px] w-full text-center">
            <h2 class="text-2xl font-display font-black uppercase tracking-widest text-on-surface-variant mb-4">{{ __('Round Results') }}</h2>
            
            {{-- Reveal Area --}}
            <div id="rest-reveal-card" class="bg-surface-variant/30 border border-outline-variant/20 rounded-3xl p-6 mb-8 flex flex-col items-center">
                <img id="reveal-image" class="max-h-[260px] object-contain rounded-2xl shadow-xl mb-4 hidden" src="" alt="Revealed Answer">
                <div class="text-[10px] font-display font-black uppercase tracking-[0.2em] text-primary mb-1">{{ __('Correct Answer') }}</div>
                <div id="reveal-answer-text" class="text-2xl font-display font-black text-on-surface"></div>
            </div>

            <div id="rest-round-results" class="mb-8">
                {{-- Filled by JS --}}
            </div>
            
            <div class="flex items-center justify-center gap-2 text-on-surface-variant">
                <span class="material-symbols-outlined text-sm">timer</span>
                <span class="text-sm font-display font-bold uppercase tracking-widest">{{ __('Next question in') }}</span>
                <span id="rest-timer" class="text-lg font-display font-black text-primary">10</span>
            </div>
        </div>
    </div>

    {{-- ═══ FINISHED STATE ═══ --}}
    <div id="state-finished" class="hidden py-8 px-4 sm:px-8">
        <div class="max-w-[700px] mx-auto text-center">
            <div class="mb-8">
                <span class="material-symbols-outlined text-6xl text-primary mb-4" style="font-variation-settings: 'FILL' 1">emoji_events</span>
                <h1 class="text-4xl sm:text-5xl font-display font-black uppercase tracking-tight text-on-surface mb-2">{{ __('Game Over!') }}</h1>
            </div>

            {{-- Winner --}}
            <div id="winner-card" class="bg-gradient-to-br from-primary/20 to-secondary/20 border border-primary/30 rounded-3xl p-8 mb-8">
                <div class="text-[10px] font-display font-black uppercase tracking-[0.2em] text-primary mb-3">🏆 {{ __('Winner') }}</div>
                <div id="winner-name" class="text-3xl font-display font-black text-on-surface mb-1"></div>
                <div id="winner-score" class="text-xl font-display font-bold text-primary"></div>
            </div>

            {{-- Full Leaderboard --}}
            <div id="final-leaderboard" class="space-y-3 mb-8 text-start">
                {{-- Filled by JS --}}
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-center gap-4">
                <a href="/{{ app()->getLocale() }}/silhouette" class="px-6 py-3 rounded-xl bg-surface-variant/50 text-on-surface font-display font-bold text-xs uppercase tracking-widest hover:bg-primary/10 hover:text-primary transition-all">
                    {{ __('Back to Lobby') }}
                </a>
            </div>
        </div>
    </div>

    {{-- ═══ NOT JOINED STATE ═══ --}}
    <div id="state-join" class="hidden min-h-[80vh] flex items-center justify-center py-8 px-4">
        <div class="max-w-[400px] w-full text-center">
            <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-4xl text-primary" style="font-variation-settings: 'FILL' 1">lock_open</span>
            </div>
            <h2 class="text-2xl font-display font-black uppercase tracking-tight text-on-surface mb-2">{{ __('Join Room') }}</h2>
            <p class="text-on-surface-variant text-sm mb-6" id="join-room-info"></p>
            @auth
            <button id="join-this-room-btn" class="px-8 py-4 rounded-2xl bg-primary text-on-primary font-display font-black uppercase tracking-widest text-sm shadow-xl shadow-primary/20 hover:brightness-110 active:scale-[0.98] transition-all">
                {{ __('Join Room') }}
            </button>
            @else
            <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="inline-block px-8 py-4 rounded-2xl bg-primary text-on-primary font-display font-black uppercase tracking-widest text-sm shadow-xl shadow-primary/20 hover:brightness-110 transition-all">
                {{ __('Login to Join') }}
            </a>
            @endauth
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const app = document.getElementById('silhouette-app');
    const code = app.dataset.code;
    const locale = app.dataset.locale;
    const userId = parseInt(app.dataset.userId) || null;
    const csrfToken = app.dataset.csrf;
    const isAr = locale === 'ar';

    const states = {
        waiting: document.getElementById('state-waiting'),
        countdown: document.getElementById('state-countdown'),
        game: document.getElementById('state-game'),
        rest: document.getElementById('state-rest'),
        finished: document.getElementById('state-finished'),
        join: document.getElementById('state-join'),
    };

    let room = null;
    let myPlayerId = null;
    let timerInterval = null;
    let liveScores = {};
    let currentQuestionIndex = null;
    let currentQuestionState = null;

    function showState(name) {
        Object.values(states).forEach(s => s.classList.add('hidden'));
        states[name].classList.remove('hidden');
    }

    async function api(endpoint, method = 'GET', body = null) {
        const opts = {
            method,
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            },
        };
        if (body) opts.body = JSON.stringify(body);
        const res = await fetch(`/${locale}/silhouette/rooms/${code}${endpoint}`, opts);
        return { ok: res.ok, data: await res.json() };
    }

    async function loadRoom() {
        const { ok, data } = await api('', 'GET');
        if (!ok) return;

        room = data.room;
        myPlayerId = room.players.find(p => p.user_id === userId)?.id || null;

        if (!room.is_current_user_player && room.status === 'waiting') {
            showState('join');
            document.getElementById('join-room-info').textContent =
                `${room.owner.name}'s room • ${room.players.length}/${room.max_players} players • ${room.mode}`;
            return;
        }

        switch (room.status) {
            case 'waiting': renderWaiting(); break;
            case 'starting': showCountdown(3); break;
            case 'in_progress':
                if (room.current_question) {
                    const cq = room.current_question;
                    currentQuestionIndex = cq.question_index;
                    currentQuestionState = cq.is_active ? 'active' : 'rest';
                    if (cq.is_active) {
                        showQuestion({
                            question_index: cq.question_index,
                            total_questions: cq.total_questions,
                            question_text: cq.question_text,
                            question_text_ar: cq.question_text_ar,
                            image_path: cq.image_path,
                            end_time: cq.end_time,
                            time_seconds: cq.time_seconds
                        });

                        liveScores = cq.live_scores || {};
                        renderLiveScores();
                    } else if (cq.is_rest) {
                        showRoundResults({
                            rest_time_seconds: cq.rest_remaining_seconds,
                            round_results: cq.rest_results ? cq.rest_results.round_results : {},
                            correct_answer: cq.rest_results ? cq.rest_results.correct_answer : '',
                            reveal_image_path: cq.rest_results ? cq.rest_results.reveal_image_path : null
                        });
                    }
                } else {
                    showState('game');
                }
                break;
            case 'finished': loadResults(); break;
            case 'closed':
                alert(isAr ? 'تم إغلاق الغرفة' : 'Room has been closed');
                window.location.href = `/${locale}/silhouette`;
                break;
        }
    }

    function renderWaiting() {
        showState('waiting');
        document.getElementById('player-count-text').textContent =
            `${room.players.length} / ${room.max_players} ${isAr ? 'لاعبين' : 'players'}`;
        document.getElementById('share-link').value = room.share_link;

        const configEl = document.getElementById('room-config');
        configEl.innerHTML = [
            { icon: 'quiz', label: isAr ? 'أسئلة' : 'Questions', value: room.num_questions },
            { icon: 'timer', label: isAr ? 'وقت' : 'Time', value: `${room.question_time_seconds}s` },
            { icon: 'pause', label: isAr ? 'راحة' : 'Rest', value: `${room.rest_time_seconds}s` },
            { icon: room.mode === 'teams' ? 'groups' : 'person', label: isAr ? 'الوضع' : 'Mode', value: room.mode === 'teams' ? (isAr ? 'فرق' : 'Teams') : (isAr ? 'فردي' : 'Individual') },
        ].map(c => `
            <div class="bg-surface-variant/30 dark:bg-surface-variant/20 border border-outline-variant/20 rounded-2xl p-4 text-center">
                <span class="material-symbols-outlined text-primary text-lg mb-1">${c.icon}</span>
                <div class="font-display font-black text-on-surface text-lg">${c.value}</div>
                <div class="text-[9px] font-display font-bold uppercase tracking-[0.15em] text-on-surface-variant/60">${c.label}</div>
            </div>
        `).join('');

        const playersEl = document.getElementById('players-list');
        const displayedPlayers = room.mode === 'teams' ? room.players.filter(p => !p.team) : room.players;

        playersEl.innerHTML = displayedPlayers.map(p => `
            <div class="player-card flex items-center gap-3 bg-surface-variant/30 dark:bg-surface-variant/20 border border-outline-variant/20 rounded-xl p-3 ${!p.is_connected ? 'opacity-40' : ''} ${room.is_current_user_owner && room.mode === 'teams' ? 'cursor-grab active:cursor-grabbing' : ''}" 
                 draggable="${room.is_current_user_owner && room.mode === 'teams' ? 'true' : 'false'}" 
                 data-player-id="${p.id}">
                <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary font-display font-black text-sm">
                    ${p.name.charAt(0).toUpperCase()}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-display font-bold text-sm text-on-surface truncate">${p.name}</div>
                    <div class="text-[9px] font-display font-bold uppercase tracking-widest text-on-surface-variant/60">
                        ${p.is_owner ? (isAr ? '👑 المالك' : '👑 Owner') : ''}
                    </div>
                </div>
            </div>
        `).join('') || (room.mode === 'teams' ? `<div class="col-span-full py-6 text-center border-2 border-dashed border-outline-variant/20 rounded-2xl text-xs text-on-surface-variant/40 italic">${isAr ? 'اسحب اللاعبين هنا لإلغاء تعيينهم' : 'Drag players here to unassign'}</div>` : '');

        if (room.mode === 'teams' && room.teams.length > 0) {
            document.getElementById('teams-section').classList.remove('hidden');
            if (room.is_current_user_owner) {
                document.getElementById('auto-teams-btn').classList.remove('hidden');
            }
            const teamsGrid = document.getElementById('teams-grid');
            teamsGrid.innerHTML = room.teams.map(team => {
                const teamPlayers = room.players.filter(p => p.team?.id === team.id);
                return `
                <div class="team-zone border-2 rounded-2xl p-4 transition-all duration-200" data-team-id="${team.id}" style="border-color: ${team.color}20; background: ${team.color}08">
                    <div class="font-display font-black uppercase tracking-tight text-sm mb-3 flex items-center justify-between" style="color: ${team.color}">
                        <span>${team.name}</span>
                        <span class="px-2 py-0.5 rounded bg-surface-variant/30 text-[10px] font-bold text-on-surface-variant">${teamPlayers.length}</span>
                    </div>
                    <div class="space-y-2 min-h-[60px] flex flex-col justify-center">
                        ${teamPlayers.map(p => `
                            <div class="player-card flex items-center justify-between p-2.5 rounded-xl bg-surface-variant/20 border border-outline-variant/10 text-sm font-display font-bold text-on-surface ${room.is_current_user_owner ? 'cursor-grab active:cursor-grabbing' : ''}" draggable="${room.is_current_user_owner ? 'true' : 'false'}" data-player-id="${p.id}">
                                <span>${p.name}</span>
                            </div>
                        `).join('') || `<div class="text-xs text-on-surface-variant/40 italic py-2 text-center select-none">${isAr ? 'اسحب اللاعبين هنا' : 'Drag players here'}</div>`}
                    </div>
                </div>`;
            }).join('');
        }

        const startBtn = document.getElementById('start-game-btn');
        if (room.is_current_user_owner && room.players.length >= room.min_players_to_start) {
            startBtn.classList.remove('hidden');
        } else {
            startBtn.classList.add('hidden');
        }
        initDragAndDrop();
    }

    let draggedPlayerId = null;
    function initDragAndDrop() {
        if (!room || !room.is_current_user_owner || room.mode !== 'teams') return;
        document.querySelectorAll('.player-card').forEach(el => {
            el.addEventListener('dragstart', (e) => {
                draggedPlayerId = el.dataset.playerId;
                e.dataTransfer.setData('text/plain', draggedPlayerId);
                el.classList.add('opacity-50');
            });
            el.addEventListener('dragend', () => {
                el.classList.remove('opacity-50');
            });
        });

        document.querySelectorAll('.team-zone').forEach(zone => {
            zone.addEventListener('dragover', (e) => e.preventDefault());
            zone.addEventListener('drop', async (e) => {
                e.preventDefault();
                const playerId = e.dataTransfer.getData('text/plain') || draggedPlayerId;
                const teamId = zone.dataset.teamId;
                if (playerId && teamId) await assignPlayerToTeam(playerId, teamId);
            });
        });

        const lobbyZone = document.getElementById('players-list');
        if (lobbyZone) {
            lobbyZone.addEventListener('dragover', (e) => e.preventDefault());
            lobbyZone.addEventListener('drop', async (e) => {
                e.preventDefault();
                const playerId = e.dataTransfer.getData('text/plain') || draggedPlayerId;
                if (playerId) await assignPlayerToTeam(playerId, null);
            });
        }
    }

    async function assignPlayerToTeam(playerId, teamId) {
        const { ok } = await api('/teams/assign', 'POST', { player_id: playerId, team_id: teamId });
        if (ok) await loadRoom();
    }

    function showCountdown(seconds) {
        showState('countdown');
        const el = document.getElementById('countdown-number');
        let s = seconds;
        el.textContent = s;
        const iv = setInterval(() => {
            s--;
            if (s <= 0) {
                clearInterval(iv);
                el.textContent = '🚀';
            } else {
                el.textContent = s;
            }
        }, 1000);
    }

    function startTimer(endTimeISO) {
        clearInterval(timerInterval);
        const endTime = new Date(endTimeISO).getTime();
        const totalMs = endTime - Date.now();

        timerInterval = setInterval(() => {
            const remaining = Math.max(0, Math.ceil((endTime - Date.now()) / 1000));
            document.getElementById('timer-seconds').textContent = remaining;

            const pct = Math.max(0, (endTime - Date.now()) / totalMs * 100);
            document.getElementById('timer-bar').style.width = `${pct}%`;

            const timerEl = document.getElementById('timer-display');
            if (remaining <= 10) timerEl.classList.add('animate-pulse');
            if (remaining <= 0) clearInterval(timerInterval);
        }, 100);
    }

    const answerInput = document.getElementById('answer-input');
    const feedbackEl = document.getElementById('answer-feedback');
    const alertEl = document.getElementById('game-status-alert');

    answerInput?.addEventListener('keydown', async (e) => {
        if (e.key !== 'Enter') return;
        const answer = answerInput.value.trim();
        if (!answer) return;

        answerInput.value = '';
        answerInput.disabled = true;

        const { ok, data } = await api('/answer', 'POST', { answer });
        answerInput.disabled = false;
        answerInput.focus();

        feedbackEl.classList.remove('hidden');
        const iconEl = feedbackEl.querySelector('.material-symbols-outlined');

        if (data.status === 'correct') {
            iconEl.textContent = 'check_circle';
            iconEl.className = 'material-symbols-outlined text-2xl text-tertiary';
            answerInput.disabled = true;
            answerInput.placeholder = isAr ? 'إجابة صحيحة! تم إنهاء الجولة...' : 'Correct answer! Round ending...';
        } else if (data.status === 'duplicate') {
            iconEl.textContent = 'info';
            iconEl.className = 'material-symbols-outlined text-2xl text-on-surface-variant';
        } else if (data.status === 'too_late') {
            iconEl.textContent = 'block';
            iconEl.className = 'material-symbols-outlined text-2xl text-error';
            answerInput.disabled = true;
            answerInput.placeholder = isAr ? 'متأخر جداً! قام لاعب آخر بالحل' : 'Too late! Someone else got it';
        } else {
            iconEl.textContent = 'cancel';
            iconEl.className = 'material-symbols-outlined text-2xl text-error';
        }

        setTimeout(() => feedbackEl.classList.add('hidden'), 1500);
    });

    function renderLiveScores() {
        if (!room) return;
        const el = document.getElementById('live-scores');
        const sorted = room.players
            .map(p => ({ ...p, score: liveScores[p.id] || 0 }))
            .sort((a, b) => b.score - a.score);

        el.innerHTML = sorted.map((p, i) => `
            <div class="flex items-center gap-3 ${p.id === myPlayerId ? 'bg-primary/5 rounded-xl p-2 -mx-2' : ''}">
                <span class="w-5 text-center font-display font-black text-xs text-on-surface-variant">${i + 1}</span>
                <div class="w-7 h-7 rounded-lg bg-primary/10 flex items-center justify-center text-primary font-display font-black text-[10px]">
                    ${p.name.charAt(0).toUpperCase()}
                </div>
                <span class="flex-1 font-display font-bold text-sm text-on-surface truncate">${p.name}</span>
                <span class="font-display font-black text-sm text-primary tabular-nums">${p.score}</span>
            </div>
        `).join('');
    }

    function showQuestion(data) {
        showState('game');
        liveScores = {};
        room.players.forEach(p => liveScores[p.id] = 0);

        document.getElementById('question-counter').textContent = `${data.question_index + 1}/${data.total_questions}`;
        document.getElementById('question-text').textContent = isAr ? data.question_text_ar : data.question_text;
        document.getElementById('timer-bar').style.width = '100%';

        const imgEl = document.getElementById('silhouette-image');
        const imgContainer = document.getElementById('silhouette-image-container');
        if (data.image_path) {
            imgEl.src = data.image_path;
            imgEl.style.filter = 'brightness(0)'; // Force silhouette
            imgContainer.classList.remove('hidden');
        } else {
            imgContainer.classList.add('hidden');
        }

        alertEl.classList.add('hidden');
        answerInput.value = '';
        answerInput.disabled = false;
        answerInput.placeholder = isAr ? 'اكتب إجابتك واضغط Enter...' : 'Type your answer and press Enter...';
        answerInput.focus();

        renderLiveScores();
        startTimer(data.end_time);
    }

    function showRoundResults(data) {
        showState('rest');
        clearInterval(timerInterval);

        const resultsEl = document.getElementById('rest-round-results');
        
        // Handle image reveal
        const revealImg = document.getElementById('reveal-image');
        if (data.reveal_image_path) {
            revealImg.src = data.reveal_image_path;
            revealImg.classList.remove('hidden');
        } else {
            revealImg.classList.add('hidden');
        }

        document.getElementById('reveal-answer-text').textContent = data.correct_answer || '';

        if (typeof data.round_results === 'object' && !Array.isArray(data.round_results)) {
            // Team Mode
            const teamEntries = Object.entries(data.round_results.team_scores || {});
            resultsEl.innerHTML = teamEntries.map(([tid, score]) => {
                const t = room?.teams.find(tm => tm.id == tid);
                return `<div class="flex items-center justify-between py-2 border-b border-outline-variant/10">
                    <span class="font-display font-bold" style="color: ${t?.color || 'inherit'}">${t?.name || tid}</span>
                    <span class="font-display font-black text-primary">${score}</span>
                </div>`;
            }).join('') || `<div class="text-xs text-on-surface-variant/40 italic py-4">${isAr ? 'لم يفز أي فريق بهذه الجولة' : 'No teams won this round'}</div>`;
        } else {
            // Individual Mode
            const entries = Object.entries(data.round_results || {});
            resultsEl.innerHTML = entries.map(([pid, score]) => {
                const p = room?.players.find(pl => pl.id == pid);
                return `<div class="flex items-center justify-between py-2 border-b border-outline-variant/10">
                    <span class="font-display font-bold text-on-surface">${p?.name || pid}</span>
                    <span class="font-display font-black text-primary">+${score}</span>
                </div>`;
            }).join('') || `<div class="text-xs text-on-surface-variant/40 italic py-4">${isAr ? 'انتهى الوقت دون إجابة صحيحة!' : 'Time ran out with no correct answers!'}</div>`;
        }

        let restTime = data.rest_time_seconds;
        document.getElementById('rest-timer').textContent = restTime;
        const restIv = setInterval(() => {
            restTime--;
            document.getElementById('rest-timer').textContent = Math.max(0, restTime);
            if (restTime <= 0) clearInterval(restIv);
        }, 1000);
    }

    async function loadResults() {
        showState('finished');
        const { ok, data } = await api('/results');
        if (!ok) return;

        const lb = data.leaderboard;
        if (lb.length > 0) {
            const winner = lb[0];
            document.getElementById('winner-name').textContent = winner.name || winner.team_name || '';
            document.getElementById('winner-score').textContent = `${winner.score} ${isAr ? 'نقطة' : 'points'}`;
        }

        const lbEl = document.getElementById('final-leaderboard');
        lbEl.innerHTML = lb.map((entry, i) => {
            const isWinner = i === 0;
            const name = entry.name || entry.team_name;
            
            let membersHtml = '';
            if (entry.members && entry.members.length > 0) {
                const membersList = entry.members.map(member => {
                    const avatarHtml = member.avatar 
                        ? `<img src="${member.avatar}" class="w-4 h-4 rounded-full object-cover">` 
                        : `<span class="material-symbols-outlined text-[14px] opacity-60">person</span>`;
                    return `
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-surface-variant/40 dark:bg-zinc-800/40 text-[11px] font-semibold text-on-surface-variant border border-outline-variant/5">
                        ${avatarHtml}
                        <span>${member.name}</span>
                        <span class="opacity-65 font-bold">(${member.score})</span>
                    </div>`;
                }).join('');
                
                membersHtml = `<div class="flex flex-wrap gap-1.5 mt-2.5">${membersList}</div>`;
            }

            return `
            <div class="flex items-start gap-4 p-4 rounded-2xl ${isWinner ? 'bg-primary/10 border border-primary/20' : 'bg-surface-variant/20 border border-outline-variant/10'}">
                <div class="w-10 h-10 rounded-full ${isWinner ? 'bg-primary text-on-primary' : 'bg-surface-variant text-on-surface-variant'} flex items-center justify-center font-display font-black text-lg shrink-0 mt-0.5">
                    ${i === 0 ? '🥇' : i === 1 ? '🥈' : i === 2 ? '🥉' : entry.rank}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-display font-bold text-on-surface text-base truncate">${name}</div>
                    ${membersHtml}
                </div>
                <div class="font-display font-black text-xl shrink-0 mt-0.5 ${isWinner ? 'text-primary' : 'text-on-surface-variant'}">${entry.score}</div>
            </div>`;
        }).join('');
    }

    document.getElementById('start-game-btn')?.addEventListener('click', async () => {
        const btn = document.getElementById('start-game-btn');
        btn.disabled = true;
        btn.textContent = isAr ? 'جاري البدء...' : 'Starting...';
        const { ok, data } = await api('/start', 'POST');
        if (ok) {
            showCountdown(3);
        } else {
            alert(data.message);
            btn.disabled = false;
            btn.textContent = isAr ? 'ابدأ اللعبة' : 'Start Game';
        }
    });

    document.getElementById('leave-room-btn')?.addEventListener('click', async () => {
        await api('/leave', 'POST');
        window.location.href = `/${locale}/silhouette`;
    });

    document.getElementById('join-this-room-btn')?.addEventListener('click', async () => {
        const { ok } = await api('/join', 'POST');
        if (ok) loadRoom();
    });

    document.getElementById('copy-link-btn')?.addEventListener('click', () => {
        const input = document.getElementById('share-link');
        navigator.clipboard.writeText(input.value);
        const btn = document.getElementById('copy-link-btn');
        btn.textContent = isAr ? 'تم النسخ!' : 'Copied!';
        setTimeout(() => btn.textContent = isAr ? 'نسخ' : 'Copy', 2000);
    });

    document.getElementById('auto-teams-btn')?.addEventListener('click', async () => {
        await api('/teams/auto', 'POST');
        loadRoom();
    });

    function pollForUpdates() {
        setInterval(async () => {
            if (!room) return;

            const { ok, data } = await api('', 'GET');
            if (!ok) return;

            const oldStatus = room?.status;
            room = data.room;
            myPlayerId = room.players.find(p => p.user_id === userId)?.id || null;

            if (oldStatus !== room.status) {
                switch (room.status) {
                    case 'waiting': renderWaiting(); break;
                    case 'starting': showCountdown(3); break;
                    case 'in_progress':
                        loadRoom();
                        break;
                    case 'finished': loadResults(); break;
                    case 'closed':
                        window.location.href = `/${locale}/silhouette`;
                        break;
                }
            } else if (room.status === 'waiting') {
                renderWaiting();
            } else if (room.status === 'in_progress') {
                const cq = room.current_question;
                if (cq) {
                    const qState = cq.is_active ? 'active' : 'rest';
                    if (currentQuestionIndex !== cq.question_index || currentQuestionState !== qState) {
                        currentQuestionIndex = cq.question_index;
                        currentQuestionState = qState;
                        loadRoom();
                    }
                }
            }
        }, 3000);
    }

    if (window.Echo) {
        window.Echo.channel(`silhouette.room.${code}`)
            .listen('.App\\Events\\Silhouette\\PlayerJoined', () => loadRoom())
            .listen('.App\\Events\\Silhouette\\PlayerLeft', () => loadRoom())
            .listen('.App\\Events\\Silhouette\\GameStarting', (e) => showCountdown(e.countdown_seconds))
            .listen('.App\\Events\\Silhouette\\QuestionStarted', (e) => {
                currentQuestionIndex = e.questionIndex;
                currentQuestionState = 'active';
                showQuestion(e);
            })
            .listen('.App\\Events\\Silhouette\\ScoreUpdate', (e) => {
                liveScores[e.player_id] = e.correct_count;
                renderLiveScores();
            })
            .listen('.App\\Events\\Silhouette\\QuestionEnded', (e) => {
                currentQuestionState = 'rest';
                showRoundResults(e);
            })
            .listen('.App\\Events\\Silhouette\\GameFinished', () => loadResults());
    } else {
        pollForUpdates();
    }

    loadRoom();
});
</script>
@endpush
