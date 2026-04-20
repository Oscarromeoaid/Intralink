@extends('layouts.app')

@section('content')
@php
    $currentUser = auth()->user();
    $userInitials = collect(preg_split('/\s+/', trim($currentUser->name)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');
@endphp

<div class="container il-page">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4">{{ session('error') }}</div>
    @endif

    <div class="il-feed-layout">
        <section class="il-grid">
            <div class="il-hero">
                <span class="il-kicker">Fil interne</span>
                <h1 class="il-heading mt-3">Un fil plus net, plus calme, plus lisible.</h1>
                <p class="il-lead mt-4 mb-0">
                    Retrouvez les publications de l'equipe dans une mise en page plus sobre. Le tableau de bord reste sur votre profil, ici on se concentre sur les echanges.
                </p>
            </div>

            <!-- Formulaire de création de post -->
            <div class="card il-composer">
                <div class="d-flex align-items-center gap-3 mb-4">
                    @if($currentUser->avatar_path)
                        <img src="{{ asset('storage/'.$currentUser->avatar_path) }}" alt="{{ $currentUser->name }}" class="il-avatar-lg">
                    @else
                        <div class="il-avatar-lg il-avatar-placeholder">{{ $userInitials }}</div>
                    @endif

                    <div>
                        <p class="il-section-title mb-1">Nouvelle publication</p>
                        <p class="il-meta mb-0">Une mise a jour simple, sans surcharge visuelle.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                    @csrf
                    <textarea
                        name="content"
                        class="form-control border-0 bg-light p-3"
                        style="border-radius: 15px; resize: none;"
                        rows="3"
                        placeholder="Quoi de neuf aujourd'hui ?"
                        required
                    ></textarea>

                    <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between mt-3">
                        <label class="il-file-frame flex-grow-1">
                            <i class="fa-regular fa-image"></i>
                            <span class="flex-grow-1">
                                <strong class="d-block">Ajouter un media</strong>
                                <span class="il-meta">Image ou video d'accompagnement.</span>
                            </span>
                            <input type="file" name="media" class="form-control border-0 bg-transparent p-0 shadow-none" accept="image/*,video/*">
                        </label>

                        <button type="submit" class="il-btn-publish">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            Publier
                        </button>
                    </div>
                </form>
            </div>

            <!-- Liste des posts -->
            @forelse($posts as $post)
                @php
                    $authorInitials = collect(preg_split('/\s+/', trim($post->user->name)))
                        ->filter()
                        ->take(2)
                        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                        ->implode('');
                    $previewComments = $post->comments->whereNull('parent_id')->take(2);
                    $commentCount = $post->comments->count();
                    $isLiked = $post->likes->contains('user_id', $currentUser->id);
                @endphp

                <article class="card il-post-card">
                    <!-- En-tête du post -->
                    <div class="il-post-header">
                        <div class="il-post-author">
                            @if($post->user->avatar_path)
                                <img src="{{ asset('storage/'.$post->user->avatar_path) }}" alt="{{ $post->user->name }}" class="il-avatar-lg">
                            @else
                                <div class="il-avatar-lg il-avatar-placeholder">{{ $authorInitials }}</div>
                            @endif

                            <div>
                                <p class="il-name">{{ $post->user->name }}</p>
                                <p class="il-subname mb-0">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <a href="{{ route('posts.show', $post) }}" class="il-action-pill text-decoration-none">
                            Ouvrir
                        </a>
                    </div>

                    <!-- Contenu du post -->
                    <div class="il-post-content">{{ $post->content }}</div>

                    <!-- Media du post -->
                    @if($post->media_path)
                        <div class="il-post-media">
                            @if($post->media_type === 'image')
                                <img src="{{ asset('storage/'.$post->media_path) }}" alt="Media de publication">
                            @else
                                <video controls>
                                    <source src="{{ asset('storage/'.$post->media_path) }}" type="{{ $post->media_mime }}">
                                </video>
                            @endif
                        </div>
                    @endif

                    <!-- Statistiques du post -->
                    <div class="il-post-stats">
                        <div class="il-stats-row">
                            <span class="il-stat-pill">{{ $post->likes->count() }} j'aime</span>
                            <span class="il-stat-pill">{{ $commentCount }} commentaire{{ $commentCount > 1 ? 's' : '' }}</span>
                        </div>

                        <div class="il-action-row">
                            <form method="POST" action="{{ route('posts.like', $post) }}">
                                @csrf
                                <button type="submit" class="il-action-pill {{ $isLiked ? 'liked' : '' }}">
                                    {{ $isLiked ? 'Aimé' : 'J\'aime' }}
                                </button>
                            </form>
                            <a href="{{ route('posts.show', $post) }}" class="il-action-pill">
                                Voir le detail
                            </a>
                        </div>
                    </div>

                    <!-- Formulaire de commentaire -->
                    <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="il-comment-form mt-4">
                        @csrf
                        @if($currentUser->avatar_path)
                            <img src="{{ asset('storage/'.$currentUser->avatar_path) }}" alt="{{ $currentUser->name }}" class="il-avatar-sm">
                        @else
                            <div class="il-avatar-sm il-avatar-placeholder">{{ $userInitials }}</div>
                        @endif
                        <input type="text" name="content" class="form-control" placeholder="Ajouter un commentaire" required>
                        <button type="submit" class="btn il-btn-secondary px-4 py-2">Envoyer</button>
                    </form>

                    <!-- Liste des commentaires -->
                    @if($commentCount > 0)
                        <div class="il-comment-list mt-4">
                            @foreach($previewComments as $comment)
                                @php
                                    $commentInitials = collect(preg_split('/\s+/', trim($comment->user->name)))
                                        ->filter()
                                        ->take(2)
                                        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                                        ->implode('');
                                @endphp
                                <div class="il-comment">
                                    @if($comment->user->avatar_path)
                                        <img src="{{ asset('storage/'.$comment->user->avatar_path) }}" alt="{{ $comment->user->name }}" class="il-avatar-sm">
                                    @else
                                        <div class="il-avatar-sm il-avatar-placeholder">{{ $commentInitials }}</div>
                                    @endif

                                    <div class="il-comment-body">
                                        <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                                            <strong>{{ $comment->user->name }}</strong>
                                            <span class="il-meta">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="mt-2" style="white-space: pre-wrap;">{{ $comment->content }}</div>

                                        <!-- Actions du commentaire -->
                                        <div class="il-comment-actions mt-2">
                                            <button type="button" class="btn btn-link p-0 il-comment-link" data-reply-toggle="{{ $comment->id }}">
                                                <i class="fas fa-reply"></i> Répondre
                                            </button>
                                            
                                            <!-- Bouton Signaler (visible pour les users normaux) -->
                                            @if($currentUser->role === 'user')
                                                <form method="POST" action="{{ route('comments.report', $comment) }}" class="d-inline ms-3">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link p-0 il-comment-link text-danger" onclick="return confirm('Signaler ce commentaire comme inapproprié ?')">
                                                        <i class="fas fa-flag"></i> Signaler
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <!-- Bouton Supprimer (visible pour admin/modo) -->
                                            @can('moderator')
                                                <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="d-inline ms-3">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link p-0 il-comment-link text-danger" onclick="return confirm('Supprimer ce commentaire définitivement ?')">
                                                        <i class="fas fa-trash"></i> Supprimer
                                                    </button>
                                                </form>
                                            @endcan
                                            
                                            @if($comment->replies->count() > 0)
                                                <span class="il-meta ms-3">{{ $comment->replies->count() }} réponse{{ $comment->replies->count() > 1 ? 's' : '' }}</span>
                                            @endif
                                        </div>

                                        <!-- Formulaire de réponse -->
                                        <div class="mt-3 d-none" data-reply-form="{{ $comment->id }}">
                                            <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="il-inline-form">
                                                @csrf
                                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                <div class="d-flex gap-2">
                                                    <input type="text" name="content" class="form-control form-control-sm" placeholder="Votre réponse..." required>
                                                    <button type="submit" class="btn il-btn-primary btn-sm px-3">Répondre</button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Liste des réponses -->
                                        @if($comment->replies->count() > 0)
                                            <div class="il-replies mt-3">
                                                @foreach($comment->replies as $reply)
                                                    @php
                                                        $replyInitials = collect(preg_split('/\s+/', trim($reply->user->name)))
                                                            ->filter()
                                                            ->take(2)
                                                            ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                                                            ->implode('');
                                                    @endphp
                                                    <div class="il-comment mt-2">
                                                        @if($reply->user->avatar_path)
                                                            <img src="{{ asset('storage/'.$reply->user->avatar_path) }}" alt="{{ $reply->user->name }}" class="il-avatar-sm">
                                                        @else
                                                            <div class="il-avatar-sm il-avatar-placeholder">{{ $replyInitials }}</div>
                                                        @endif

                                                        <div class="il-comment-body">
                                                            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                                                                <strong>{{ $reply->user->name }}</strong>
                                                                <span class="il-meta">{{ $reply->created_at->diffForHumans() }}</span>
                                                            </div>
                                                            <div class="mt-2" style="white-space: pre-wrap;">{{ $reply->content }}</div>
                                                            
                                                            <!-- Actions pour les réponses -->
                                                            <div class="il-comment-actions mt-2">
                                                                @if($currentUser->role === 'user')
                                                                    <form method="POST" action="{{ route('comments.report', $reply) }}" class="d-inline">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-link p-0 il-comment-link text-danger" onclick="return confirm('Signaler ce commentaire comme inapproprié ?')">
                                                                            <i class="fas fa-flag"></i> Signaler
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                                
                                                                @can('moderator')
                                                                    <form method="POST" action="{{ route('comments.destroy', $reply) }}" class="d-inline ms-3">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-link p-0 il-comment-link text-danger" onclick="return confirm('Supprimer ce commentaire ?')">
                                                                            <i class="fas fa-trash"></i> Supprimer
                                                                        </button>
                                                                    </form>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($commentCount > 2)
                            <div class="mt-3 text-center">
                                <a href="{{ route('posts.show', $post) }}" class="il-comment-link">
                                    Voir tous les {{ $commentCount }} commentaires
                                </a>
                            </div>
                        @endif
                    @endif
                </article>
            @empty
                <div class="card p-5 text-center">
                    <span class="il-kicker">Aucune publication</span>
                    <h2 class="mt-3 mb-2 fw-bold">Le fil est encore vide.</h2>
                    <p class="il-text-muted mb-0">Soyez la premiere personne a publier une information.</p>
                </div>
            @endforelse

            <!-- Pagination -->
            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        </section>

        <!-- Sidebar droite -->
        <aside class="il-grid il-profile-panel">
            <div class="card il-sidebar-card overflow-hidden">
                <div class="il-profile-banner"></div>

                <div class="px-1">
                    <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-3">
                        @if($currentUser->avatar_path)
                            <img src="{{ asset('storage/'.$currentUser->avatar_path) }}" alt="{{ $currentUser->name }}" class="il-avatar-hero">
                        @else
                            <div class="il-avatar-hero il-avatar-placeholder">{{ $userInitials }}</div>
                        @endif

                        <a href="{{ route('profile.edit') }}" class="btn il-btn-secondary px-3">Modifier</a>
                    </div>

                    <h2 class="h4 fw-bold mb-1">{{ $currentUser->name }}</h2>
                    <p class="il-text-muted mb-3">{{ $currentUser->email }}</p>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        @if($currentUser->position)
                            <span class="il-chip">{{ $currentUser->position->title }}</span>
                        @endif
                        @if($currentUser->departement)
                            <span class="il-chip">{{ $currentUser->departement->name }}</span>
                        @endif
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.show') }}" class="btn il-btn-primary py-3">Voir mon profil</a>
                        <a href="{{ route('profile.edit') }}" class="btn il-btn-secondary py-3">Mettre a jour mon profil</a>
                    </div>
                </div>
            </div>

            <div class="card il-sidebar-card">
                <p class="il-section-title mb-2">À propos de cet espace</p>
                <p class="il-text-muted mb-0">
                    Le fil sert à lire et publier. Les indicateurs et le tableau de bord personnel sont désormais regroupés sur la page profil.
                </p>
            </div>
        </aside>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Gestion des réponses aux commentaires
    const toggles = document.querySelectorAll('[data-reply-toggle]');

    toggles.forEach((toggle) => {
        toggle.addEventListener('click', function () {
            const targetId = this.dataset.replyToggle;

            document.querySelectorAll('[data-reply-form]').forEach((form) => {
                if (form.dataset.replyForm === targetId) {
                    form.classList.toggle('d-none');
                } else {
                    form.classList.add('d-none');
                }
            });
        });
    });

    // Fermer les formulaires de réponse en cliquant ailleurs
    document.addEventListener('click', function (event) {
        if (!event.target.closest('[data-reply-toggle]') && !event.target.closest('[data-reply-form]')) {
            document.querySelectorAll('[data-reply-form]').forEach((form) => {
                form.classList.add('d-none');
            });
        }
    });
});
</script>
@endpush