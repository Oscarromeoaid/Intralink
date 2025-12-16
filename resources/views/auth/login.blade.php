@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    :root {
        --bg-dark: #050505;
        --accent: #10b981; /* Vert Émeraude pour la connexion */
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

    /* Partie Gauche - Visuelle (Même image, ambiance différente) */
    .left-side {
        flex: 1.2;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(6, 182, 212, 0.1) 100%), 
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
        color: white;
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
        overflow-y: auto;
    }

    .login-box {
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
        padding: 14px;
        color: white;
        transition: 0.3s;
    }

    .input-field:focus {
        border-color: var(--accent);
        background: #1a1a1a;
        outline: none;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    .btn-submit {
        width: 100%;
        padding: 16px;
        background: white;
        color: black;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        margin-top: 10px;
        transition: 0.3s;
    }

    .btn-submit:hover {
        background: #e0e0e0;
        transform: translateY(-2px);
    }

    @media (max-width: 992px) {
        .left-side { display: none; }
        .right-side { flex: 1; }
    }
</style>

<div class="split-screen">
    <div class="left-side">
        <div class="left-content">
            <div class="mb-5">
                <a href="/" style="text-decoration: none;">
                    <span style="font-size: 2rem; font-weight: 800; color: #fff;">Intra<span style="color: var(--accent);">Link.</span></span>
                </a>
            </div>
            <h1>Connectez-vous <br>à votre <br>réseau.</h1>
            <p style="color: #86868b; font-size: 1.2rem; max-width: 400px;">
                Accédez instantanément à vos équipes, projets et collègues IntraLink.
            </p>
        </div>
    </div>

    <div class="right-side">
        <div class="login-box">
            <h2 class="fw-bold mb-2">Connexion</h2>
            <p class="text-secondary small mb-4">Accédez à votre espace personnel IntraLink.</p>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="input-group-custom">
                    <label>Adresse email professionnelle</label>
                    <input type="email" name="email" class="input-field @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="nom@entreprise.com">
                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="input-group-custom">
                    <div class="d-flex justify-content-between">
                        <label>Mot de passe</label>
                        <a href="{{ route('password.request') }}" class="small text-decoration-none" style="color: var(--accent);">Oublié ?</a>
                    </div>
                    <input type="password" name="password" class="input-field @error('password') is-invalid @enderror" required placeholder="••••••••">
                    @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small text-secondary" for="remember">Rester connecté</label>
                </div>

                <button type="submit" class="btn-submit">Se connecter au réseau</button>

                <p class="text-center mt-4 text-secondary small">
                    Nouveau collaborateur ? <a href="{{ route('register') }}" class="text-white text-decoration-none fw-bold">Créer un compte</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
