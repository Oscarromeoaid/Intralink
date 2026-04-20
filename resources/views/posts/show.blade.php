@extends('layouts.app')

@section('content')
@php
    $currentUser = auth()->user();
    $authorInitials = collect(preg_split('/\s+/', trim($post->user->name)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');
    $currentUserInitials = collect(preg_split('/\s+/', trim($currentUser->name)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');
@endphp

<div class="container il-page">
    <div class="il-detail-wrap">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <a href="{{ route('home') }}" class="il-back-link">
                <i class="fa-solid fa-arrow-left"></i>
                Retour au fil
            </a>
            <a href="{{ route('profile.show') }}" class="btn il-btn-secondary px-4 py-2">Mon profil</a>
        </div>

        <article class="card il-post-card">
            <div class="il-post-header">
                <div class="il-post-author">
                    @if($post->user->avatar_path)
                        <img src="{{ asset('storage/'.$post->user->avatar_path) }}" alt="{{ $post->user->name }}" class="il-avatar-lg">
                    @else
                        <div class="il-avatar-lg il-avatar-placeholder">{{ $authorInitials }}</div>
                    @endif

                    <div>
                        <p class="il-name">{{ $post->user->name }}</p>
                        <p class="il-subname mb-2">{{ $post->created_at->diffForHumans() }}</p>
                        <span class="il-chip">
                            <i class="fa-regular fa-comment-dots"></i>
                            Discussion ouverte
                        </span>
                    </div>
                </div>
            </div>

            <div class="il-post-content">{{ $post->content }}</div>

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

            <div class="il-post-stats">
                <div class="il-stats-row">
                    <span class="il-stat-pill">
                        <i class="fa-solid fa-heart"></i>
                        {{ $post->likes->count() }} j'aime
                    </span>
                    <span class="il-stat-pill">
                        <i class="fa-regular fa-comment"></i>
                        {{ $post->comments->count() }} commentaires
                    </span>
                </div>

                <div class="il-action-row">
                    <form method="POST" action="{{ route('posts.like', $post) }}">
                        @csrf
                        <button type="submit" class="il-action-pill {{ $post->isLikedBy($currentUser) ? 'liked' : '' }}">
                            <i class="fa{{ $post->isLikedBy($currentUser) ? 's' : 'r' }} fa-heart"></i>
                            {{ $post->isLikedBy($currentUser) ? 'Aime' : 'J aime' }}
                        </button>
                    </form>
                </div>
            </div>

            <hr class="il-divider">

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <div>
                        <p class="il-section-title mb-1">Participer a la conversation</p>
                        <p class="il-meta mb-0">Ajoutez un commentaire ou repondez directement a un message.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="il-comment-form">
                    @csrf
                    @if($currentUser->avatar_path)
                        <img src="{{ asset('storage/'.$currentUser->avatar_path) }}" alt="{{ $currentUser->name }}" class="il-avatar-sm">
                    @else
                        <div class="il-avatar-sm il-avatar-placeholder">{{ $currentUserInitials }}</div>
                    @endif
                    <input type="text" name="content" class="form-control" placeholder="Ajouter un commentaire" required>
                    <button type="submit" class="btn il-btn-primary px-4 py-2">Envoyer</button>
                </form>
            </div>

            <div class="il-comment-list">
                @forelse($post->comments->whereNull('parent_id') as $comment)
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

                            <div class="il-comment-actions">
                                <button type="button" class="btn btn-link p-0 il-comment-link" data-reply-toggle="{{ $comment->id }}">
                                    Repondre
                                </button>

                                <form action="{{ route('comments.like', $comment) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0 il-comment-link">
                                        {{ $comment->isLikedBy($currentUser) ? 'Retirer le like' : 'Aimer' }} ({{ $comment->likesCount() }})
                                    </button>
                                </form>

                                @can('delete', $comment)
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0 text-danger text-decoration-none fw-bold" onclick="return confirm('Supprimer ce commentaire ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                @endcan
                            </div>

                            <div class="mt-3 d-none" data-reply-form="{{ $comment->id }}">
                                <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="il-inline-form">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                    <input type="text" name="content" class="form-control" placeholder="Votre reponse" required>
                                    <button type="submit" class="btn il-btn-primary px-4 py-2">Repondre</button>
                                </form>
                            </div>

                            @if($comment->replies->count() > 0)
                                <div class="il-replies">
                                    @foreach($comment->replies as $reply)
                                        @php
                                            $replyInitials = collect(preg_split('/\s+/', trim($reply->user->name)))
                                                ->filter()
                                                ->take(2)
                                                ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                                                ->implode('');
                                        @endphp

                                        <div class="il-comment">
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

                                                <div class="il-comment-actions">
                                                    <button type="button" class="btn btn-link p-0 il-comment-link" data-reply-toggle="{{ $reply->id }}">
                                                        Repondre
                                                    </button>

                                                    <form action="{{ route('comments.like', $reply) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-link p-0 il-comment-link">
                                                            {{ $reply->isLikedBy($currentUser) ? 'Retirer le like' : 'Aimer' }} ({{ $reply->likesCount() }})
                                                        </button>
                                                    </form>

                                                    @can('delete', $reply)
                                                        <form action="{{ route('comments.destroy', $reply) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link p-0 text-danger text-decoration-none fw-bold" onclick="return confirm('Supprimer cette reponse ?')">
                                                                Supprimer
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>

                                                <div class="mt-3 d-none" data-reply-form="{{ $reply->id }}">
                                                    <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="il-inline-form">
                                                        @csrf
                                                        <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                                                        <input type="text" name="content" class="form-control" placeholder="Votre reponse" required>
                                                        <button type="submit" class="btn il-btn-primary px-4 py-2">Repondre</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <p class="il-text-muted mb-0">Aucun commentaire pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </article>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('[data-reply-toggle]');

    toggles.forEach((toggle) => {
        toggle.addEventListener('click', function () {
            const targetId = this.dataset.replyToggle;

            document.querySelectorAll('[data-reply-form]').forEach((form) => {
                form.classList.toggle('d-none', form.dataset.replyForm !== targetId);
            });
        });
    });

    document.addEventListener('click', function (event) {
        if (!event.target.closest('[data-reply-toggle]') && !event.target.closest('[data-reply-form]')) {
            document.querySelectorAll('[data-reply-form]').forEach((form) => form.classList.add('d-none'));
        }
    });
});
</script>
@endpush
