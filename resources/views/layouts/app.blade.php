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

        footer {
            padding: 2rem;
            text-align: center;
            font-size: 0.8rem;
            color: var(--text-dim);
            border-top: 1px solid var(--glass-border);
            letter-spacing: 0.5px;
            text-transform: uppercase;
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

    <footer>
        &copy; {{ date('Y') }} Black & White Guessing Game. Neat & Simple.
    </footer>

    @stack('scripts')
</body>

</html>