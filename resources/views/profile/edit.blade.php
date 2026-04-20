@extends('layouts.app')

@section('content')
@php
    $initials = collect(preg_split('/\s+/', trim($user->name)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');
@endphp

<div class="container il-page" style="max-width: 960px;">
    <section class="il-profile-hero mb-4">
        <div class="d-flex justify-content-between align-items-start gap-4 flex-wrap position-relative">
            <div>
                <span class="il-kicker">Edition du profil</span>
                <h1 class="mt-3 mb-2 fw-bold">Affinez votre presence dans IntraLink.</h1>
                <p class="il-lead mb-0">
                    Mettez a jour vos informations personnelles et professionnelles pour rendre le reseau plus clair pour vos collegues.
                </p>
            </div>
            <a href="{{ route('profile.show') }}" class="btn il-btn-secondary px-4 py-3">Retour au profil</a>
        </div>
    </section>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <strong>Certains champs doivent etre corriges.</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card il-form-card">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4 align-items-center mb-4">
                <div class="col-lg-4">
                    <div class="text-center text-lg-start">
                        @if($user->avatar_path)
                            <img src="{{ asset('storage/'.$user->avatar_path) }}" alt="{{ $user->name }}" class="il-avatar-hero mb-3">
                        @else
                            <div class="il-avatar-hero il-avatar-placeholder mb-3">{{ $initials }}</div>
                        @endif
                        <p class="il-meta mb-0">Photo affichee sur le fil, le profil et les commentaires.</p>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="il-grid">
                        <div class="form-group">
                            <label for="avatar" class="form-label fw-bold">Photo de profil</label>
                            <input id="avatar" type="file" name="avatar" class="form-control" accept="image/*">
                            <div class="form-text">Formats acceptes : jpg, jpeg, png, webp. Taille maximale : 2 Mo.</div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="il-divider">

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" class="form-label fw-bold">Nom complet</label>
                        <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone" class="form-label fw-bold">Telephone</label>
                        <input id="phone" type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="+228 XX XX XX XX">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="position_id" class="form-label fw-bold">Poste</label>
                        <select id="position_id" name="position_id" class="form-select">
                            <option value="">Selectionnez un poste</option>
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
                        <label for="departement_id" class="form-label fw-bold">Departement</label>
                        <select id="departement_id" name="departement_id" class="form-select">
                            <option value="">Selectionnez un departement</option>
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
                        <label for="location" class="form-label fw-bold">Localisation</label>
                        <input id="location" type="text" name="location" class="form-control" value="{{ old('location', $user->location) }}" placeholder="Ville, site ou pays">
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group mb-0">
                        <label for="bio" class="form-label fw-bold">Bio</label>
                        <textarea id="bio" name="bio" rows="5" class="form-control" placeholder="Quelques lignes pour vous presenter.">{{ old('bio', $user->bio) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-3 justify-content-end mt-4 pt-4 border-top">
                <a href="{{ route('profile.show') }}" class="btn il-btn-secondary px-4 py-3">Annuler</a>
                <button type="submit" class="btn il-btn-primary px-4 py-3">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</div>
@endsection
