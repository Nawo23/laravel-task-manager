<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Task Manager') }} @hasSection('title') – @yield('title') @endif</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg:        #0f0f11;
            --bg-card:   #17171a;
            --bg-hover:  #1e1e22;
            --border:    #2a2a2f;
            --border-light: #353540;
            --text:      #e8e8ec;
            --text-muted:#7a7a8a;
            --text-dim:  #4a4a58;
            --accent:    #6b7cff;
            --accent-hover: #8b9cff;
            --accent-dim:#6b7cff22;
            --green:     #34d399;
            --green-dim: #34d39920;
            --amber:     #fbbf24;
            --amber-dim: #fbbf2420;
            --red:       #f87171;
            --red-dim:   #f8717120;
            --radius:    10px;
            --radius-lg: 16px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { font-size: 16px; scroll-behavior: smooth; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            font-family: 'DM Serif Display', serif;
            font-size: 1.35rem;
            color: var(--text);
            text-decoration: none;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand .dot {
            width: 8px; height: 8px;
            background: var(--accent);
            border-radius: 50%;
            display: inline-block;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-user {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-right: 1rem;
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.55rem 1.1rem;
            border-radius: var(--radius);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.18s ease;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
        }
        .btn-primary:hover { background: var(--accent-hover); transform: translateY(-1px); }

        .btn-ghost {
            background: transparent;
            color: var(--text-muted);
            border: 1px solid var(--border);
        }
        .btn-ghost:hover { background: var(--bg-hover); color: var(--text); border-color: var(--border-light); }

        .btn-danger {
            background: transparent;
            color: var(--red);
            border: 1px solid #f8717130;
        }
        .btn-danger:hover { background: var(--red-dim); border-color: var(--red); }

        .btn-sm { padding: 0.35rem 0.8rem; font-size: 0.8rem; }

        /* ── MAIN CONTAINER ── */
        .container {
            max-width: 860px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem;
            flex: 1;
        }

        .container-sm {
            max-width: 480px;
            margin: 0 auto;
            padding: 4rem 1.5rem;
        }

        /* ── CARDS ── */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 2rem;
        }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 2rem;
            gap: 1rem;
        }

        .page-title {
            font-family: 'DM Serif Display', serif;
            font-size: 2rem;
            color: var(--text);
            letter-spacing: -0.03em;
            line-height: 1.2;
        }

        .page-subtitle {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        /* ── FORM ELEMENTS ── */
        .form-group { margin-bottom: 1.4rem; }

        label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 0.45rem;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        textarea,
        select {
            width: 100%;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            padding: 0.7rem 1rem;
            outline: none;
            transition: border-color 0.18s ease, box-shadow 0.18s ease;
        }

        input:focus, textarea:focus, select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-dim);
        }

        textarea { min-height: 110px; resize: vertical; }

        select option { background: var(--bg-card); }

        .form-error {
            color: var(--red);
            font-size: 0.82rem;
            margin-top: 0.4rem;
        }

        /* ── ALERTS ── */
        .alert {
            padding: 0.9rem 1.1rem;
            border-radius: var(--radius);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .alert-success {
            background: var(--green-dim);
            border: 1px solid #34d39940;
            color: var(--green);
        }

        .alert-error {
            background: var(--red-dim);
            border: 1px solid #f8717140;
            color: var(--red);
        }

        /* ── BADGE / STATUS ── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.65rem;
            border-radius: 20px;
            font-size: 0.76rem;
            font-weight: 500;
            letter-spacing: 0.03em;
        }

        .badge-pending {
            background: var(--amber-dim);
            color: var(--amber);
            border: 1px solid #fbbf2440;
        }

        .badge-done {
            background: var(--green-dim);
            color: var(--green);
            border: 1px solid #34d39940;
        }

        /* ── DIVIDER ── */
        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 1.5rem 0;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.4;
        }

        .empty-state h3 {
            font-family: 'DM Serif Display', serif;
            font-size: 1.4rem;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        /* ── AUTH FORM STYLES ── */
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-header h1 {
            font-family: 'DM Serif Display', serif;
            font-size: 2rem;
            letter-spacing: -0.03em;
            margin-bottom: 0.4rem;
        }

        .auth-header p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .auth-footer a {
            color: var(--accent);
            text-decoration: none;
        }

        .auth-footer a:hover { text-decoration: underline; }

        /* ── PAGINATION ── */
        .pagination {
            display: flex;
            gap: 0.4rem;
            justify-content: center;
            margin-top: 2rem;
            list-style: none;
        }

        .pagination .page-item .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 0.5rem;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.15s ease;
        }

        .pagination .page-item.active .page-link {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }

        .pagination .page-item .page-link:hover {
            background: var(--bg-hover);
            border-color: var(--border-light);
            color: var(--text);
        }

        .pagination .page-item.disabled .page-link {
            opacity: 0.4;
            pointer-events: none;
        }

        /* ── FOOTER ── */
        footer {
            border-top: 1px solid var(--border);
            padding: 1.25rem 2rem;
            text-align: center;
            color: var(--text-dim);
            font-size: 0.8rem;
        }

        /* ── UTILITY ── */
        .text-muted { color: var(--text-muted); }
        .mt-1 { margin-top: 0.5rem; }
        .mt-2 { margin-top: 1rem; }
        .mt-3 { margin-top: 1.5rem; }
        .mb-3 { margin-bottom: 1.5rem; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 0.75rem; }
        .justify-between { justify-content: space-between; }
    </style>

    @stack('styles')
</head>
<body>

    <nav class="navbar">
        <a href="{{ route('tasks.index') }}" class="navbar-brand">
            <span class="dot"></span> TaskManager
        </a>

        <div class="navbar-nav">
            @auth
                <span class="nav-user">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm">Sign out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Sign in</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
            @endauth
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        &copy; {{ date('Y') }} Task Manager. Built with Laravel.
    </footer>

    @stack('scripts')
</body>
</html>
