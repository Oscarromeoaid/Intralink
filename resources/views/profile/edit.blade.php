@extends('layouts.app')

@section('content')
@php
    $initials = collect(preg_split('/\s+/', trim($user->name)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');
@endphp

<div class="container il-page">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <span class="il-kicker">Edition du profil</span>
                            <h1 class="mt-2 mb-2 fw-bold">Affinez votre présence dans IntraLink</h1>
                            <p class="il-text-muted mb-0">
                                Mettez à jour vos informations personnelles et professionnelles pour rendre le réseau plus clair pour vos collègues.
                            </p>
                        </div>
                        <a href="{{ route('profile.show') }}" class="btn il-btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i> Retour au profil
                        </a>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger border-0 mx-4 mt-3">
                        <strong>Certains champs doivent être corrigés.</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Avatar -->
                        <div class="row g-4 align-items-center mb-4 pb-2 border-bottom">
                            <div class="col-md-3 text-center text-md-start">
                                @if($user->avatar_path)
                                    <img src="{{ asset('storage/'.$user->avatar_path) }}" alt="{{ $user->name }}" class="rounded-circle" width="100" height="100" style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-gradient-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; font-size: 36px; font-weight: 600;">
                                        {{ $initials }}
                                    </div>
                                @endif
                                <p class="small text-muted mt-2 mb-0">Photo affichée sur le fil, le profil et les commentaires.</p>
                            </div>

                            <div class="col-md-9">
                                <div class="form-group mb-0">
                                    <label for="avatar" class="form-label fw-semibold">Photo de profil</label>
                                    <input id="avatar" type="file" name="avatar" class="form-control" accept="image/*">
                                    <div class="form-text small">Formats acceptés : jpg, jpeg, png, webp. Taille maximale : 2 Mo.</div>
                                </div>
                            </div>
                        </div>

                        <!-- Informations personnelles -->
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label fw-semibold">Nom complet</label>
                                    <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="form-label fw-semibold">Téléphone</label>
                                    <input id="phone" type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="+228 XX XX XX XX">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="position_id" class="form-label fw-semibold">Poste</label>
                                    <select id="position_id" name="position_id" class="form-select">
                                        <option value="">Sélectionnez un poste</option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}" {{ old('position_id', $user->position_id) == $position->id ? 'selected' : '' }}>
                                                {{ $position->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="departement_id" class="form-label fw-semibold">Département</label>
                                    <select id="departement_id" name="departement_id" class="form-select">
                                        <option value="">Sélectionnez un département</option>
                                        @foreach($departements as $departement)
                                            <option value="{{ $departement->id }}" {{ old('departement_id', $user->departement_id) == $departement->id ? 'selected' : '' }}>
                                                {{ $departement->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="location" class="form-label fw-semibold">Localisation</label>
                                    <input id="location" type="text" name="location" class="form-control" value="{{ old('location', $user->location) }}" placeholder="Ville, site ou pays">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="bio" class="form-label fw-semibold">Bio</label>
                                    <textarea id="bio" name="bio" rows="4" class="form-control" placeholder="Quelques lignes pour vous présenter...">{{ old('bio', $user->bio) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-end mt-4 pt-3 border-top">
                            <a href="{{ route('profile.show') }}" class="btn il-btn-secondary px-4 py-2">Annuler</a>
                            <button type="submit" class="btn il-btn-primary px-4 py-2">
                                <i class="fas fa-save me-2"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
</style>
@endsection
