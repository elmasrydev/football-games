<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $current_locale ?? app()->getLocale()) }}" 
      dir="{{ $current_direction ?? (app()->getLocale() === 'ar' ? 'rtl' : 'ltr') }}" 
      class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Games Hub') }} - GAMESIANO</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;900&family=Be+Vietnam+Pro:wght@400;500;600;700&family=Readex+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script>
        (function() {
            const savedTheme = localStorage.getItem('fm-theme') || 'dark';
            document.documentElement.classList.remove('light', 'dark');
            document.documentElement.classList.add(savedTheme);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>

<body class="bg-background text-on-background font-sans selection:bg-primary-container selection:text-on-primary-container min-h-screen flex flex-col transition-colors duration-300">
    
    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 w-full z-50 border-b border-outline-variant/20 bg-surface/80 backdrop-blur-xl transition-all duration-300">
        <div class="max-w-[1440px] mx-auto h-20 px-4 sm:px-8 flex items-center justify-between gap-4">
            
            <div class="flex items-center gap-8 lg:gap-12 min-w-0">
                <!-- Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('images/logo.png') }}" alt="Gamesiano Logo" class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-secondary p-1.5 shadow-lg shadow-primary/20">
                        GAMESIANO
                </a>

                <!-- Main Nav -->
                <div class="hidden md:flex items-center gap-6 lg:gap-8 font-display font-bold uppercase tracking-tight text-sm">
                    <a href="{{ route('home') }}" class="transition-all hover:text-primary {{ request()->routeIs('home') ? 'text-primary' : 'text-on-surface-variant' }}">
                        {{ __('Home') }}
                    </a>
                    <a href="{{ route('games.index') }}" class="transition-all hover:text-primary {{ request()->routeIs('games.index', 'games.play') ? 'text-primary' : 'text-on-surface-variant' }}">
                        {{ __('Games') }}
                    </a>
                    <a href="{{ route('about') }}" class="transition-all hover:text-primary {{ request()->routeIs('about') ? 'text-primary' : 'text-on-surface-variant' }}">
                        {{ __('About') }}
                    </a>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                <!-- Search (Desktop) -->
                <div class="relative hidden lg:block group">
                    <span class="material-symbols-outlined absolute start-3 top-1/2 -translate-y-1/2 text-on-surface-variant group-focus-within:text-primary transition-colors">search</span>
                    <input type="text" 
                           placeholder="{{ __('Search Gamesiano...') }}" 
                           class="bg-surface-variant/50 border-b border-outline-variant/30 text-sm py-2 ps-10 pe-4 rounded-t-lg focus:outline-none focus:border-primary focus:bg-surface-variant transition-all w-48 xl:w-64 uppercase font-display font-semibold tracking-wider">
                </div>

                <!-- Theme Toggle -->
                <button type="button" id="theme-toggle" class="p-2.5 rounded-full hover:bg-surface-variant/50 text-on-surface-variant hover:text-primary transition-all active:scale-90" aria-label="Toggle theme">
                    <span class="material-symbols-outlined transition-transform duration-500 [font-variation-settings:'FILL'0]" id="theme-icon">dark_mode</span>
                </button>

                <!-- Language Toggle -->
                <button type="button" id="dir-toggle" class="px-4 py-2 rounded-full border border-outline-variant/30 hover:border-primary text-on-surface-variant hover:text-primary font-display font-bold text-xs uppercase tracking-widest transition-all active:scale-95">
                    <span id="dir-toggle-label">{{ app()->getLocale() === 'en' ? 'AR' : 'EN' }}</span>
                </button>

                <!-- Mobile Menu Toggle -->
                <button class="md:hidden p-2.5 rounded-full hover:bg-surface-variant/50 text-on-surface-variant">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Stats Bar (Under Header) -->
    <div class="pt-20">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-8 py-4">
            <x-game-stats />
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-surface border-t border-outline-variant/10 py-12 px-4 sm:px-8 mt-12 transition-colors duration-300">
        <div class="max-w-[1440px] mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex flex-col items-center md:items-start gap-2">
                <span class="text-xl font-black italic text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary font-display uppercase">GAMESIANO</span>
                <p class="text-on-surface-variant text-xs font-display tracking-widest uppercase opacity-60">© {{ date('Y') }} {{ __('Gamesiano Gaming Hub') }}</p>
            </div>

            <nav class="flex flex-wrap justify-center gap-6 lg:gap-12">
                <a href="{{ route('about') }}" class="text-on-surface-variant hover:text-primary text-xs font-display font-bold uppercase tracking-widest transition-colors">{{ __('About') }}</a>
                <a href="{{ route('contact') }}" class="text-on-surface-variant hover:text-primary text-xs font-display font-bold uppercase tracking-widest transition-colors">{{ __('Contact') }}</a>
                <a href="{{ route('privacy') }}" class="text-on-surface-variant hover:text-primary text-xs font-display font-bold uppercase tracking-widest transition-colors">{{ __('Privacy') }}</a>
                <a href="{{ route('terms') }}" class="text-on-surface-variant hover:text-primary text-xs font-display font-bold uppercase tracking-widest transition-colors">{{ __('Terms') }}</a>
            </nav>

            <div class="flex gap-4">
                <a href="#" class="w-10 h-10 rounded-full border border-outline-variant/30 flex items-center justify-center text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-lg">public</span>
                </a>
                <a href="#" class="w-10 h-10 rounded-full border border-outline-variant/30 flex items-center justify-center text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-lg">chat</span>
                </a>
            </div>
        </div>
    </footer>

    <!-- Hint Modal -->
    <div id="hint-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-zinc-950/60 backdrop-blur-sm">
        <div class="glass-card max-w-sm w-full rounded-3xl p-8 text-center shadow-2xl animate-in zoom-in-95 duration-200">
            <div class="mb-6 flex justify-center">
                <div class="w-20 h-20 rounded-full bg-secondary/10 flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1">lightbulb</span>
                </div>
            </div>
            <h3 class="text-2xl font-display font-black uppercase tracking-tight mb-3">{{ __('Need a Hint?') }}</h3>
            <p class="text-on-surface-variant text-sm mb-8 leading-relaxed">{{ __('Watch a short video ad to unlock the next clue for this challenge.') }}</p>
            <div class="flex flex-col gap-3">
                <button id="modal-watch-ad" class="bg-primary text-on-primary font-display font-black uppercase tracking-widest py-4 rounded-2xl shadow-xl shadow-primary/20 hover:brightness-110 active:scale-95 transition-all">
                    {{ __('Watch Ad for Hint') }}
                </button>
                <button id="modal-close" class="text-on-surface-variant font-display font-bold uppercase tracking-widest py-3 hover:text-on-surface transition-all">
                    {{ __('No Thanks') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/bookmarks.js') }}"></script>
    <script src="{{ asset('js/autocomplete.js') }}?v={{ file_exists(public_path('js/autocomplete.js')) ? filemtime(public_path('js/autocomplete.js')) : time() }}"></script>
    
    <script>
        (function() {
            const root = document.documentElement;
            const themeToggle = document.getElementById('theme-toggle');
            const dirToggle = document.getElementById('dir-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const localePreferenceUrl = @json(route('preferences.locale'));

            function updateThemeIcon() {
                const isDark = root.classList.contains('dark');
                if (themeIcon) {
                    themeIcon.textContent = isDark ? 'light_mode' : 'dark_mode';
                    themeIcon.style.fontVariationSettings = isDark ? "'FILL' 1" : "'FILL' 0";
                }
            }

            themeToggle?.addEventListener('click', () => {
                const isDark = root.classList.contains('dark');
                const nextTheme = isDark ? 'light' : 'dark';
                
                root.classList.remove('light', 'dark');
                root.classList.add(nextTheme);
                localStorage.setItem('fm-theme', nextTheme);
                updateThemeIcon();
            });

            dirToggle?.addEventListener('click', async () => {
                const currentLocale = root.lang === 'ar' ? 'ar' : 'en';
                const nextLocale = currentLocale === 'en' ? 'ar' : 'en';

                dirToggle.disabled = true;

                try {
                    const response = await fetch(localePreferenceUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({
                            locale: nextLocale,
                            current_url: window.location.pathname + window.location.search,
                        }),
                    });

                    if (!response.ok) throw new Error('Locale update failed');

                    const data = await response.json();
                    window.location.assign(data.redirect_url);
                } catch (error) {
                    console.error(error);
                    dirToggle.disabled = false;
                }
            });

            updateThemeIcon();
        })();

        // Hint Modal Logic
        function openHintModal(onConfirm) {
            const modal = document.getElementById('hint-modal');
            const watchBtn = document.getElementById('modal-watch-ad');
            const closeBtn = document.getElementById('modal-close');
            if (!modal) return;

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const closeModal = () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                watchBtn.removeEventListener('click', confirmAction);
            };

            const confirmAction = () => {
                closeModal();
                if (onConfirm) onConfirm();
            };

            watchBtn.addEventListener('click', confirmAction);
            closeBtn.addEventListener('click', closeModal);
            modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
        }
    </script>

    @stack('scripts')
</body>
</html>
