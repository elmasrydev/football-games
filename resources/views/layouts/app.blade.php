<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $current_locale ?? app()->getLocale()) }}"
    dir="{{ $current_direction ?? (app()->getLocale() === 'ar' ? 'rtl' : 'ltr') }}" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-seo />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;900&family=Be+Vietnam+Pro:wght@400;500;600;700&family=Readex+Pro:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        (function () {
            const savedTheme = localStorage.getItem('fm-theme') || 'dark';
            document.documentElement.classList.remove('light', 'dark');
            document.documentElement.classList.add(savedTheme);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3K9YNH5F49"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-3K9YNH5F49');
    </script>

    @stack('styles')
</head>

<body
    class="bg-background text-on-background font-sans selection:bg-primary-container selection:text-on-primary-container min-h-screen flex flex-col transition-colors duration-300">

    <!-- Top Navigation Bar -->
    <nav
        class="fixed top-0 w-full z-50 border-b border-outline-variant/20 bg-surface/80 backdrop-blur-xl transition-all duration-300">
        <div class="max-w-[1440px] mx-auto h-20 px-4 sm:px-8 flex items-center justify-between gap-4">

            <div class="flex items-center gap-8 lg:gap-12 min-w-0">
                <!-- Brand -->
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="flex items-center shrink-0 overflow-hidden">
                    <img src="{{ asset('images/logo_dark.png') }}" alt="Gamesiano Logo"
                        class="h-[120px] w-[200px] object-contain hidden dark:block mix-blend-screen">
                    <img src="{{ asset('images/logo_light.png') }}" alt="Gamesiano Logo"
                        class="h-[120px] w-[200px] object-contain block dark:hidden mix-blend-multiply">
                </a>

                <!-- Main Nav -->
                <div
                    class="hidden md:flex items-center gap-6 lg:gap-8 font-display font-bold uppercase tracking-tight text-sm">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}"
                        class="transition-all hover:text-primary {{ request()->routeIs('home') ? 'text-primary' : 'text-on-surface-variant' }}">
                        {{ __('Home') }}
                    </a>
                    <!-- Games Dropdown -->
                    <div class="relative group">
                        <a href="{{ route('games.index', ['locale' => app()->getLocale()]) }}"
                            class="flex items-center gap-1 transition-all hover:text-primary {{ request()->routeIs('games.index', 'games.play', 'games.genre') ? 'text-primary' : 'text-on-surface-variant' }}">
                            {{ __('Games') }}
                            <span class="material-symbols-outlined text-[18px] transition-transform group-hover:rotate-180">expand_more</span>
                        </a>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute top-full start-0 pt-4 opacity-0 translate-y-2 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-300 z-[100]">
                            <div class="w-72 bg-surface dark:bg-zinc-900 border border-outline-variant/30 rounded-3xl shadow-2xl overflow-hidden py-3 backdrop-blur-xl">
                                @foreach($all_genres ?? [] as $genre)
                                    <a href="{{ route('games.genre', ['locale' => app()->getLocale(), 'genre_slug' => $genre->slug]) }}" 
                                       class="flex items-center gap-4 px-5 py-3.5 hover:bg-primary/10 transition-colors group/item">
                                        <div class="w-10 h-10 rounded-full bg-surface-variant/50 flex items-center justify-center text-xl group-hover/item:scale-110 group-hover/item:bg-primary/20 transition-all">
                                            {{ $genre->icon }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-display font-black uppercase tracking-tight text-on-surface group-hover/item:text-primary">{{ $genre->localized_name }}</span>
                                            <span class="text-[9px] text-on-surface-variant/60 font-bold uppercase tracking-[0.1em]">{{ $genre->games_count }} {{ __('Games Available') }}</span>
                                        </div>
                                    </a>
                                @endforeach
                                
                                <div class="h-px bg-outline-variant/10 my-2 mx-5"></div>
                                
                                <a href="{{ route('games.index', ['locale' => app()->getLocale()]) }}" class="flex items-center justify-center py-3 text-[10px] font-display font-black text-primary hover:bg-primary/5 transition-colors uppercase tracking-[0.2em]">
                                    {{ __('Browse All Genres') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                <!-- Stats (Compact) -->
                <div class="hidden sm:block">
                    <x-game-stats compact="true" />
                </div>

                <!-- Search (Desktop) -->
                <form action="{{ route('games.index', ['locale' => app()->getLocale()]) }}" method="GET" class="relative hidden lg:block group" id="nav-search-form">
                    <span
                        class="material-symbols-outlined absolute start-3 top-1/2 -translate-y-1/2 text-on-surface-variant group-focus-within:text-primary transition-colors">search</span>
                    <input type="text" name="search" id="nav-search-input" value="{{ request('search') }}" placeholder="{{ __('Search Gamesiano...') }}"
                        class="bg-surface-variant/50 border-b border-outline-variant/30 text-sm py-2 ps-10 pe-4 rounded-t-lg focus:outline-none focus:border-primary focus:bg-surface-variant transition-all w-48 xl:w-64 uppercase font-display font-semibold tracking-wider"
                        autocomplete="off">
                    <div id="nav-search-results" class="absolute top-full left-0 right-0 bg-surface border border-outline-variant/30 rounded-b-xl shadow-2xl overflow-hidden hidden z-[60]"></div>
                </form>

                <!-- Theme Toggle -->
                <button type="button" id="theme-toggle"
                    class="p-2.5 rounded-full hover:bg-surface-variant/50 text-on-surface-variant hover:text-primary transition-all active:scale-90"
                    aria-label="Toggle theme">
                    <span
                        class="material-symbols-outlined transition-transform duration-500 [font-variation-settings:'FILL'0]"
                        id="theme-icon">dark_mode</span>
                </button>

                <!-- Language Toggle -->
                <button type="button" id="dir-toggle"
                    class="px-4 py-2 rounded-full border border-outline-variant/30 hover:border-primary text-on-surface-variant hover:text-primary font-display font-bold text-xs uppercase tracking-widest transition-all active:scale-95">
                    <span id="dir-toggle-label">{{ app()->getLocale() === 'en' ? 'AR' : 'EN' }}</span>
                </button>

                <!-- Mobile Menu Toggle -->
                <button class="md:hidden p-2.5 rounded-full hover:bg-surface-variant/50 text-on-surface-variant">
                    <span class="material-symbols-outlined">menu</span>
                </button>

                <!-- Auth Buttons -->
                <div class="ms-2 ps-4 border-s border-outline-variant/20 flex items-center gap-3">
                    @auth
                        <div class="relative group">
                            <button class="flex items-center gap-3 p-1.5 rounded-2xl hover:bg-surface-variant/50 transition-all">
                                <div class="w-8 h-8 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-display font-black text-xs uppercase shadow-inner border border-primary/20">
                                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="hidden xl:block text-[10px] font-display font-black uppercase tracking-widest text-on-surface">{{ explode(' ', auth()->user()->name)[0] }}</span>
                            </button>
                            
                            <!-- User Dropdown -->
                            <div class="absolute top-full end-0 pt-4 opacity-0 translate-y-2 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-300 z-[100]">
                                <div class="w-56 bg-surface dark:bg-zinc-900 border border-outline-variant/30 rounded-3xl shadow-2xl overflow-hidden py-2 backdrop-blur-xl">
                                    <div class="px-5 py-3 border-b border-outline-variant/10">
                                        <p class="text-[10px] font-display font-black uppercase tracking-widest text-on-surface">{{ auth()->user()->name }}</p>
                                        <p class="text-[9px] text-on-surface-variant/60 truncate">{{ auth()->user()->email }}</p>
                                    </div>
                                    <a href="{{ route('profile.edit', ['locale' => app()->getLocale()]) }}" class="flex items-center gap-3 px-5 py-3 hover:bg-primary/5 text-[10px] font-display font-black uppercase tracking-widest text-on-surface-variant hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-lg">person_outline</span>
                                        {{ __('Profile') }}
                                    </a>
                                    <div class="h-px bg-outline-variant/10 my-1"></div>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 hover:bg-error/5 text-[10px] font-display font-black uppercase tracking-widest text-error transition-colors">
                                            <span class="material-symbols-outlined text-lg">logout</span>
                                            {{ __('Logout') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl text-[10px] font-display font-black uppercase tracking-widest text-on-surface hover:text-primary transition-all">
                                {{ __('Login') }}
                            </a>
                            <a href="{{ route('register') }}" class="hidden sm:flex px-6 py-2.5 rounded-xl bg-primary text-on-primary text-[10px] font-display font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:brightness-110 active:scale-95 transition-all">
                                {{ __('Sign Up') }}
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-20"></div>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer
        class="bg-surface border-t border-outline-variant/10 py-12 px-4 sm:px-8 mt-12 transition-colors duration-300">
        <div class="max-w-[1440px] mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex flex-col items-center md:items-start gap-3">
                <div class="overflow-hidden rounded-lg">
                    <img src="{{ asset('images/logo_dark.png') }}" alt="Gamesiano Logo"
                        class="h-8 w-auto hidden dark:block mix-blend-screen opacity-80 hover:opacity-100 transition-opacity">
                    <img src="{{ asset('images/logo_light.png') }}" alt="Gamesiano Logo"
                        class="h-8 w-auto block dark:hidden mix-blend-multiply opacity-80 hover:opacity-100 transition-opacity">
                </div>
                <p class="text-on-surface-variant text-xs font-display tracking-widest uppercase opacity-60">©
                    {{ date('Y') }} {{ __('Gamesiano Gaming Hub') }}
                </p>
            </div>

            <nav class="flex flex-wrap justify-center gap-6 lg:gap-12">
                <a href="{{ route('about', ['locale' => app()->getLocale()]) }}"
                    class="text-on-surface-variant hover:text-primary text-xs font-display font-bold uppercase tracking-widest transition-colors">{{ __('About') }}</a>
                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}"
                    class="text-on-surface-variant hover:text-primary text-xs font-display font-bold uppercase tracking-widest transition-colors">{{ __('Contact') }}</a>
                <a href="{{ route('privacy', ['locale' => app()->getLocale()]) }}"
                    class="text-on-surface-variant hover:text-primary text-xs font-display font-bold uppercase tracking-widest transition-colors">{{ __('Privacy') }}</a>
                <a href="{{ route('terms', ['locale' => app()->getLocale()]) }}"
                    class="text-on-surface-variant hover:text-primary text-xs font-display font-bold uppercase tracking-widest transition-colors">{{ __('Terms') }}</a>
                <a href="{{ route('disclaimer', ['locale' => app()->getLocale()]) }}"
                    class="text-on-surface-variant hover:text-primary text-xs font-display font-bold uppercase tracking-widest transition-colors">{{ __('Disclaimer') }}</a>
            </nav>

            <div class="flex gap-4">
                <a href="#"
                    class="w-10 h-10 rounded-full border border-outline-variant/30 flex items-center justify-center text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-lg">public</span>
                </a>
                <a href="#"
                    class="w-10 h-10 rounded-full border border-outline-variant/30 flex items-center justify-center text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-lg">chat</span>
                </a>
            </div>
        </div>
    </footer>

    <!-- Ad-Gate Modal (Hints & Reveal) -->
    <div id="ad-modal"
        class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-zinc-950/80 backdrop-blur-md">
        <div
            class="bg-surface dark:bg-zinc-900 border border-outline-variant/30 max-w-sm w-full rounded-[2.5rem] p-8 text-center shadow-2xl animate-in zoom-in-95 duration-200">
            <div class="mb-6 flex justify-center">
                <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center text-primary" id="modal-icon-container">
                    <span class="material-symbols-outlined text-4xl" id="modal-icon"
                        style="font-variation-settings: 'FILL' 1">lightbulb</span>
                </div>
            </div>
            <h3 class="text-2xl font-display font-black uppercase tracking-tight mb-3 text-on-surface" id="modal-title">{{ __('Need a Hint?') }}</h3>
            <p class="text-on-surface-variant text-sm mb-8 leading-relaxed font-medium" id="modal-description">
                {{ __('Watch a short video ad to unlock the next clue for this challenge.') }}
            </p>
            <div class="flex flex-col gap-3">
                <button id="modal-watch-ad"
                    class="bg-primary text-on-primary font-display font-black uppercase tracking-widest py-4 rounded-2xl shadow-xl shadow-primary/20 hover:brightness-110 active:scale-95 transition-all">
                    {{ __('Watch Ad') }}
                </button>
                <button id="modal-close"
                    class="text-on-surface-variant font-display font-bold uppercase tracking-widest py-3 hover:text-on-surface transition-all">
                    {{ __('No Thanks') }}
                </button>
            </div>
        </div>
    </div>

    @yield('modals')
    
    <!-- Global State -->
    <script>
        window.userBookmarks = @json($user_bookmarks ?? []);
        window.isLoggedIn = @json(auth()->check());
        window.bookmarkToggleUrl = "{{ route('bookmarks.toggle', ['locale' => app()->getLocale()]) }}";
    </script>

    <!-- Scripts -->
    <script src="{{ asset('js/bookmarks.js') }}"></script>
    <script
        src="{{ asset('js/autocomplete.js') }}?v={{ file_exists(public_path('js/autocomplete.js')) ? filemtime(public_path('js/autocomplete.js')) : time() }}"></script>

    <script>
        (function () {
            const root = document.documentElement;
            const themeToggle = document.getElementById('theme-toggle');
            const dirToggle = document.getElementById('dir-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const localePreferenceUrl = @json(route('preferences.locale', ['locale' => app()->getLocale()]));

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

        // Ad Modal Logic (Hints & Reveal)
        function openAdModal(type, onConfirm) {
            const modal = document.getElementById('ad-modal');
            const watchBtn = document.getElementById('modal-watch-ad');
            const closeBtn = document.getElementById('modal-close');
            const title = document.getElementById('modal-title');
            const desc = document.getElementById('modal-description');
            const icon = document.getElementById('modal-icon');
            const iconContainer = document.getElementById('modal-icon-container');

            if (!modal) return;

            if (type === 'reveal') {
                title.textContent = "{{ __('Reveal Answer?') }}";
                desc.textContent = "{{ __('Watch an ad to reveal the full answer and complete this level.') }}";
                icon.textContent = "visibility";
                iconContainer.classList.remove('text-secondary', 'bg-secondary/10');
                iconContainer.classList.add('text-primary', 'bg-primary/10');
            } else {
                title.textContent = "{{ __('Need a Hint?') }}";
                desc.textContent = "{{ __('Watch a short video ad to unlock the next clue for this challenge.') }}";
                icon.textContent = "lightbulb";
                iconContainer.classList.remove('text-primary', 'bg-primary/10');
                iconContainer.classList.add('text-secondary', 'bg-secondary/10');
            }

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
        window.openAdModal = openAdModal;
        window.openHintModal = (cb) => openAdModal('hint', cb); // Backward compatibility

        // Nav Search Autocomplete
        document.addEventListener('DOMContentLoaded', () => {
            const searchUrl = "{{ route('search.unified', ['locale' => app()->getLocale(), 'type' => 'game']) }}";
            initAutocomplete('nav-search-input', 'nav-search-results', searchUrl);
            
            // Auto-submit form when selection is made from autocomplete
            const resultsList = document.getElementById('nav-search-results');
            if (resultsList) {
                resultsList.addEventListener('mousedown', () => {
                    setTimeout(() => {
                        document.getElementById('nav-search-form')?.submit();
                    }, 50);
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>