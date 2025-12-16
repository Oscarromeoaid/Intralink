@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    :root {
        --bg-dark: #050505;
        --accent: #0071e3;
        --glass: rgba(255, 255, 255, 0.02);
    }

    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        background-color: var(--bg-dark);
        font-family: 'Plus Jakarta Sans', sans-serif;
        overflow: hidden;
    }

    .split-screen {
        display: flex;
        flex-direction: row;
        height: 100vh;
        width: 100%;
    }

    /* Partie Gauche - Visuelle */
    .left-side {
        flex: 1.2;
        background: linear-gradient(135deg, rgba(0, 113, 227, 0.2) 0%, rgba(134, 34, 255, 0.1) 100%), 
                    url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&q=80');
        background-size: cover;
        background-position: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 80px;
        position: relative;
    }

    .left-side::after {
        content: "";
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at center, transparent, var(--bg-dark));
    }

    .left-content {
        position: relative;
        z-index: 2;
    }

    .left-content h1 {
        font-size: 4rem;
        font-weight: 800;
        letter-spacing: -2px;
        line-height: 1;
        margin-bottom: 20px;
        background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Partie Droite - Formulaire */
    .right-side {
        flex: 1;
        background: var(--bg-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        border-left: 1px solid rgba(255,255,255,0.05);
    }

    .register-box {
        width: 100%;
        max-width: 450px;
    }

    .input-group-custom {
        margin-bottom: 20px;
    }

    .input-group-custom label {
        display: block;
        color: #86868b;
        font-size: 0.9rem;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .input-field {
        width: 100%;
        background: #121212;
        border: 1px solid #333;
        border-radius: 12px;
        padding: 16px;
        color: white;
        transition: 0.3s;
        font-size: 1rem;
    }

    .input-field:focus {
        border-color: var(--accent);
        background: #1a1a1a;
        outline: none;
        box-shadow: 0 0 0 4px rgba(0, 113, 227, 0.1);
    }

    .password-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 20px;
    }

    .btn-register {
        width: 100%;
        padding: 16px;
        background: white;
        color: black;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        margin-top: 20px;
        transition: 0.3s;
    }

    .btn-register:hover {
        background: #e0e0e0;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(255,255,255,0.2);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .left-side { display: none; }
        .right-side { flex: 1; padding: 30px; }
        .password-row { grid-template-columns: 1fr; gap: 20px; }
    }
</style>

<div class="split-screen">
    <div class="left-side">
        <div class="left-content">
            <div class="mb-5">
                <span style="font-size: 2rem; font-weight: 800; color: #fff;">Intra<span style="color: var(--accent);">Link.</span></span>
            </div>
            <h1>Rejoignez <br>le réseau <br>interne.</h1>
            <p style="color: #86868b; font-size: 1.2rem; max-width: 400px;">
                Créez votre profil collaborateur et connectez-vous instantanément à vos équipes, projets et collègues.
            </p>
        </div>
    </div>

    <div class="right-side">
        <div class="register-box">
            <h2 class="fw-bold mb-4" style="font-size: 2rem; color: white;">Inscription</h2>
            <p class="text-secondary mb-4" style="font-size: 1.05rem;">Créez votre compte en 30 secondes</p>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="input-group-custom">
                    <label>Nom complet</label>
                    <input type="text" name="name" class="input-field @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus placeholder="Ex: Marie Dupont">
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="input-group-custom">
                    <label>Email professionnel</label>
                    <input type="email" name="email" class="input-field @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="marie.dupont@entreprise.com">
                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="password-row">
                    <div class="input-group-custom">
                        <label>Mot de passe</label>
                        <input type="password" name="password" class="input-field @error('password') is-invalid @enderror" required placeholder="••••••••">
                    </div>
                    <div class="input-group-custom">
                        <label>Confirmation</label>
                        <input type="password" name="password_confirmation" class="input-field" required placeholder="••••••••">
                    </div>
                </div>
                @error('password') <span class="text-danger small">{{ $message }}</span> @enderror

                <button type="submit" class="btn-register">Créer mon compte</button>

                <p class="text-center mt-4 text-secondary small">
                    Déjà un compte ? <a href="{{ route('login') }}" class="text-white text-decoration-none fw-bold">Se connecter</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
