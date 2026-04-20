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
                        <span class="text-white-50">Le reseau interne des equipes</span>
                    </span>
                </a>

                <span class="il-kicker text-white-50">Connexion securisee</span>
                <h1 class="il-heading mt-3">Retrouvez vos equipes, vos echanges et vos projets.</h1>
                <p class="il-lead mt-4 text-white-50">
                    Un espace plus net pour suivre l'activite interne, publier rapidement et garder chaque conversation dans le bon contexte.
                </p>
            </div>

            <div class="il-auth-points">
                <div class="il-auth-point">
                    <strong>Flux centralise</strong>
                    <span class="text-white-50">Posts, commentaires et profils dans une interface unique.</span>
                </div>
                <div class="il-auth-point">
                    <strong>Identite professionnelle</strong>
                    <span class="text-white-50">Departements, postes et profils enrichis pour mieux se reperer.</span>
                </div>
                <div class="il-auth-point">
                    <strong>Usage simple</strong>
                    <span class="text-white-50">Une experience rapide, lisible et adaptee au quotidien de l'entreprise.</span>
                </div>
            </div>
        </div>
    </section>

    <section class="il-auth-form-wrap">
        <div class="il-auth-form">
            <span class="il-kicker">Espace membre</span>
            <h2 class="mt-3 mb-2 fw-bold">Connexion</h2>
            <p class="il-text-muted mb-4">Accedez a votre espace IntraLink.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="nom@entreprise.com"
                    >
                    @error('email')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label for="password" class="form-label mb-0">Mot de passe</label>
                        <a href="{{ route('password.request') }}" class="il-comment-link">Mot de passe oublie ?</a>
                    </div>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required
                        placeholder="Votre mot de passe"
                    >
                    @error('password')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label il-text-muted" for="remember">Rester connecte</label>
                </div>

                <button type="submit" class="btn il-btn-primary w-100 py-3">Se connecter</button>
            </form>

            <div class="mt-4 pt-3 border-top">
                <p class="mb-0 il-text-muted">
                    Nouveau sur IntraLink ?
                    <a href="{{ route('register') }}" class="il-comment-link">Creer un compte</a>
                </p>
            </div>
        </div>
    </section>
</div>
@endsection
