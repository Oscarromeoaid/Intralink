@extends('layouts.app')

@section('content')
@php
    $user = auth()->user();
    $initials = collect(preg_split('/\s+/', trim($user->name)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');
@endphp

<div class="container il-page">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif

    <section class="il-profile-hero mb-4">
        <div class="row g-4 align-items-center">
            <div class="col-lg-8">
                <span class="il-kicker">Modération</span>
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
                            <span class="il-chip bg-warning text-dark">Modérateur</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('moderator.comments.reported') }}" class="btn il-btn-primary py-3">
                        <i class="fas fa-flag me-2"></i> Voir les signalements
                    </a>
                    <a href="{{ route('home') }}" class="btn il-btn-secondary py-3">Retour au fil</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistiques globales -->
    <div class="il-dashboard-band mb-4">
        <div class="card il-metric-card il-metric-wide">
            <div class="il-metric-label">Modération</div>
            <div class="il-metric-value">Vue d'ensemble</div>
            <div class="il-metric-note">Statistiques de la plateforme.</div>
        </div>

        <div class="card il-metric-card">
            <div class="il-metric-label">Signalements</div>
            <div class="il-metric-value">{{ $reportedComments }}</div>
            <div class="il-metric-note">Commentaires signalés.</div>
        </div>

        <div class="card il-metric-card">
            <div class="il-metric-label">Total commentaires</div>
            <div class="il-metric-value">{{ $totalComments }}</div>
            <div class="il-metric-note">Discussions générées.</div>
        </div>

        <div class="card il-metric-card">
            <div class="il-metric-label">Total posts</div>
            <div class="il-metric-value">{{ $totalPosts }}</div>
            <div class="il-metric-note">Publications partagées.</div>
        </div>
    </div>

    <!-- Tableau personnel -->
    <div class="il-dashboard-band mb-4">
        <div class="card il-metric-card il-metric-wide">
            <div class="il-metric-label">Tableau personnel</div>
            <div class="il-metric-value">Vue d'ensemble</div>
            <div class="il-metric-note">Les indicateurs de votre activité sont centralisés ici.</div>
        </div>

        <div class="card il-metric-card">
            <div class="il-metric-label">Mes posts</div>
            <div class="il-metric-value">{{ $userPostsCount }}</div>
            <div class="il-metric-note">Publications partagées.</div>
        </div>

        <div class="card il-metric-card">
            <div class="il-metric-label">Likes reçus</div>
            <div class="il-metric-value">{{ $userLikesReceived }}</div>
            <div class="il-metric-note">Réactions obtenues.</div>
        </div>

        <div class="card il-metric-card">
            <div class="il-metric-label">Mes commentaires</div>
            <div class="il-metric-value">{{ $userCommentsCount }}</div>
            <div class="il-metric-note">Discussions générées.</div>
        </div>
    </div>

    <div class="il-profile-grid">
        <div class="il-grid">
            <div class="card il-info-card">
                <div class="il-panel-heading">
                    <div>
                        <p class="il-section-title mb-1">Actions rapides</p>
                        <p class="il-meta">Gérez les signalements et modérez les contenus.</p>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <a href="{{ route('moderator.comments.reported') }}" class="btn il-btn-primary w-100 text-start py-3">
                            <i class="fas fa-flag me-2"></i> Voir les signalements
                        </a>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('moderator.reports') }}" class="btn il-btn-secondary w-100 text-start py-3">
                            <i class="fas fa-chart-bar me-2"></i> Statistiques de modération
                        </a>
                    </div>
                </div>
            </div>
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

    @if($recentReportedComments->count() > 0)
    <div class="mt-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-clock me-2" style="color: #ef4444;"></i>
                    Derniers signalements
                </h5>
            </div>
            <div class="card-body">
                @foreach($recentReportedComments as $comment)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <p class="mb-1">{{ \Illuminate\Support\Str::limit($comment->content, 100) }}</p>
                                <small class="il-meta">
                                    <i class="fas fa-user me-1"></i> {{ $comment->user->name }} |
                                    <i class="fas fa-calendar me-1 ms-2"></i> {{ $comment->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="btn-group btn-group-sm">
                                <form action="{{ route('moderator.comments.ignore', $comment) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success" title="Ignorer le signalement">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('moderator.comments.delete', $comment) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce commentaire ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection