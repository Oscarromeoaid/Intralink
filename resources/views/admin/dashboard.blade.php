@extends('layouts.app')

@section('content')
@php
    $user = auth()->user();
    $initials = collect(preg_split('/\s+/', trim($user->name)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');
    
    $totalUsers = \App\Models\User::count();
    $totalPosts = \App\Models\Post::count();
    $totalComments = \App\Models\Comment::count();
    $reportedComments = \App\Models\Comment::where('reported', true)->count();
    $userPostsCount = $user->posts()->count();
    $userLikesReceived = $user->posts()->sum('likes_count');
    $userCommentsReceived = $user->posts()->sum('comments_count');
@endphp

<div class="container il-page">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif

    <section class="il-profile-hero mb-4">
        <div class="row g-4 align-items-center">
            <div class="col-lg-8">
                <span class="il-kicker">Administration</span>
                <div class="d-flex align-items-center gap-4 mt-3 flex-wrap">
                    @if($user->avatar_path)
                        <img src="{{ asset('storage/'.$user->avatar_path) }}" alt="{{ $user->name }}" class="il-avatar-hero">
                    @else
                        <div class="il-avatar-hero il-avatar-placeholder">{{ $initials }}</div>
                    @endif

                    <div>
                        <h1 class="mb-2 fw-bold">{{ $user->name }}</h1>
                        <p class="il-text-muted mb-3">{{ $user->email }}</p>

                        <div class="d-flex flex-wrap gap-2">
                            @if($user->position)
                                <span class="il-chip">{{ $user->position->title }}</span>
                            @endif
                            @if($user->departement)
                                <span class="il-chip">{{ $user->departement->name }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users') }}" class="btn il-btn-primary py-3">
                        <i class="fas fa-users me-2"></i> Gérer les utilisateurs
                    </a>
                    <a href="{{ route('home') }}" class="btn il-btn-secondary py-3">Retour au fil</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistiques admin -->
    <div class="il-dashboard-band mb-4">
        <div class="card il-metric-card il-metric-wide">
            <div class="il-metric-label">Administration</div>
            <div class="il-metric-value">Vue d'ensemble</div>
            <div class="il-metric-note">Statistiques globales de la plateforme.</div>
        </div>

        <div class="card il-metric-card">
            <div class="il-metric-label">Utilisateurs</div>
            <div class="il-metric-value">{{ $totalUsers }}</div>
            <div class="il-metric-note">Comptes actifs.</div>
        </div>

        <div class="card il-metric-card">
            <div class="il-metric-label">Posts</div>
            <div class="il-metric-value">{{ $totalPosts }}</div>
            <div class="il-metric-note">Publications partagées.</div>
        </div>

        <div class="card il-metric-card">
            <div class="il-metric-label">Commentaires</div>
            <div class="il-metric-value">{{ $totalComments }}</div>
            <div class="il-metric-note">Discussions générées.</div>
        </div>

        <div class="card il-metric-card">
            <div class="il-metric-label">Signalements</div>
            <div class="il-metric-value">{{ $reportedComments }}</div>
            <div class="il-metric-note">Contenus à modérer.</div>
        </div>
    </div>

    <!-- Tableau personnel admin -->
    <div class="il-dashboard-band mb-4">
        <div class="card il-metric-card il-metric-wide">
            <div class="il-metric-label">Tableau personnel</div>
            <div class="il-metric-value">Vue d'ensemble</div>
            <div class="il-metric-note">Les indicateurs de votre activité sont centralisés ici.</div>
        </div>

        <div class="card il-metric-card">
            <div class="il-metric-label">Posts</div>
            <div class="il-metric-value">{{ $userPostsCount }}</div>
            <div class="il-metric-note">Publications partagées.</div>
        </div>

        <div class="card il-metric-card">
            <div class="il-metric-label">Likes reçus</div>
            <div class="il-metric-value">{{ $userLikesReceived }}</div>
            <div class="il-metric-note">Réactions obtenues.</div>
        </div>

        <div class="card il-metric-card">
            <div class="il-metric-label">Commentaires reçus</div>
            <div class="il-metric-value">{{ $userCommentsReceived }}</div>
            <div class="il-metric-note">Discussions générées.</div>
        </div>
    </div>

    <div class="il-profile-grid">
        <div class="il-grid">
            <!-- Actions admin -->
            <div class="card il-info-card">
                <div class="il-panel-heading">
                    <div>
                        <p class="il-section-title mb-1">Actions rapides</p>
                        <p class="il-meta">Gérez les contenus et utilisateurs.</p>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <a href="{{ route('admin.users') }}" class="btn il-btn-primary w-100 text-start py-3">
                            <i class="fas fa-users me-2"></i> Gérer les utilisateurs
                        </a>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('admin.posts') }}" class="btn il-btn-secondary w-100 text-start py-3">
                            <i class="fas fa-file-alt me-2"></i> Gérer les posts
                        </a>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('admin.reports') }}" class="btn il-btn-secondary w-100 text-start py-3">
                            <i class="fas fa-flag me-2"></i> Voir les signalements
                        </a>
                    </div>
                </div>
            </div>

            <!-- Derniers signalements -->
            @php
                $recentReports = \App\Models\Comment::where('reported', true)->with('user')->latest()->take(5)->get();
            @endphp
            
            @if($recentReports->count() > 0)
            <div class="card il-info-card">
                <div class="il-panel-heading">
                    <div>
                        <p class="il-section-title mb-1">Derniers signalements</p>
                        <p class="il-meta">{{ $recentReports->count() }} commentaire(s) signalé(s)</p>
                    </div>
                </div>

                @foreach($recentReports as $report)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="mb-1">{{ \Illuminate\Support\Str::limit($report->content, 100) }}</p>
                                <small class="il-meta">
                                    <i class="fas fa-user me-1"></i> {{ $report->user->name }}
                                </small>
                            </div>
                            <form action="{{ route('moderator.comments.delete', $report) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>

        <aside class="il-grid">
            <div class="card il-info-card">
                <p class="il-section-title mb-2">Pilotage du profil</p>
                <p class="il-text-muted mb-4">
                    Retrouvez ici vos indicateurs. Le fil principal reste volontairement épuré pour privilégier la lecture.
                </p>

                <div class="d-grid gap-2">
                    <a href="{{ route('profile.edit') }}" class="btn il-btn-primary py-3">Compléter mes informations</a>
                    <a href="{{ route('home') }}" class="btn il-btn-secondary py-3">Retour au fil</a>
                </div>
            </div>

        </aside>
    </div>
</div>
@endsection