@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-8">
    <div class="max-w-[1200px] mx-auto">

        {{-- Hero Header --}}
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary/10 border border-primary/20 mb-6">
                <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1">bolt</span>
                <span class="text-[10px] font-display font-black uppercase tracking-[0.2em] text-primary">{{ __('Multiplayer Speed Game') }}</span>
            </div>
            <h1 class="text-5xl sm:text-6xl font-display font-black uppercase tracking-tight mb-4">
                <span class="bg-gradient-to-r from-primary via-secondary to-tertiary bg-clip-text text-transparent">{{ __('Silhouette Arena') }}</span>
                <span class="text-on-surface"> هوية الظل</span>
            </h1>
            <p class="text-on-surface-variant text-lg max-w-xl mx-auto leading-relaxed">
                {{ __('Compete in real-time! Be the fastest player to identify the silhouette and win the point.') }}
            </p>
        </div>

        {{-- Action Bar --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-on-surface-variant">meeting_room</span>
                <h2 class="font-display font-black uppercase tracking-tight text-lg text-on-surface">{{ __('Public Rooms') }}</h2>
                <span id="room-count-badge" class="px-2.5 py-0.5 rounded-full bg-primary/10 text-primary text-xs font-display font-bold">0</span>
            </div>

            <div class="flex items-center gap-3">
                {{-- Join by Code --}}
                <div class="flex items-center gap-2">
                    <input type="text" id="join-code-input" placeholder="{{ __('Room Code') }}" maxlength="6"
                        class="w-28 bg-surface-variant/50 border border-outline-variant/30 rounded-xl px-3 py-2.5 text-sm font-display font-bold uppercase tracking-widest text-center focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/30 transition-all placeholder:text-on-surface-variant/40">
                    <button id="join-code-btn" class="px-4 py-2.5 rounded-xl bg-surface-variant/50 border border-outline-variant/30 text-on-surface-variant font-display font-bold text-xs uppercase tracking-widest hover:border-primary hover:text-primary transition-all active:scale-95">
                        {{ __('Join') }}
                    </button>
                </div>

                {{-- Create Room --}}
                @auth
                <button id="create-room-btn" class="flex items-center gap-2 px-6 py-2.5 rounded-xl bg-primary text-on-primary font-display font-bold text-xs uppercase tracking-widest shadow-lg shadow-primary/20 hover:brightness-110 active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-lg">add</span>
                    {{ __('Create Room') }}
                </button>
                @else
                <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="flex items-center gap-2 px-6 py-2.5 rounded-xl bg-primary text-on-primary font-display font-bold text-xs uppercase tracking-widest shadow-lg shadow-primary/20 hover:brightness-110 active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-lg">login</span>
                    {{ __('Login to Play') }}
                </a>
                @endauth
            </div>
        </div>

        {{-- Rooms Grid --}}
        <div id="rooms-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            {{-- Rooms will be populated via JS --}}
        </div>

        {{-- Empty State --}}
        <div id="rooms-empty" class="hidden">
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="w-24 h-24 rounded-full bg-surface-variant/50 flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-5xl text-on-surface-variant/40">sports_esports</span>
                </div>
                <h3 class="font-display font-black uppercase tracking-tight text-xl text-on-surface mb-2">{{ __('No Rooms Yet') }}</h3>
                <p class="text-on-surface-variant text-sm max-w-sm">{{ __('Be the first to create a room and invite your friends to play!') }}</p>
            </div>
        </div>

        {{-- Loading State --}}
        <div id="rooms-loading" class="flex items-center justify-center py-20">
            <div class="flex items-center gap-3">
                <div class="w-5 h-5 border-2 border-primary/30 border-t-primary rounded-full animate-spin"></div>
                <span class="font-display font-bold text-sm uppercase tracking-widest text-on-surface-variant">{{ __('Loading rooms...') }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Create Room Modal --}}
<div id="create-room-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-zinc-950/80 backdrop-blur-md">
    <div class="bg-surface dark:bg-zinc-900 border border-outline-variant/30 max-w-lg w-full rounded-[2.5rem] p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-display font-black uppercase tracking-tight text-on-surface">{{ __('Create Room') }}</h3>
            <button id="close-create-modal" class="p-2 rounded-full hover:bg-surface-variant/50 text-on-surface-variant transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="create-room-form" class="space-y-6">
            @csrf
            {{-- Visibility --}}
            <div>
                <label class="block text-[10px] font-display font-black uppercase tracking-[0.2em] text-on-surface-variant mb-3">{{ __('Visibility') }}</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="visibility" value="public" checked class="peer sr-only">
                        <div class="p-4 rounded-2xl border-2 border-outline-variant/30 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center">
                            <span class="material-symbols-outlined text-2xl mb-1 text-on-surface-variant peer-checked:text-primary" style="font-variation-settings: 'FILL' 1">public</span>
                            <div class="text-xs font-display font-bold uppercase tracking-widest">{{ __('Public') }}</div>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="visibility" value="private" class="peer sr-only">
                        <div class="p-4 rounded-2xl border-2 border-outline-variant/30 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center">
                            <span class="material-symbols-outlined text-2xl mb-1 text-on-surface-variant peer-checked:text-primary" style="font-variation-settings: 'FILL' 1">lock</span>
                            <div class="text-xs font-display font-bold uppercase tracking-widest">{{ __('Private') }}</div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Mode --}}
            <div>
                <label class="block text-[10px] font-display font-black uppercase tracking-[0.2em] text-on-surface-variant mb-3">{{ __('Game Mode') }}</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="mode" value="individual" checked class="peer sr-only">
                        <div class="p-4 rounded-2xl border-2 border-outline-variant/30 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center">
                            <span class="material-symbols-outlined text-2xl mb-1" style="font-variation-settings: 'FILL' 1">person</span>
                            <div class="text-xs font-display font-bold uppercase tracking-widest">{{ __('Individual') }}</div>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="mode" value="teams" class="peer sr-only">
                        <div class="p-4 rounded-2xl border-2 border-outline-variant/30 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center">
                            <span class="material-symbols-outlined text-2xl mb-1" style="font-variation-settings: 'FILL' 1">groups</span>
                            <div class="text-xs font-display font-bold uppercase tracking-widest">{{ __('Teams') }}</div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Teams count (shown only in teams mode) --}}
            <div id="teams-config" class="hidden">
                <label class="block text-[10px] font-display font-black uppercase tracking-[0.2em] text-on-surface-variant mb-3">{{ __('Number of Teams') }}</label>
                <input type="number" name="num_teams" value="2" min="2" max="6"
                    class="w-full bg-surface-variant/50 border border-outline-variant/30 rounded-xl px-4 py-3 font-display font-bold text-center focus:outline-none focus:border-primary transition-all">
            </div>
            
            {{-- Language --}}
            <div>
                <label class="block text-[10px] font-display font-black uppercase tracking-[0.2em] text-on-surface-variant mb-3">{{ __('Language') }}</label>
                <div class="grid grid-cols-3 gap-3">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="language" value="en" class="peer sr-only">
                        <div class="p-3.5 rounded-2xl border-2 border-outline-variant/30 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center">
                            <div class="text-xs font-display font-black uppercase tracking-widest">EN</div>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="language" value="ar" class="peer sr-only">
                        <div class="p-3.5 rounded-2xl border-2 border-outline-variant/30 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center">
                            <div class="text-xs font-display font-black uppercase tracking-widest">AR</div>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="language" value="mix" checked class="peer sr-only">
                        <div class="p-3.5 rounded-2xl border-2 border-outline-variant/30 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center">
                            <div class="text-xs font-display font-black uppercase tracking-widest">{{ __('Mix') }}</div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Genres --}}
            <div>
                <label class="block text-[10px] font-display font-black uppercase tracking-[0.2em] text-on-surface-variant mb-3">{{ __('Genres') }}</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative cursor-pointer">
                        <input type="checkbox" name="genres[]" value="football" checked class="peer sr-only">
                        <div class="p-3 rounded-2xl border-2 border-outline-variant/30 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center text-xs font-display font-bold">
                            ⚽ {{ __('Football') }}
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="checkbox" name="genres[]" value="actors" checked class="peer sr-only">
                        <div class="p-3 rounded-2xl border-2 border-outline-variant/30 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center text-xs font-display font-bold">
                            🎭 {{ __('Actors') }}
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="checkbox" name="genres[]" value="movies" checked class="peer sr-only">
                        <div class="p-3 rounded-2xl border-2 border-outline-variant/30 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center text-xs font-display font-bold">
                            🎬 {{ __('Movies') }}
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="checkbox" name="genres[]" value="geography" checked class="peer sr-only">
                        <div class="p-3 rounded-2xl border-2 border-outline-variant/30 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center text-xs font-display font-bold">
                            🌍 {{ __('Geography') }}
                        </div>
                    </label>
                </div>
            </div>

            {{-- Players --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-display font-black uppercase tracking-[0.2em] text-on-surface-variant mb-3">{{ __('Max Players') }}</label>
                    <input type="number" name="max_players" value="10" min="2" max="50"
                        class="w-full bg-surface-variant/50 border border-outline-variant/30 rounded-xl px-4 py-3 font-display font-bold text-center focus:outline-none focus:border-primary transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-display font-black uppercase tracking-[0.2em] text-on-surface-variant mb-3">{{ __('Min to Start') }}</label>
                    <input type="number" name="min_players_to_start" value="2" min="2" max="50"
                        class="w-full bg-surface-variant/50 border border-outline-variant/30 rounded-xl px-4 py-3 font-display font-bold text-center focus:outline-none focus:border-primary transition-all">
                </div>
            </div>

            {{-- Auto Start --}}
            <div>
                <label class="block text-[10px] font-display font-black uppercase tracking-[0.2em] text-on-surface-variant mb-3">{{ __('Auto-Start at (leave empty to disable)') }}</label>
                <input type="number" name="auto_start_at" placeholder="-" min="2" max="50"
                    class="w-full bg-surface-variant/50 border border-outline-variant/30 rounded-xl px-4 py-3 font-display font-bold text-center focus:outline-none focus:border-primary transition-all placeholder:text-on-surface-variant/30">
            </div>

            {{-- Questions --}}
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-[10px] font-display font-black uppercase tracking-[0.2em] text-on-surface-variant mb-3">{{ __('Questions') }}</label>
                    <input type="number" name="num_questions" value="5" min="1" max="20"
                        class="w-full bg-surface-variant/50 border border-outline-variant/30 rounded-xl px-4 py-3 font-display font-bold text-center focus:outline-none focus:border-primary transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-display font-black uppercase tracking-[0.2em] text-on-surface-variant mb-3">{{ __('Time (sec)') }}</label>
                    <input type="number" name="question_time_seconds" value="60" min="15" max="120"
                        class="w-full bg-surface-variant/50 border border-outline-variant/30 rounded-xl px-4 py-3 font-display font-bold text-center focus:outline-none focus:border-primary transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-display font-black uppercase tracking-[0.2em] text-on-surface-variant mb-3">{{ __('Rest (sec)') }}</label>
                    <input type="number" name="rest_time_seconds" value="10" min="5" max="30"
                        class="w-full bg-surface-variant/50 border border-outline-variant/30 rounded-xl px-4 py-3 font-display font-bold text-center focus:outline-none focus:border-primary transition-all">
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" id="submit-create-room"
                class="w-full py-4 rounded-2xl bg-primary text-on-primary font-display font-black uppercase tracking-widest text-sm shadow-xl shadow-primary/20 hover:brightness-110 active:scale-[0.98] transition-all">
                {{ __('Create Room') }}
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const locale = '{{ app()->getLocale() }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

    const roomsList = document.getElementById('rooms-list');
    const roomsEmpty = document.getElementById('rooms-empty');
    const roomsLoading = document.getElementById('rooms-loading');
    const roomCountBadge = document.getElementById('room-count-badge');

    // ── Fetch Rooms ──
    async function fetchRooms() {
        try {
            const res = await fetch(`/${locale}/silhouette/rooms`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();
            renderRooms(data.rooms || []);
        } catch (e) {
            console.error('Failed to fetch rooms:', e);
            roomsLoading.classList.add('hidden');
        }
    }

    function renderRooms(rooms) {
        roomsLoading.classList.add('hidden');
        roomCountBadge.textContent = rooms.length;

        if (rooms.length === 0) {
            roomsList.innerHTML = '';
            roomsEmpty.classList.remove('hidden');
            return;
        }

        roomsEmpty.classList.add('hidden');
        roomsList.innerHTML = rooms.map(room => `
            <div class="group relative bg-surface-variant/30 dark:bg-surface-variant/20 border border-outline-variant/20 rounded-3xl p-6 hover:border-primary/40 hover:shadow-lg hover:shadow-primary/5 transition-all duration-300 cursor-pointer" data-code="${room.code}">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1">${room.mode === 'teams' ? 'groups' : 'person'}</span>
                        </div>
                        <div>
                            <div class="font-display font-black uppercase tracking-tight text-on-surface text-sm">${room.owner.name}</div>
                            <div class="text-[10px] text-on-surface-variant/60 font-display font-bold uppercase tracking-widest">${room.created_at}</div>
                        </div>
                    </div>
                    <div class="px-3 py-1 rounded-full text-[10px] font-display font-bold uppercase tracking-widest ${room.is_full ? 'bg-error/10 text-error' : 'bg-tertiary/10 text-tertiary'}">
                        ${room.is_full ? '{{ __("Full") }}' : '{{ __("Open") }}'}
                    </div>
                </div>
                <div class="flex items-center gap-4 text-xs text-on-surface-variant">
                    <div class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">group</span>
                        <span class="font-display font-bold">${room.players_count}/${room.max_players}</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">quiz</span>
                        <span class="font-display font-bold">${room.num_questions} {{ __('Q') }}</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">timer</span>
                        <span class="font-display font-bold">${room.question_time_seconds}s</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">${room.mode === 'teams' ? 'groups' : 'person'}</span>
                        <span class="font-display font-bold uppercase">${room.mode}</span>
                    </div>
                </div>
                ${!room.is_full ? `
                <button class="join-room-btn mt-4 w-full py-3 rounded-xl bg-primary/10 text-primary font-display font-bold text-xs uppercase tracking-widest hover:bg-primary hover:text-on-primary transition-all active:scale-[0.98]" data-code="${room.code}">
                    {{ __('Join Room') }}
                </button>` : ''}
            </div>
        `).join('');

        // Attach join handlers
        document.querySelectorAll('.join-room-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                joinRoom(btn.dataset.code);
            });
        });
    }

    async function joinRoom(code) {
        if (!isLoggedIn) {
            window.location.href = `/${locale}/login`;
            return;
        }
        try {
            const res = await fetch(`/${locale}/silhouette/rooms/${code}/join`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            });
            if (res.ok) {
                window.location.href = `/${locale}/silhouette/room/${code}`;
            } else {
                const err = await res.json();
                alert(err.message || 'Failed to join');
            }
        } catch (e) {
            console.error(e);
        }
    }

    document.getElementById('join-code-btn')?.addEventListener('click', () => {
        const code = document.getElementById('join-code-input').value.trim().toUpperCase();
        if (code.length === 6) {
            joinRoom(code);
        }
    });

    document.getElementById('join-code-input')?.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            document.getElementById('join-code-btn')?.click();
        }
    });

    const createModal = document.getElementById('create-room-modal');
    document.getElementById('create-room-btn')?.addEventListener('click', () => {
        createModal.classList.remove('hidden');
        createModal.classList.add('flex');
    });
    document.getElementById('close-create-modal')?.addEventListener('click', () => {
        createModal.classList.add('hidden');
        createModal.classList.remove('flex');
    });
    createModal?.addEventListener('click', (e) => {
        if (e.target === createModal) {
            createModal.classList.add('hidden');
            createModal.classList.remove('flex');
        }
    });

    document.querySelectorAll('input[name="mode"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            document.getElementById('teams-config').classList.toggle('hidden', e.target.value !== 'teams');
        });
    });

    document.getElementById('create-room-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const data = {};
        
        formData.forEach((value, key) => {
            if (key.endsWith('[]')) {
                const cleanKey = key.slice(0, -2);
                if (!data[cleanKey]) data[cleanKey] = [];
                data[cleanKey].push(value);
            } else {
                data[key] = value;
            }
        });

        ['max_players', 'min_players_to_start', 'auto_start_at', 'num_questions', 'question_time_seconds', 'rest_time_seconds', 'num_teams'].forEach(k => {
            if (data[k] !== undefined && data[k] !== '') data[k] = parseInt(data[k]);
            else if (k === 'auto_start_at') data[k] = null;
        });

        const btn = document.getElementById('submit-create-room');
        btn.disabled = true;
        btn.textContent = '{{ __("Creating...") }}';

        try {
            const res = await fetch(`/${locale}/silhouette/rooms`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data),
            });

            if (res.ok) {
                const result = await res.json();
                window.location.href = `/${locale}/silhouette/room/${result.room.code}`;
            } else {
                const err = await res.json();
                alert(err.message || JSON.stringify(err.errors || 'Failed to create room'));
                btn.disabled = false;
                btn.textContent = '{{ __("Create Room") }}';
            }
        } catch (e) {
            console.error(e);
            btn.disabled = false;
            btn.textContent = '{{ __("Create Room") }}';
        }
    });

    fetchRooms();
    setInterval(fetchRooms, 10000);
});
</script>
@endpush
