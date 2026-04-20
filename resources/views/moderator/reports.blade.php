@extends('layouts.app')

@section('title', 'Statistiques de modération')

@section('content')
<div class="container il-page">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <span class="il-kicker">Modération</span>
            <h1 class="il-heading mt-2">Statistiques de modération</h1>
            <p class="il-lead mt-2">Vue d'ensemble de l'activité de modération.</p>
        </div>
        <a href="{{ route('moderator.dashboard') }}" class="btn il-btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4">
                <i class="fas fa-file-alt fa-3x mb-3" style="color: #3b82f6;"></i>
                <h2 class="fw-bold mb-1">{{ $reports['total_posts'] }}</h2>
                <p class="text-muted mb-0">Total des posts</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4">
                <i class="fas fa-comments fa-3x mb-3" style="color: #f59e0b;"></i>
                <h2 class="fw-bold mb-1">{{ $reports['total_comments'] }}</h2>
                <p class="text-muted mb-0">Total des commentaires</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4">
                <i class="fas fa-flag fa-3x mb-3" style="color: #ef4444;"></i>
                <h2 class="fw-bold mb-1">{{ $reports['reported_comments'] }}</h2>
                <p class="text-muted mb-0">Signalements en cours</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4">
                <i class="fas fa-check-circle fa-3x mb-3" style="color: #10b981;"></i>
                <h2 class="fw-bold mb-1">{{ $reports['resolved_reports'] }}</h2>
                <p class="text-muted mb-0">Signalements résolus</p>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body text-center py-5">
            <i class="fas fa-chart-line fa-4x text-muted mb-3 d-block"></i>
            <h5>Statistiques détaillées</h5>
            <p class="text-muted mb-0">Plus de statistiques seront disponibles prochainement.</p>
        </div>
    </div>
</div>
@endsection