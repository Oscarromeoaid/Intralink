<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IntraLink') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
    
    <style>
        /* Correction pour que le dropdown passe au-dessus de tout */
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
            min-width: 200px;
            margin-top: 0.5rem !important;
        }
        
        .nav-item.dropdown {
            position: relative !important;
        }
        
        /* Assure que le main n'écrase pas le dropdown */
        main {
            position: relative;
            z-index: 1;
        }
        
        /* Correction pour mobile */
        @media (max-width: 991px) {
            .dropdown-menu {
                position: static !important;
                float: none;
                margin-top: 0.5rem !important;
            }
        }
    </style>
</head>
<body class="@yield('body_class')">
    <div id="app" class="il-shell">
        @hasSection('hide_nav')
        @else
            <nav class="navbar navbar-expand-lg il-navbar">
                <div class="container">
                    <a class="il-brand" href="{{ route('home') }}">
                        <img src="{{ asset('images/intralink-logo.png') }}" alt="IntraLink">
                        <span class="il-brand-copy">
                            <span class="il-brand-title">IntraLink</span>
                            <span class="il-brand-subtitle">Reseau Interne</span>
                        </span>
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        @auth
                            <div class="navbar-nav mx-auto gap-lg-2 mt-3 mt-lg-0">
                                {{-- Tout le monde voit le Fil --}}
                                <a class="il-nav-chip" href="{{ route('home') }}">
                                    <i class="fa-solid fa-house-chimney"></i>
                                    Fil
                                </a>
                                
                                {{-- ADMIN uniquement --}}
                                @can('admin')
                                    <a class="il-nav-chip" href="{{ route('admin.dashboard') }}">
                                        <i class="fa-solid fa-shield-haltered"></i>
                                        Administration
                                    </a>
                                @endcan
                                
                                {{-- MODERATEUR uniquement --}}
                                @can('moderator')
                                    @cannot('admin')
                                        <a class="il-nav-chip" href="{{ route('moderator.dashboard') }}">
                                            <i class="fa-solid fa-gavel"></i>
                                            Modération
                                        </a>
                                    @endcannot
                                @endcan
                                
                                {{-- Tout le monde voit Profil --}}
                                <a class="il-nav-chip" href="{{ route('profile.show') }}">
                                    <i class="fa-regular fa-user"></i>
                                    Profil
                                </a>
                            </div>
                        @endauth

                        <ul class="navbar-nav ms-auto mt-3 mt-lg-0 align-items-lg-center gap-lg-2">
                            @guest
                                <li class="nav-item">
                                    <a class="il-nav-chip" href="{{ route('login') }}">Connexion</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn il-btn-primary px-4" href="{{ route('register') }}">Inscription</a>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    @php
                                        $navInitials = collect(preg_split('/\s+/', trim(Auth::user()->name)))
                                            ->filter()
                                            ->take(2)
                                            ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                                            ->implode('');
                                    @endphp
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center gap-2 border-0" href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                        @if(Auth::user()->avatar_path)
                                            <img
                                                src="{{ asset('storage/'.Auth::user()->avatar_path) }}"
                                                alt="{{ Auth::user()->name }}"
                                                class="il-avatar-badge"
                                            >
                                        @else
                                            <div class="il-avatar-badge il-avatar-placeholder">{{ $navInitials }}</div>
                                        @endif
                                        <span class="fw-semibold">{{ Auth::user()->name }}</span>
                                        <i class="fas fa-chevron-down ms-1" style="font-size: 12px;"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg">
                                        <a class="dropdown-item" href="{{ route('profile.show') }}">
                                            <i class="fa-regular fa-user me-2"></i> Mon profil
                                        </a>
                                        <a class="dropdown-item" href="{{ route('home') }}">
                                            <i class="fa-solid fa-house-chimney me-2"></i> Fil d'actualité
                                        </a>
                                        
                                        {{-- ADMIN uniquement dans dropdown --}}
                                        @can('admin')
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger fw-semibold" href="{{ route('admin.dashboard') }}">
                                                <i class="fa-solid fa-shield-haltered me-2"></i> Administration
                                            </a>
                                        @endcan
                                        
                                        {{-- MODERATEUR uniquement dans dropdown --}}
                                        @can('moderator')
                                            @cannot('admin')
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-warning fw-semibold" href="{{ route('moderator.dashboard') }}">
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

        <main class="@yield('main_class', 'il-main')">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
    @yield('scripts')
</body>
</html>