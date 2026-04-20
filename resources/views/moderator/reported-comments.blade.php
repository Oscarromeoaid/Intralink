@extends('layouts.app')

@section('title', 'Commentaires signalés')

@section('content')
<div class="container il-page">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <span class="il-kicker">Modération</span>
            <h1 class="il-heading mt-2">Commentaires signalés</h1>
            <p class="il-lead mt-2">Examiner et modérer les commentaires signalés par les utilisateurs.</p>
        </div>
        <a href="{{ route('moderator.dashboard') }}" class="btn il-btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-3">
                <i class="fas fa-flag fa-2x mb-2" style="color: #ef4444;"></i>
                <h3 class="mb-0 fw-bold">{{ $comments->total() }}</h3>
                <small class="text-muted">Signalements en attente</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-3">
                <i class="fas fa-comments fa-2x mb-2" style="color: #f59e0b;"></i>
                <h3 class="mb-0 fw-bold">{{ \App\Models\Comment::count() }}</h3>
                <small class="text-muted">Total commentaires</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-3">
                <i class="fas fa-check-circle fa-2x mb-2" style="color: #10b981;"></i>
                <h3 class="mb-0 fw-bold">{{ \App\Models\Comment::where('reported', false)->whereNotNull('reported_at')->count() }}</h3>
                <small class="text-muted">Signalements résolus</small>
            </div>
        </div>
    </div>

    @forelse($comments as $comment)
        <div class="card border-danger shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <!-- Auteur -->
                        <div class="d-flex align-items-center gap-2 mb-3">
                            @if($comment->user->avatar_path)
                                <img src="{{ asset('storage/'.$comment->user->avatar_path) }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-gradient-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 600;">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <strong>{{ $comment->user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                        </div>

                        <!-- Contenu du commentaire -->
                        <div class="bg-light p-3 rounded-3 mb-3">
                            <p class="mb-0">{{ $comment->content }}</p>
                        </div>

                        <!-- Info du post associé -->
                        <div class="small text-muted mb-3">
                            <i class="fas fa-file-alt me-1"></i> Sur le post de 
                            <strong>{{ $comment->post->user->name }}</strong> : 
                            "{{ \Illuminate\Support\Str::limit($comment->post->content, 100) }}"
                        </div>

                        <!-- Badge signalement -->
                        <div class="d-flex gap-2">
                            <span class="badge bg-danger">
                                <i class="fas fa-flag me-1"></i> Signalé
                            </span>
                            @if($comment->reported_at)
    <span class="badge bg-secondary">
        <i class="fas fa-clock me-1"></i> {{ \Carbon\Carbon::parse($comment->reported_at)->diffForHumans() }}
    </span>
@endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="btn-group-vertical btn-group-sm ms-3">
                        <form action="{{ route('moderator.comments.ignore', $comment) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-success" title="Ignorer le signalement">
                                <i class="fas fa-check me-1"></i> Ignorer
                            </button>
                        </form>
                        <form action="{{ route('moderator.comments.delete', $comment) }}" method="POST" class="d-inline mt-2" onsubmit="return confirm('Supprimer ce commentaire définitivement ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                <i class="fas fa-trash me-1"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm text-center py-5">
            <i class="fas fa-flag-checkered fa-4x text-muted mb-3 d-block"></i>
            <h5 class="mb-1">Aucun signalement en attente</h5>
            <p class="text-muted mb-0">Tous les commentaires ont été modérés.</p>
        </div>
    @endforelse

    <div class="mt-4">
        {{ $comments->links() }}
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>
@endsection