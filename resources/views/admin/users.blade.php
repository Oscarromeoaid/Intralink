@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="container il-page">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        </div>
    @endif

    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <span class="il-kicker">Administration</span>
            <h1 class="il-heading mt-2">Gestion des utilisateurs</h1>
            <p class="il-lead mt-2">Modifier, promouvoir ou supprimer des comptes.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn il-btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour
        </a>
    </div>

    <!-- Statistiques rapides -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <i class="fas fa-users fa-2x mb-2" style="color: #3b82f6;"></i>
                <h3 class="mb-0 fw-bold">{{ $users->total() }}</h3>
                <small class="text-muted">Total utilisateurs</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <i class="fas fa-user-shield fa-2x mb-2" style="color: #ef4444;"></i>
                <h3 class="mb-0 fw-bold">{{ $users->where('role', 'admin')->count() }}</h3>
                <small class="text-muted">Administrateurs</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <i class="fas fa-user-check fa-2x mb-2" style="color: #f59e0b;"></i>
                <h3 class="mb-0 fw-bold">{{ $users->where('role', 'moderator')->count() }}</h3>
                <small class="text-muted">Modérateurs</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <i class="fas fa-user fa-2x mb-2" style="color: #10b981;"></i>
                <h3 class="mb-0 fw-bold">{{ $users->where('role', 'user')->count() }}</h3>
                <small class="text-muted">Utilisateurs</small>
            </div>
        </div>
    </div>

    <!-- Tableau des utilisateurs -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4" width="25%">Utilisateur</th>
                            <th width="25%">Email</th>
                            <th width="12%">Rôle</th>
                            <th width="8%" class="text-center">Posts</th>
                            <th width="8%" class="text-center">Commentaires</th>
                            <th width="12%">Inscrit le</th>
                            <th width="10%" class="pe-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        @if($user->avatar_path)
                                            <img src="{{ asset('storage/'.$user->avatar_path) }}" alt="{{ $user->name }}" class="rounded-circle" width="36" height="36" style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-gradient-primary text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-size: 14px; font-weight: 600;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <span class="fw-semibold">{{ $user->name }}</span>
                                            @if($user->job_title)
                                                <br><small class="text-muted">{{ $user->job_title }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="small">{{ $user->email }}</span>
                                    @if($user->email_verified_at)
                                        <i class="fas fa-check-circle text-success ms-1" style="font-size: 12px;" title="Email vérifié"></i>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : ($user->role === 'moderator' ? 'bg-warning' : 'bg-secondary') }} px-3 py-2">
                                        <i class="fas {{ $user->role === 'admin' ? 'fa-shield-alt' : ($user->role === 'moderator' ? 'fa-gavel' : 'fa-user') }} me-1"></i>
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-semibold">{{ $user->posts_count ?? $user->posts->count() }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-semibold">{{ $user->comments_count ?? $user->comments->count() }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $user->created_at->format('d/m/Y') }}</small>
                                </td>
                                <td class="pe-4 text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <button type="button" class="btn btn-outline-danger" title="Supprimer" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-outline-secondary" disabled title="Vous ne pouvez pas vous supprimer vous-même">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>

                                    <!-- Modal de confirmation suppression -->
                                    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmer la suppression</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    <p>Êtes-vous sûr de vouloir supprimer l'utilisateur <strong>{{ $user->name }}</strong> ?</p>
                                                    <p class="text-danger small mb-0">⚠️ Cette action est irréversible. Tous ses posts, commentaires et likes seront également supprimés.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn il-btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-trash me-1"></i> Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-users fa-4x text-muted mb-3 d-block"></i>
                                    <h5 class="mb-1">Aucun utilisateur trouvé</h5>
                                    <p class="text-muted mb-0">Essayez de modifier vos critères de recherche.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div class="small text-muted">
            Affichage de {{ $users->firstItem() ?? 0 }} à {{ $users->lastItem() ?? 0 }} sur {{ $users->total() }} utilisateurs
        </div>
        <div>
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.table-hover tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.05);
}
.modal-content {
    border: none;
    border-radius: 16px;
}
</style>
@endsection