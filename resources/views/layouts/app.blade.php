<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOOTBALL MYSTERY</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Outfit:wght@700;800&display=swap"
        rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --pitch-dark: #1a2e1c;
            --pitch-green: #2ea043;
            --stadium-green: #3fb950;
            --stadium-glow: rgba(63, 185, 80, 0.1);
            --bg-main: #fcfdfc;
            --text-main: #1a1f1b;
            --text-dim: #57605a;
            --glass: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(46, 160, 67, 0.15);
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-main);
            background-image:
                radial-gradient(circle at 50% -20%, #eefbf0, transparent);
            color: var(--text-main);
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: var(--glass);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
            padding: 0.75rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
        }

        .logo-area img {
            height: 40px;
            width: 40px;
            object-fit: contain;
        }

        .logo-area h1 {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 1.25rem;
            color: var(--pitch-dark);
            margin: 0;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        nav a {
            text-decoration: none;
            color: var(--text-dim);
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: var(--transition);
        }

        nav a:hover {
            color: var(--stadium-green);
        }

        main {
            flex: 1;
            width: 100%;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
            padding: 2rem;
        }

        .main-footer {
            padding: 3rem 2rem;
            background: white;
            border-top: 1px solid var(--glass-border);
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: var(--text-dim);
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--stadium-green);
        }

        .copyright {
            font-size: 0.8rem;
            color: var(--text-dim);
            opacity: 0.7;
            letter-spacing: 0.5px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-family: 'Outfit', sans-serif;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--stadium-green), #2ea043);
            color: white;
            box-shadow: 0 4px 12px var(--stadium-glow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px var(--stadium-glow);
            opacity: 0.95;
        }

        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--stadium-green);
            color: var(--stadium-green);
        }

        .btn-outline:hover {
            background-color: var(--stadium-green);
            color: white;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .logo-area h1 {
                display: none;
            }

            nav ul {
                gap: 1rem;
            }
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
            text-align: left;
        }

        .autocomplete-item:hover {
            background-color: #f1f5f9;
            color: var(--stadium-green);
        }

        .autocomplete-active {
            background-color: var(--stadium-green) !important;
            color: white !important;
        }

        /* Hint Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            animation: fadeIn 0.2s ease-out;
        }

        .modal-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            transform: scale(0.9);
            animation: modalPop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes modalPop {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-card h3 {
            font-family: 'Outfit', sans-serif;
            margin-bottom: 1rem;
            color: var(--pitch-dark);
        }

        .modal-card p {
            color: var(--text-dim);
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        .modal-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .hint-icon {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .hint-icon svg {
            width: 1.25rem;
            height: 1.25rem;
            color: #fbbf24;
            /* Amber bulb */
        }
    </style>
    @stack('styles')
</head>

<body>
    <header>
        <div class="header-content">
            <a href="{{ route('home') }}" class="logo-area">
                <img src="{{ asset('images/logo.png') }}" alt="Football Mystery Logo">
                <h1>FOOTBALL MYSTERY</h1>
            </a>
            <nav>
                <ul>
                    <li><a href="{{ route('games.index') }}">Games</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-links">
                <a href="{{ route('about') }}">About Us</a>
                <a href="{{ route('contact') }}">Contact Us</a>
                <a href="{{ route('privacy') }}">Privacy Policy</a>
                <a href="{{ route('terms') }}">Terms of Service</a>
                <a href="{{ route('disclaimer') }}">Disclaimer</a>
            </div>
            <p class="copyright">
                &copy; {{ date('Y') }} Football Mystery. All rights reserved. Built for the love of the game.
            </p>
        </div>
    </footer>

    <div id="hint-modal" class="modal-overlay">
        <div class="modal-card">
            <div style="margin-bottom: 1rem;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" style="width: 3rem; height: 3rem; color: #fbbf24; margin: 0 auto;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 18v-3m0 0a8.1 8.1 0 0 0 4.5-1.55c3.3-2.45 3.3-6.45 0-8.9A8.1 8.1 0 0 0 12 3a8.1 8.1 0 0 0-4.5 1.55c-3.3 2.45-3.3 6.45 0 8.9A8.1 8.1 0 0 0 12 15Zm0 3v2m0 0h-3m3 0h3" />
                </svg>
            </div>
            <h3>Need a Hint?</h3>
            <p>Watch a short video ad to receive a hint for the current puzzle. You can choose to skip this if you
                prefer.</p>
            <div class="modal-actions">
                <button id="modal-watch-ad" class="btn btn-primary">Watch Ad for Hint</button>
                <button id="modal-close" class="btn btn-outline" style="border-color: #94a3b8; color: #64748b;">No
                    Thanks</button>
            </div>
        </div>
    </div>

    <script
        src="{{ asset('js/autocomplete.js') }}?v={{ file_exists(public_path('js/autocomplete.js')) ? filemtime(public_path('js/autocomplete.js')) : time() }}"></script>
    <script>
        function openHintModal(onConfirm) {
            const modal = document.getElementById('hint-modal');
            const watchBtn = document.getElementById('modal-watch-ad');
            const closeBtn = document.getElementById('modal-close');

            modal.style.display = 'flex';

            const cleanup = () => {
                modal.style.display = 'none';
                watchBtn.removeEventListener('click', confirmHandler);
                closeBtn.removeEventListener('click', cleanup);
            };

            const confirmHandler = () => {
                cleanup();
                onConfirm();
            };

            const outsideClick = (e) => {
                if (e.target === modal) cleanup();
            };

            watchBtn.addEventListener('click', confirmHandler);
            closeBtn.addEventListener('click', cleanup);
            modal.addEventListener('click', outsideClick);
        }
    </script>
    @stack('scripts')
</body>

</html>