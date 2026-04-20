@extends('layouts.app')

@section('content')
@php
    $initials = collect(preg_split('/\s+/', trim($user->name)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');
    $likesReceived = $posts->sum('likes_count');
    $commentsReceived = $posts->sum('comments_count');
@endphp

<div class="container il-page">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif

    <section class="il-profile-hero mb-4">
        <div class="row g-4 align-items-center">
            <div class="col-lg-8">
                <span class="il-kicker">Profil</span>
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
                    <a href="{{ route('profile.edit') }}" class="btn il-btn-primary py-3">Modifier mon profil</a>
                    <a href="{{ route('home') }}" class="btn il-btn-secondary py-3">Retour au fil</a>
                </div>
            </div>
        </div>
    </section>

    <div class="il-dashboard-band mb-4">
        <div class="card il-metric-card il-metric-wide">
            <div class="il-metric-label">Tableau personnel</div>
            <div class="il-metric-value">Vue d'ensemble</div>
            <div class="il-metric-note">Les indicateurs de votre activite sont centralises ici.</div>
        </div>

        <div class="card il-metric-card">
            <div class="il-metric-label">Posts</div>
            <div class="il-metric-value">{{ $posts->count() }}</div>
            <div class="il-metric-note">Publications partagees.</div>
        </div>

        <div class="card il-metric-card">
            <div class="il-metric-label">Likes recus</div>
            <div class="il-metric-value">{{ $likesReceived }}</div>
            <div class="il-metric-note">Reactions obtenues.</div>
        </div>

        <div class="card il-metric-card">
            <div class="il-metric-label">Commentaires recus</div>
            <div class="il-metric-value">{{ $commentsReceived }}</div>
            <div class="il-metric-note">Discussions generees.</div>
        </div>
    </div>

    <div class="il-profile-grid">
        <div class="il-grid">
            <div class="card il-info-card">
                <div class="il-panel-heading">
                    <div>
                        <p class="il-section-title mb-1">Informations</p>
                        <p class="il-meta">Les informations de reference de votre profil.</p>
                    </div>
                </div>

                <div class="il-identity-grid">
                    <div class="il-info-item">
                        <span>Email</span>
                        <strong>{{ $user->email }}</strong>
                    </div>
                    <div class="il-info-item">
                        <span>Telephone</span>
                        <strong>{{ $user->phone ?: 'Non renseigne' }}</strong>
                    </div>
                    <div class="il-info-item">
                        <span>Localisation</span>
                        <strong>{{ $user->location ?: 'Non renseignee' }}</strong>
                    </div>
                    <div class="il-info-item">
                        <span>Departement</span>
                        <strong>{{ $user->departement?->name ?: 'Non renseigne' }}</strong>
                    </div>
                </div>

                <div class="il-info-item mt-3">
                    <span>Bio</span>
                    <div>{{ $user->bio ?: 'Aucune bio ajoutee pour le moment.' }}</div>
                </div>
            </div>

            <div class="card il-info-card">
                <div class="il-panel-heading">
                    <div>
                        <p class="il-section-title mb-1">Publications</p>
                        <p class="il-meta">{{ $posts->count() }} publication{{ $posts->count() > 1 ? 's' : '' }}</p>
                    </div>
                </div>

                <div class="il-grid">
                    @forelse($posts as $post)
                        <article class="il-post-preview">
                            <div class="d-flex justify-content-between align-items-center gap-3 mb-3 flex-wrap">
                                <span class="il-chip">{{ $post->created_at->diffForHumans() }}</span>
                                <a href="{{ route('posts.show', $post) }}" class="il-comment-link">Voir le detail</a>
                            </div>

                            <div style="white-space: pre-wrap;" class="mb-3">{{ $post->content }}</div>

                            @if($post->media_path)
                                <div class="il-post-media mb-3">
                                    @if($post->media_type === 'image')
                                        <img src="{{ asset('storage/'.$post->media_path) }}" alt="Media de publication">
                                    @else
                                        <video controls>
                                            <source src="{{ asset('storage/'.$post->media_path) }}" type="{{ $post->media_mime }}">
                                        </video>
                                    @endif
                                </div>
                            @endif

                            <div class="il-stats-row">
                                <span class="il-stat-pill">{{ $post->likes_count }} j'aime</span>
                                <span class="il-stat-pill">{{ $post->comments_count }} commentaires</span>
                            </div>
                        </article>
                    @empty
                        <div class="text-center py-5">
                            <span class="il-kicker">Aucun contenu</span>
                            <h3 class="mt-3 mb-2 fw-bold">Aucune publication pour l'instant.</h3>
                            <p class="il-text-muted mb-0">Passez sur le fil pour publier votre premiere information.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <aside class="il-grid">
            <div class="card il-info-card">
                <p class="il-section-title mb-2">Pilotage du profil</p>
                <p class="il-text-muted mb-4">
                    Retrouvez ici vos indicateurs. Le fil principal reste volontairement epure pour privilegier la lecture.
                </p>

                <div class="d-grid gap-2">
                    <a href="{{ route('profile.edit') }}" class="btn il-btn-primary py-3">Completer mes informations</a>
                    <a href="{{ route('home') }}" class="btn il-btn-secondary py-3">Retour au fil</a>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
