<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $current_locale ?? app()->getLocale()) }}" dir="{{ $current_direction ?? (app()->getLocale() === 'ar' ? 'rtl' : 'ltr') }}" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Games Hub') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap"
        rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        (function() {
            const savedTheme = localStorage.getItem('fm-theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>
    <style>
        :root {
            --font-body: 'Inter', sans-serif;
            --font-display: 'Outfit', sans-serif;
            --radius-sm: 12px;
            --radius-md: 18px;
            --radius-lg: 28px;
            --shadow-soft: 0 16px 40px rgba(15, 23, 42, 0.08);
            --shadow-elevated: 0 24px 60px rgba(15, 23, 42, 0.12);
            --border-strong: rgba(148, 163, 184, 0.28);
            --border-soft: rgba(148, 163, 184, 0.18);
            --accent: #3b82f6;
            --accent-strong: #2563eb;
            --success: #16a34a;
            --warning: #d97706;
            --danger: #dc2626;
            --surface-rgb: 255, 255, 255;
            --surface-muted-rgb: 248, 250, 252;
        }

        :root,
        html[data-theme='light'] {
            --bg: #eef4ff;
            --bg-secondary: #f8fbff;
            --surface: rgba(var(--surface-rgb), 0.86);
            --surface-muted: rgba(var(--surface-muted-rgb), 0.92);
            --surface-strong: #ffffff;
            --text: #0f172a;
            --text-muted: #475569;
            --text-soft: #64748b;
            --header-surface: rgba(255, 255, 255, 0.72);
            --header-border: rgba(148, 163, 184, 0.22);
            --hero-glow-a: rgba(59, 130, 246, 0.22);
            --hero-glow-b: rgba(16, 185, 129, 0.18);
            --card-highlight: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(16, 185, 129, 0.08));
        }

        html[data-theme='dark'] {
            --bg: #07111f;
            --bg-secondary: #0d1728;
            --surface: rgba(15, 23, 42, 0.82);
            --surface-muted: rgba(30, 41, 59, 0.82);
            --surface-strong: #111c31;
            --text: #e5eefc;
            --text-muted: #cbd5e1;
            --text-soft: #94a3b8;
            --header-surface: rgba(7, 17, 31, 0.76);
            --header-border: rgba(148, 163, 184, 0.16);
            --border-strong: rgba(148, 163, 184, 0.18);
            --border-soft: rgba(148, 163, 184, 0.12);
            --shadow-soft: 0 18px 42px rgba(2, 6, 23, 0.42);
            --shadow-elevated: 0 24px 60px rgba(2, 6, 23, 0.5);
            --hero-glow-a: rgba(59, 130, 246, 0.26);
            --hero-glow-b: rgba(14, 165, 233, 0.18);
            --card-highlight: linear-gradient(135deg, rgba(59, 130, 246, 0.14), rgba(15, 23, 42, 0.08));
            --surface-rgb: 15, 23, 42;
            --surface-muted-rgb: 30, 41, 59;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            font-family: var(--font-body);
            color: var(--text);
            background:
                radial-gradient(circle at top left, var(--hero-glow-a), transparent 34%),
                radial-gradient(circle at top right, var(--hero-glow-b), transparent 28%),
                linear-gradient(180deg, var(--bg-secondary), var(--bg));
            line-height: 1.6;
            display: flex;
            flex-direction: column;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image: linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 36px 36px;
            opacity: 0.22;
        }

        a {
            color: inherit;
        }

        img {
            max-width: 100%;
            display: block;
        }

        button,
        input,
        textarea,
        select {
            font: inherit;
        }

        .container {
            width: min(1180px, calc(100% - 2rem));
            margin-inline: auto;
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 1rem 0 0;
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .site-header-inner {
            width: min(1240px, calc(100% - 1.5rem));
            margin-inline: auto;
            background: var(--header-surface);
            border: 1px solid var(--header-border);
            border-radius: 24px;
            box-shadow: var(--shadow-soft);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.95rem 1.15rem;
        }

        .brand-link {
            display: inline-flex;
            align-items: center;
            gap: 0.9rem;
            text-decoration: none;
            min-width: 0;
        }

        .brand-mark {
            width: 3rem;
            height: 3rem;
            border-radius: 18px;
            padding: 0.55rem;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.22), rgba(16, 185, 129, 0.18));
            border: 1px solid var(--border-soft);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.18);
        }

        .brand-copy {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .brand-kicker {
            color: var(--text-soft);
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-weight: 700;
        }

        .brand-title {
            font-family: var(--font-display);
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            white-space: nowrap;
        }

        .site-nav a[aria-current='page'] {
            background: rgba(59, 130, 246, 0.12);
            color: var(--text);
            border: 1px solid rgba(59, 130, 246, 0.18);
        }

        .site-nav {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .site-nav ul {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .site-nav a {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 0.94rem;
            padding: 0.72rem 1rem;
            border-radius: 999px;
            transition: 0.2s ease;
        }

        .site-nav a:hover,
        .site-nav a:focus-visible {
            background: rgba(59, 130, 246, 0.08);
            color: var(--text);
            outline: none;
        }

        .toolbar {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .toolbar-btn {
            border: 1px solid var(--border-strong);
            background: rgba(var(--surface-rgb), 0.52);
            color: var(--text);
            border-radius: 999px;
            min-height: 2.8rem;
            padding: 0.6rem 0.95rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.55rem;
            cursor: pointer;
            transition: 0.2s ease;
            font-weight: 700;
        }

        .toolbar-btn:hover,
        .toolbar-btn:focus-visible {
            transform: translateY(-1px);
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 10px 24px rgba(59, 130, 246, 0.12);
            outline: none;
        }

        .toolbar-btn svg {
            width: 1rem;
            height: 1rem;
            flex: 0 0 auto;
        }

        .toolbar-btn-label {
            white-space: nowrap;
        }

        .stats-shell {
            padding: 1rem 0 0;
        }

        .stats-shell .container {
            display: flex;
            justify-content: center;
        }

        main {
            flex: 1;
            padding: 1.35rem 0 3rem;
            position: relative;
            z-index: 1;
        }

        .main-footer {
            padding: 0 0 1.25rem;
        }

        .footer-inner {
            width: min(1240px, calc(100% - 1.5rem));
            margin-inline: auto;
            background: var(--surface);
            border: 1px solid var(--border-soft);
            box-shadow: var(--shadow-soft);
            border-radius: 28px;
            padding: 1.4rem 1.5rem;
        }

        .footer-grid {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .footer-links {
            display: flex;
            gap: 0.65rem;
            flex-wrap: wrap;
        }

        .footer-links a {
            text-decoration: none;
            color: var(--text-muted);
            border: 1px solid var(--border-soft);
            border-radius: 999px;
            padding: 0.65rem 0.95rem;
            font-size: 0.88rem;
            font-weight: 700;
            background: rgba(var(--surface-rgb), 0.42);
            transition: 0.2s ease;
        }

        .footer-links a:hover {
            color: var(--text);
            border-color: rgba(59, 130, 246, 0.34);
        }

        .copyright {
            color: var(--text-soft);
            font-size: 0.88rem;
        }

        .btn {
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.55rem;
            padding: 0.9rem 1.2rem;
            min-height: 3rem;
            border-radius: 16px;
            font-weight: 800;
            letter-spacing: -0.01em;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn:hover,
        .btn:focus-visible {
            transform: translateY(-1px);
            outline: none;
        }

        .btn-primary {
            color: white;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            box-shadow: 0 16px 28px rgba(37, 99, 235, 0.26);
        }

        .btn-outline {
            color: var(--text);
            background: rgba(var(--surface-rgb), 0.5);
            border: 1px solid var(--border-strong);
        }

        .panel {
            background: var(--surface);
            border: 1px solid var(--border-soft);
            box-shadow: var(--shadow-soft);
            border-radius: var(--radius-lg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.45rem 0.85rem;
            border-radius: 999px;
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent-strong);
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .bookmark-btn {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            border: 1px solid var(--border-strong);
            background: rgba(var(--surface-rgb), 0.72);
            color: var(--text-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.2s ease;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .bookmark-btn:hover {
            transform: translateY(-1px) scale(1.02);
            color: var(--text);
            border-color: rgba(59, 130, 246, 0.32);
        }

        .bookmark-btn svg {
            width: 1.35rem;
            height: 1.35rem;
        }

        .bookmark-btn.active {
            color: #f59e0b;
            border-color: rgba(245, 158, 11, 0.45);
            background: rgba(245, 158, 11, 0.12);
        }

        .autocomplete-wrapper {
            position: relative;
            width: 100%;
        }

        .autocomplete-items {
            position: absolute;
            inset-inline: 0;
            top: calc(100% + 0.55rem);
            background: var(--surface-strong);
            border: 1px solid var(--border-soft);
            border-radius: 18px;
            box-shadow: var(--shadow-soft);
            overflow: hidden;
            z-index: 30;
        }

        .autocomplete-item {
            padding: 0.85rem 1rem;
            color: var(--text);
            cursor: pointer;
            transition: 0.15s ease;
            border-bottom: 1px solid var(--border-soft);
        }

        .autocomplete-item:last-child {
            border-bottom: none;
        }

        .autocomplete-item:hover,
        .autocomplete-active {
            background: rgba(59, 130, 246, 0.1);
        }

        .static-page {
            max-width: 880px;
            margin-inline: auto;
        }

        .page-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-family: var(--font-display);
            font-size: clamp(2rem, 5vw, 3.5rem);
            line-height: 1.05;
            letter-spacing: -0.04em;
            margin-bottom: 0.85rem;
        }

        .subtitle {
            color: var(--text-soft);
            font-size: 1rem;
        }

        .page-content {
            padding: 2rem;
            background: var(--surface);
            border: 1px solid var(--border-soft);
            border-radius: 28px;
            box-shadow: var(--shadow-soft);
        }

        .page-content section + section {
            margin-top: 1.75rem;
            padding-top: 1.75rem;
            border-top: 1px solid var(--border-soft);
        }

        .page-content h2 {
            font-family: var(--font-display);
            font-size: 1.35rem;
            margin-bottom: 0.85rem;
            color: var(--text);
        }

        .page-content p,
        .page-content li {
            color: var(--text-muted);
        }

        .page-content ul {
            padding-inline-start: 1.25rem;
            display: grid;
            gap: 0.55rem;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(2, 6, 23, 0.62);
            backdrop-filter: blur(8px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            padding: 1rem;
        }

        .modal-card {
            width: min(100%, 420px);
            background: var(--surface-strong);
            color: var(--text);
            border: 1px solid var(--border-soft);
            border-radius: 28px;
            padding: 2rem;
            box-shadow: var(--shadow-elevated);
            text-align: center;
        }

        .modal-card h3 {
            font-family: var(--font-display);
            font-size: 1.6rem;
            margin-bottom: 0.8rem;
        }

        .modal-card p {
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        .modal-actions {
            display: grid;
            gap: 0.75rem;
        }

        [dir='rtl'] {
            text-align: right;
        }

        [dir='rtl'] .page-header,
        [dir='rtl'] .footer-grid,
        [dir='rtl'] .stats-shell .container,
        [dir='rtl'] .brand-link,
        [dir='rtl'] .site-header-inner,
        [dir='rtl'] .site-nav,
        [dir='rtl'] .toolbar {
            text-align: initial;
        }

        [dir='rtl'] .site-header-inner,
        [dir='rtl'] .footer-grid {
            flex-direction: row-reverse;
        }

        [dir='rtl'] .site-nav {
            justify-content: flex-start;
        }

        @media (max-width: 920px) {
            .site-header {
                padding-top: 0.75rem;
            }

            .site-header-inner {
                flex-direction: column;
                align-items: stretch;
            }

            .site-nav,
            .toolbar,
            .site-nav ul {
                justify-content: center;
            }
        }

        @media (max-width: 640px) {
            .container {
                width: min(100%, calc(100% - 1rem));
            }

            .brand-copy {
                min-width: 0;
            }

            .brand-title {
                white-space: normal;
            }

            .page-content,
            .modal-card,
            .footer-inner {
                padding: 1.35rem;
            }

            .toolbar-btn-label {
                display: none;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <header class="site-header">
        <div class="site-header-inner">
            <a href="{{ route('home') }}" class="brand-link">
                <img src="{{ asset('images/logo.png') }}" alt="{{ __('Games Hub') }} Logo" class="brand-mark">
                <span class="brand-copy">
                    <span class="brand-kicker">{{ __('Games Hub') }}</span>
                    <span class="brand-title">{{ __('Games Hub') }}</span>
                </span>
            </a>

            <nav class="site-nav" aria-label="Primary navigation">
                <ul>
                    <li><a href="{{ route('home') }}" aria-current="{{ request()->routeIs('home') ? 'page' : 'false' }}">{{ __('Home') }}</a></li>
                    <li><a href="{{ route('games.index') }}" aria-current="{{ request()->routeIs('games.index', 'games.play') ? 'page' : 'false' }}">{{ __('Games') }}</a></li>
                    <li><a href="{{ route('about') }}" aria-current="{{ request()->routeIs('about') ? 'page' : 'false' }}">{{ __('About') }}</a></li>
                </ul>
            </nav>

            <div class="toolbar" aria-label="Appearance controls">
                <button type="button" id="theme-toggle" class="toolbar-btn" aria-label="Toggle theme">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 12.79A9 9 0 1 1 11.21 3c0 .28 0 .57.02.85A7 7 0 0 0 20.15 12c.28.02.57.02.85.02Z" />
                    </svg>
                    <span id="theme-toggle-label" class="toolbar-btn-label">{{ __('Dark') }}</span>
                </button>

                <button type="button" id="dir-toggle" class="toolbar-btn" aria-label="Toggle language and direction">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 7h11m0 0-3-3m3 3-3 3M20 17H9m0 0 3-3m-3 3 3 3" />
                    </svg>
                    <span id="dir-toggle-label" class="toolbar-btn-label">{{ __('Arabic') }}</span>
                </button>
            </div>
        </div>
    </header>

    <div class="stats-shell">
        <div class="container">
            <x-game-stats />
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <footer class="main-footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-links">
                    <a href="{{ route('about') }}">{{ __('About') }}</a>
                    <a href="{{ route('contact') }}">{{ __('Contact') }}</a>
                    <a href="{{ route('privacy') }}">{{ __('Privacy') }}</a>
                    <a href="{{ route('terms') }}">{{ __('Terms') }}</a>
                    <a href="{{ route('disclaimer') }}">{{ __('Disclaimer') }}</a>
                </div>
                <p class="copyright">&copy; {{ date('Y') }} {{ __('Games Hub') }}.</p>
            </div>
        </div>
    </footer>

    <div id="hint-modal" class="modal-overlay">
        <div class="modal-card">
            <div style="margin-bottom: 1rem; display: flex; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" style="width: 3rem; height: 3rem; color: #f59e0b;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 18v-3m0 0a8.1 8.1 0 0 0 4.5-1.55c3.3-2.45 3.3-6.45 0-8.9A8.1 8.1 0 0 0 12 3a8.1 8.1 0 0 0-4.5 1.55c-3.3 2.45-3.3 6.45 0 8.9A8.1 8.1 0 0 0 12 15Zm0 3v2m0 0h-3m3 0h3" />
                </svg>
            </div>
            <h3>{{ __('Need a Hint?') }}</h3>
            <p>{{ __('Watch a short video ad to unlock the next clue for this challenge.') }}</p>
            <div class="modal-actions">
                <button id="modal-watch-ad" class="btn btn-primary">{{ __('Watch Ad for Hint') }}</button>
                <button id="modal-close" class="btn btn-outline">{{ __('No Thanks') }}</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/bookmarks.js') }}"></script>
    <script
        src="{{ asset('js/autocomplete.js') }}?v={{ file_exists(public_path('js/autocomplete.js')) ? filemtime(public_path('js/autocomplete.js')) : time() }}"></script>
    <script>
        (function() {
            const root = document.documentElement;
            const themeToggle = document.getElementById('theme-toggle');
            const dirToggle = document.getElementById('dir-toggle');
            const themeLabel = document.getElementById('theme-toggle-label');
            const dirLabel = document.getElementById('dir-toggle-label');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const localePreferenceUrl = @json(route('preferences.locale'));
            const localeMap = {
                en: {
                    locale: 'en',
                    dir: 'ltr',
                },
                ar: {
                    locale: 'ar',
                    dir: 'rtl',
                },
            };

            function syncControls() {
                const theme = root.getAttribute('data-theme') || 'light';
                const locale = root.lang === 'ar' ? 'ar' : 'en';
                themeLabel.textContent = theme === 'light' ? @json(__('Dark')) : @json(__('Light'));
                dirLabel.textContent = locale === 'en' ? @json(__('Arabic')) : @json(__('English'));
            }

            themeToggle?.addEventListener('click', () => {
                const nextTheme = (root.getAttribute('data-theme') || 'light') === 'light' ? 'dark' : 'light';
                root.setAttribute('data-theme', nextTheme);
                localStorage.setItem('fm-theme', nextTheme);
                syncControls();
            });

            dirToggle?.addEventListener('click', async () => {
                const currentLocale = root.lang === 'ar' ? 'ar' : 'en';
                const nextLocale = currentLocale === 'en' ? 'ar' : 'en';
                const nextState = localeMap[nextLocale];

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
                            locale: nextState.locale,
                            current_url: window.location.pathname + window.location.search,
                        }),
                    });

                    if (!response.ok) {
                        throw new Error('Unable to update locale preference.');
                    }

                    const data = await response.json();

                    root.lang = nextState.locale;
                    root.setAttribute('dir', nextState.dir);
                    window.location.assign(data.redirect_url || '/'+ nextState.locale);
                } catch (error) {
                    dirToggle.disabled = false;
                }
            });

            syncControls();
        })();

        function openHintModal(onConfirm) {
            const modal = document.getElementById('hint-modal');
            const watchBtn = document.getElementById('modal-watch-ad');
            const closeBtn = document.getElementById('modal-close');
            if (!modal || !watchBtn || !closeBtn) return;

            modal.style.display = 'flex';

            const outsideClick = (event) => {
                if (event.target === modal) {
                    cleanup();
                }
            };

            const cleanup = () => {
                modal.style.display = 'none';
                watchBtn.removeEventListener('click', confirmHandler);
                closeBtn.removeEventListener('click', cleanup);
                modal.removeEventListener('click', outsideClick);
            };

            const confirmHandler = () => {
                cleanup();
                onConfirm();
            };

            watchBtn.addEventListener('click', confirmHandler);
            closeBtn.addEventListener('click', cleanup);
            modal.addEventListener('click', outsideClick);
        }
    </script>
    @stack('scripts')
</body>

</html>
