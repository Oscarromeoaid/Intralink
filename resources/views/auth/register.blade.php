@extends('layouts.app')

@section('hide_nav', true)
@section('body_class', 'auth-page')
@section('main_class', 'p-0')

@section('content')
<div class="il-auth-shell">
    <section class="il-auth-showcase">
        <div class="il-auth-stage">
            <div>
                <a href="{{ url('/') }}" class="il-auth-logo mb-5">
                    <img src="{{ asset('images/intralink-logo.png') }}" alt="IntraLink">
                    <span>
                        <strong class="d-block fs-4">IntraLink</strong>
                        <span class="text-white-50">Connecter les equipes avec style</span>
                    </span>
                </a>

                <span class="il-kicker text-white-50">Bienvenue</span>
                <h1 class="il-heading mt-3">Installez une presence claire dans le reseau interne.</h1>
                <p class="il-lead mt-4 text-white-50">
                    Creez votre compte, completez votre profil et partagez vos informations dans un espace plus premium et plus lisible.
                </p>
            </div>

            <div class="il-auth-points">
                <div class="il-auth-point">
                    <strong>Profil valorise</strong>
                    <span class="text-white-50">Mettez en avant votre role, votre departement et vos infos utiles.</span>
                </div>
                <div class="il-auth-point">
                    <strong>Publication rapide</strong>
                    <span class="text-white-50">Diffusez une information ou une actualite en quelques secondes.</span>
                </div>
                <div class="il-auth-point">
                    <strong>Conversation contextualisee</strong>
                    <span class="text-white-50">Reponses, likes et detail de post restent organises.</span>
                </div>
            </div>
        </div>
    </section>

    <section class="il-auth-form-wrap">
        <div class="il-auth-form">
            <span class="il-kicker">Inscription</span>
            <h2 class="mt-3 mb-2 fw-bold">Creer votre compte</h2>
            <p class="il-text-muted mb-4">Entrez vos informations de base pour rejoindre le reseau.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nom complet</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        placeholder="Marie Dupont"
                    >
                    @error('name')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email professionnel</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        required
                        placeholder="marie.dupont@entreprise.com"
                    >
                    @error('email')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                            placeholder="Minimum 8 caracteres"
                        >
                    </div>
                    <div class="col-md-6">
                        <label for="password-confirm" class="form-label">Confirmation</label>
                        <input
                            id="password-confirm"
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            required
                            placeholder="Repetez le mot de passe"
                        >
                    </div>
                </div>

                @error('password')
                    <span class="invalid-feedback d-block mt-2">{{ $message }}</span>
                @enderror

                <button type="submit" class="btn il-btn-primary w-100 py-3 mt-4">Creer mon compte</button>
            </form>

            <div class="mt-4 pt-3 border-top">
                <p class="mb-0 il-text-muted">
                    Vous avez deja un compte ?
                    <a href="{{ route('login') }}" class="il-comment-link">Se connecter</a>
                </p>
            </div>
        </div>
    </section>
</div>
@endsection
