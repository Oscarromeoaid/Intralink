@extends('layouts.app')

@section('title', 'Gestion des posts')

@section('content')
<div class="container il-page">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="il-kicker">Administration</span>
            <h1 class="il-heading mt-2">Gestion des posts</h1>
            <p class="il-lead mt-2">Modérer et supprimer les publications.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn il-btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour
        </a>
    </div>

    @forelse($posts as $post)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            @if($post->user->avatar_path)
                                <img src="{{ asset('storage/'.$post->user->avatar_path) }}" class="rounded-circle" width="32" height="32">
                            @else
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <strong>{{ $post->user->name }}</strong>
                                <small class="text-muted ms-2">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <p class="mb-2">{{ $post->content }}</p>
                        <div class="d-flex gap-3">
                            <small class="text-muted">
                                <i class="fas fa-heart text-danger"></i> {{ $post->likes_count ?? $post->likes->count() }}
                            </small>
                            <small class="text-muted">
                                <i class="fas fa-comment"></i> {{ $post->comments_count ?? $post->comments->count() }}
                            </small>
                        </div>
                    </div>
                    <form action="{{ route('admin.posts.delete', $post) }}" method="POST" onsubmit="return confirm('Supprimer ce post ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm text-center py-5">
            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
            <p class="mb-0">Aucun post trouvé.</p>
        </div>
    @endforelse

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection