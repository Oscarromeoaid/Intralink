<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IntraLink') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')

    <style>
        /* ===== VARIABLES ===== */
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;

            /* Thème clair */
            --bg-body: #f5f7fa;
            --bg-surface: #ffffff;
            --bg-elevated: #f8fafc;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --border: #e2e8f0;
            --shadow: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.03);
            --shadow-lg: 0 10px 40px -12px rgba(0,0,0,0.1);
        }

        [data-theme="dark"] {
            /* Thème sombre élégant */
            --bg-body: #0a0a0f;
            --bg-surface: #14141f;
            --bg-elevated: #1a1a2a;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #6b7280;
            --border: #2a2a3a;
            --shadow: 0 1px 3px rgba(0,0,0,0.3);
            --shadow-lg: 0 10px 40px -12px rgba(0,0,0,0.5);
        }

        /* Styles généraux */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-body);
            color: var(--text-primary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            transition: background 0.2s ease, color 0.2s ease;
            line-height: 1.6;
        }

        /* Cartes */
        .card, .il-composer, .il-post-card, .il-sidebar-card, .il-comment, .dropdown-menu, .modal-content {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: var(--shadow);
            transition: background 0.2s ease, border 0.2s ease;
        }

        /* Navbar */
        .navbar {
            background: var(--bg-surface) !important;
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(10px);
        }

        /* Formulaires */
        .form-control, .form-select, .input-group-text {
            background: var(--bg-elevated);
            color: var(--text-primary);
            border: 1px solid var(--border);
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            background: var(--bg-surface);
            color: var(--text-primary);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        /* Boutons */
        .btn-primary-custom, .il-btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            color: white;
            border-radius: 12px;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary-custom:hover, .il-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
        }

        .il-btn-secondary {
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            color: var(--text-secondary);
            border-radius: 12px;
            padding: 10px 24px;
            transition: all 0.2s ease;
        }

        .il-btn-secondary:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        /* Dropdown */
        .dropdown-menu {
            backdrop-filter: blur(10px);
        }

        .dropdown-item {
            color: var(--text-secondary);
            border-radius: 10px;
            margin: 4px 8px;
            padding: 8px 12px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: var(--bg-elevated);
            color: var(--primary);
        }

        /* Alertes */
        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid var(--success);
            color: var(--success);
            border-radius: 16px;
        }
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--danger);
            color: var(--danger);
            border-radius: 16px;
        }
        .alert-info {
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid var(--primary);
            color: var(--primary);
            border-radius: 16px;
        }

        /* Composants IntraLink */
        .il-stat-pill {
            background: var(--bg-elevated);
            color: var(--text-secondary);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 0.875rem;
        }

        .il-comment-body {
            background: var(--bg-elevated);
            border-radius: 16px;
            padding: 12px 16px;
        }

        .like-btn.liked {
            color: #fb7185;
        }

        .like-btn.liked i {
            animation: heartBeat 0.3s ease;
        }

        @keyframes heartBeat {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.3); }
        }

        /* Bordures */
        .border-bottom, .border-top, .border-start, .border-end, hr {
            border-color: var(--border) !important;
        }

        .bg-light {
            background: var(--bg-elevated) !important;
        }

        .il-avatar-placeholder {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        /* Badge notifications */
        .notif-badge {
            background: var(--danger);
            color: white;
            border-radius: 20px;
            padding: 2px 8px;
            font-size: 10px;
            font-weight: 600;
        }

        /* Bouton thème */
        #themeToggle {
            transition: all 0.3s ease;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            color: var(--text-primary);
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #themeToggle:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            transform: rotate(15deg);
        }

        /* Posts */
        .il-post-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .il-post-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Media */
        .il-post-media {
            margin: 1rem 0;
            border-radius: 16px;
            overflow: hidden;
            background: var(--bg-elevated);
            text-align: center;
        }

        .il-post-media img, .il-post-media video {
            width: 100%;
            max-width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: contain;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .il-post-media img, .il-post-media video {
                max-height: 250px;
            }
        }

        /* Modal image */
        .image-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.95);
            z-index: 10000;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .image-modal.show {
            display: flex;
        }

        .image-modal img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            border-radius: 16px;
        }

        .image-modal .close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 40px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .image-modal .close:hover {
            transform: scale(1.1);
        }

        /* Barre de recherche */
        .search-input-group {
            background: var(--bg-elevated);
            border-radius: 40px;
            transition: all 0.2s ease;
        }

        .search-input-group:focus-within {
            background: var(--bg-surface);
            box-shadow: 0 0 0 2px var(--primary);
        }

        .search-input {
            border: none;
            background: transparent;
            padding: 10px 18px;
            font-size: 0.9rem;
            width: 220px;
            color: var(--text-primary);
        }

        .search-input:focus {
            outline: none;
        }

        .search-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            padding: 10px 18px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .search-btn:hover {
            color: var(--primary);
        }

        @media (max-width: 991px) {
            .search-input {
                width: 100%;
            }
        }

        /* Navigation */
        .il-nav-chip {
            color: var(--text-secondary);
            transition: all 0.2s ease;
        }

        .il-nav-chip:hover {
            color: var(--primary);
            background: var(--bg-elevated);
        }

        /* Scrollbar personnalisée */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-elevated);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        /* Dropdown correction */
        .navbar {
            position: relative;
            z-index: 1050;
        }

        .dropdown-menu {
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            left: auto !important;
            z-index: 9999 !important;
            min-width: 220px;
            margin-top: 0.5rem !important;
        }

        main {
            position: relative;
            z-index: 1;
        }

        @media (max-width: 991px) {
            .dropdown-menu {
                position: static !important;
                float: none;
                margin-top: 0.5rem !important;
            }
        }
        /* ===== DESIGN AMÉLIORÉ DES COMMENTAIRES ET RÉPONSES ===== */

/* Structure principale des commentaires */
.il-comment-list {
    margin-top: 1rem;
}

.il-comment {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 1rem;
    padding: 0.75rem;
    border-radius: 16px;
    transition: background 0.2s ease;
}

.il-comment:hover {
    background: var(--bg-elevated);
}

/* Avatar dans les commentaires */
.il-comment .il-avatar-sm {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    flex-shrink: 0;
    object-fit: cover;
}

/* Corps du commentaire */
.il-comment-body {
    flex: 1;
    background: var(--bg-elevated);
    border-radius: 16px;
    padding: 0.75rem 1rem;
    transition: background 0.2s ease;
}

/* En-tête du commentaire */
.il-comment-body strong {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
}

.il-meta {
    font-size: 0.7rem;
    color: var(--text-muted);
}

/* Contenu du commentaire */
.il-comment-body > div:first-child {
    margin-bottom: 0.5rem;
}

/* Actions du commentaire */
.il-comment-actions {
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.il-comment-link {
    font-size: 0.7rem;
    color: var(--text-muted);
    text-decoration: none;
    transition: color 0.2s ease;
}

.il-comment-link:hover {
    color: var(--primary);
    text-decoration: none;
}

/* Formulaire de réponse */
.reply-form {
    margin-top: 0.75rem;
    margin-left: 48px;
    animation: slideDown 0.2s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.reply-form .il-inline-form {
    background: var(--bg-surface);
    border-radius: 16px;
    padding: 0.5rem;
    border: 1px solid var(--border);
}

.reply-form .form-control-sm {
    font-size: 0.8rem;
    padding: 0.5rem 0.75rem;
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    border-radius: 10px;
    color: var(--text-primary);
}

.reply-form .form-control-sm:focus {
    border-color: var(--primary);
    outline: none;
}

/* Liste des réponses (thread) */
.il-replies {
    margin-top: 0.75rem;
    margin-left: 48px;
    border-left: 2px solid var(--border);
    padding-left: 1rem;
}

.il-replies .il-comment {
    margin-bottom: 0.75rem;
    padding: 0;
}
.il-replies .il-comment-body {
    background: transparent;
    padding: 0.5rem 0;
}

/* Corps du commentaire - SANS CADRE */
.il-comment-body {
    flex: 1;
    background: transparent;
    padding: 0.25rem 0;
    transition: background 0.2s ease;
}

.il-replies .il-avatar-sm {
    width: 28px;
    height: 28px;
}

/* Badge nombre de réponses */
.il-comment-actions .il-meta {
    font-size: 0.7rem;
    background: var(--bg-tertiary);
    padding: 0.125rem 0.5rem;
    border-radius: 20px;
}

/* Formulaire de commentaire principal */
.il-comment-form {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border);
}

.il-comment-form .il-avatar-sm {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    flex-shrink: 0;
}

.il-comment-form .form-control {
    flex: 1;
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 0.6rem 1rem;
    font-size: 0.875rem;
}

.il-comment-form .form-control:focus {
    border-color: var(--primary);
    outline: none;
}

.il-comment-form button {
    background: var(--primary);
    border: none;
    color: white;
    border-radius: 20px;
    padding: 0.5rem 1.25rem;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.il-comment-form button:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
}

/* Bouton J'aime dans les commentaires (optionnel) */
.il-comment-link.text-danger {
    color: var(--danger) !important;
}

.il-comment-link.text-danger:hover {
    opacity: 0.8;
}


    </style>
</head>
<body class="@yield('body_class')">
    <div id="app" class="il-shell">
        @hasSection('hide_nav')
        @else
            <nav class="navbar navbar-expand-lg il-navbar py-2">
                <div class="container">
                    <a class="il-brand d-flex align-items-center text-decoration-none" href="{{ route('home') }}">
                        <img src="{{ asset('images/intralink-logo.png') }}" alt="IntraLink" style="height: 40px;">
                        <div class="ms-2">
                            <span class="fw-bold fs-5" style="color: var(--primary);">IntraLink</span>
                            <span class="d-block small text-muted">Réseau Interne</span>
                        </div>
                    </a>

                    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        @auth
                            <div class="navbar-nav mx-auto gap-2 mt-3 mt-lg-0">
                                <a class="nav-link rounded-pill px-3 py-2" href="{{ route('home') }}" style="color: var(--text-secondary);">
                                    <i class="fa-solid fa-house-chimney me-1"></i> Fil
                                </a>

                                @can('admin')
                                    <a class="nav-link rounded-pill px-3 py-2" href="{{ route('admin.dashboard') }}" style="color: var(--text-secondary);">
                                        <i class="fa-solid fa-shield-haltered me-1"></i> Administration
                                    </a>
                                @endcan

                                @can('moderator')
                                    @cannot('admin')
                                        <a class="nav-link rounded-pill px-3 py-2" href="{{ route('moderator.dashboard') }}" style="color: var(--text-secondary);">
                                            <i class="fa-solid fa-gavel me-1"></i> Modération
                                        </a>
                                    @endcannot
                                @endcan

                                <a class="nav-link rounded-pill px-3 py-2" href="{{ route('profile.show') }}" style="color: var(--text-secondary);">
                                    <i class="fa-regular fa-user me-1"></i> Profil
                                </a>

                                <!-- Barre de recherche -->
                                <form action="{{ route('posts.search') }}" method="GET" class="ms-lg-2">
                                    <div class="search-input-group d-flex align-items-center">
                                        <input type="text" name="q" class="search-input" placeholder="Rechercher..." value="{{ request('q') }}">
                                        <button type="submit" class="search-btn">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endauth

                        <ul class="navbar-nav ms-auto mt-3 mt-lg-0 align-items-center gap-2">
                            @guest
                                <li class="nav-item">
                                    <a class="btn btn-outline-primary rounded-pill px-4" href="{{ route('login') }}">Connexion</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-primary rounded-pill px-4" href="{{ route('register') }}">Inscription</a>
                                </li>
                            @else
                                <!-- Icône notifications -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link position-relative p-2" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="fa-regular fa-bell fa-lg"></i>
                                        <span id="notifBadge" class="notif-badge position-absolute top-0 start-100 translate-middle" style="display: none;">0</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end p-0" style="width: 340px; max-height: 420px; overflow-y: auto;">
                                        <div class="p-3 border-bottom">
                                            <h6 class="mb-0 fw-bold">Notifications</h6>
                                        </div>
                                        <div id="notificationsList" class="notifications-list">
                                            <div class="text-center py-4">
                                                <div class="spinner-border spinner-border-sm text-muted"></div>
                                            </div>
                                        </div>
                                        <div class="p-2 border-top text-center">
                                            <button id="markAllReadBtn" class="btn btn-sm btn-link text-decoration-none">Tout marquer lu</button>
                                        </div>
                                    </div>
                                </li>

                                <!-- Bouton thème -->
                                <li class="nav-item">
                                    <button id="themeToggle" class="btn">
                                        <i id="themeIcon" class="fas fa-moon"></i>
                                    </button>
                                </li>

                                <!-- Dropdown profil -->
                                <li class="nav-item dropdown">
                                    @php
                                        $navInitials = collect(preg_split('/\s+/', trim(Auth::user()->name)))
                                            ->filter()
                                            ->take(2)
                                            ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                                            ->implode('');
                                    @endphp
                                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                                        @if(Auth::user()->avatar_path)
                                            <img src="{{ asset('storage/'.Auth::user()->avatar_path) }}" alt="{{ Auth::user()->name }}" class="rounded-circle" width="36" height="36" style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); font-weight: 600;">
                                                {{ $navInitials }}
                                            </div>
                                        @endif
                                        <span class="fw-semibold d-none d-md-block">{{ Auth::user()->name }}</span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('profile.show') }}">
                                            <i class="fa-regular fa-user me-2"></i> Mon profil
                                        </a>
                                        <a class="dropdown-item" href="{{ route('home') }}">
                                            <i class="fa-solid fa-house-chimney me-2"></i> Fil d'actualité
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        @can('admin')
                                            <a class="dropdown-item text-danger" href="{{ route('admin.dashboard') }}">
                                                <i class="fa-solid fa-shield-haltered me-2"></i> Administration
                                            </a>
                                        @endcan
                                        @can('moderator')
                                            @cannot('admin')
                                                <a class="dropdown-item text-warning" href="{{ route('moderator.dashboard') }}">
                                                    <i class="fa-solid fa-gavel me-2"></i> Modération
                                                </a>
                                            @endcannot
                                        @endcan
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa-solid fa-sign-out-alt me-2"></i> Déconnexion
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        @endif

        <main class="@yield('main_class', 'il-main py-4')">
            @yield('content')
        </main>
    </div>

    <!-- Modal pour agrandir les photos -->
    <div id="imageModal" class="image-modal" onclick="closeModal()">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="modalImage" src="">
    </div>

    @stack('scripts')
    @yield('scripts')

    <script>
        // ===== GESTION DU THÈME =====
        function initTheme() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            updateThemeIcon(savedTheme);
        }

        function updateThemeIcon(theme) {
            const icon = document.getElementById('themeIcon');
            if (icon) {
                if (theme === 'dark') {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                } else {
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                }
            }
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        }

        initTheme();
        document.getElementById('themeToggle')?.addEventListener('click', toggleTheme);

        // Fonction pour ouvrir l'image en grand
        function openImage(src) {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImage');
            modal.classList.add('show');
            img.src = src;
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.remove('show');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.il-post-media img').forEach(img => {
                img.addEventListener('click', function(e) {
                    e.stopPropagation();
                    openImage(this.src);
                });
            });
        });

        // Gestion des notifications
        async function loadNotifications() {
            try {
                const response = await fetch('{{ route("notifications.latest") }}');
                const data = await response.json();

                const badge = document.getElementById('notifBadge');
                if (data.unread_count > 0) {
                    badge.textContent = data.unread_count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }

                const list = document.getElementById('notificationsList');
                if (data.notifications.length === 0) {
                    list.innerHTML = '<div class="text-center py-4 text-muted">Aucune notification</div>';
                } else {
                    list.innerHTML = data.notifications.map(n => `
                        <div class="notification-item p-3 border-bottom ${!n.read ? 'bg-light' : ''}" data-id="${n.id}">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: var(--primary);">
                                        <i class="fas ${n.type === 'like' ? 'fa-heart' : (n.type === 'comment' ? 'fa-comment' : 'fa-reply')} text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 small">${n.message}</p>
                                    <small class="text-muted">${new Date(n.created_at).toLocaleTimeString()}</small>
                                </div>
                                ${!n.read ? `
                                <div>
                                    <button class="btn btn-sm btn-link text-primary mark-read" data-id="${n.id}">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                </div>
                                ` : ''}
                            </div>
                        </div>
                    `).join('');
                }

                document.querySelectorAll('.mark-read').forEach(btn => {
                    btn.addEventListener('click', async (e) => {
                        e.stopPropagation();
                        const id = btn.dataset.id;
                        await fetch(`/notifications/${id}/read`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                        loadNotifications();
                    });
                });

            } catch (error) {
                console.error('Erreur chargement notifications:', error);
            }
        }

        document.getElementById('markAllReadBtn')?.addEventListener('click', async () => {
            await fetch('{{ route("notifications.read-all") }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
            loadNotifications();
        });

        loadNotifications();
        setInterval(loadNotifications, 10000);
    </script>
</body>
</html>
