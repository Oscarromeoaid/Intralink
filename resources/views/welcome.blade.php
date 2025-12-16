@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Outfit:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    :root {
        --bg-black: #050505;
        --accent-blue: #0071e3;
        --accent-purple: #8622ff;
        --text-gray: #a1a1a6;
        --glass: rgba(255, 255, 255, 0.03);
        --border-glass: rgba(255, 255, 255, 0.08);
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--bg-black);
        color: #ffffff;
        overflow-x: hidden;
    }

    .bg-visual {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at 80% 20%, #1a1a2e 0%, var(--bg-black) 60%);
        z-index: -1;
    }

    /* Hero Section */
    .hero {
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding-top: 100px;
    }

    .hero h1 {
        font-family: 'Outfit', sans-serif;
        font-size: clamp(2.5rem, 8vw, 5rem);
        font-weight: 800;
        letter-spacing: -0.03em;
        line-height: 1;
        background: linear-gradient(180deg, #fff 30%, rgba(255,255,255,0.5) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Stats Bar */
    .stats-bar {
        background: var(--glass);
        border-top: 1px solid var(--border-glass);
        border-bottom: 1px solid var(--border-glass);
        padding: 30px 0;
        backdrop-filter: blur(10px);
    }

    /* Chic Cards */
    .feature-box {
        background: var(--glass);
        border: 1px solid var(--border-glass);
        border-radius: 30px;
        padding: 40px;
        height: 100%;
        transition: 0.4s;
    }

    .feature-box:hover {
        background: rgba(255,255,255,0.06);
        border-color: var(--accent-blue);
    }

    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 1.5rem;
    }

    .btn-ultra {
        padding: 16px 35px;
        border-radius: 50px;
        font-weight: 600;
        transition: 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-white { background: #fff; color: #000; }
    .btn-white:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(255,255,255,0.2); }

    .reveal { opacity: 0; transform: translateY(30px); transition: 1s all ease; }
    .reveal.active { opacity: 1; transform: translateY(0); }
</style>

<div class="bg-visual"></div>

<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="reveal active">
                    <span class="badge rounded-pill mb-4" style="border: 1px solid var(--accent-blue); color: var(--accent-blue); padding: 10px 20px;">
                        ✨ Nouveau : IntraLink v2.0 est disponible
                    </span>
                    <h1>L'intelligence collective, <br>enfin connectée.</h1>
                    <p class="lead mt-4 text-gray" style="max-width: 600px; font-size: 1.25rem;">
                        Bienvenue sur <strong>IntraLink</strong>, le réseau social privé conçu pour les entreprises modernes. 
                        Brisez les barrières de la communication et unifiez vos collaborateurs dans un espace sécurisé.
                    </p>
                    <div class="mt-5">
                        <a href="{{ route('register') }}" class="btn-ultra btn-white me-3">Déployer pour mon équipe</a>
                        <a href="{{ route('login') }}" class="btn-ultra" style="color: #fff; border: 1px solid var(--border-glass);">Se connecter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="stats-bar my-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <h3 class="fw-bold mb-0">100%</h3>
                <p class="text-gray mb-0">Sécurisé & Privé</p>
            </div>
            <div class="col-md-4">
                <h3 class="fw-bold mb-0">Zéro</h3>
                <p class="text-gray mb-0">Emails Inutiles</p>
            </div>
            <div class="col-md-4">
                <h3 class="fw-bold mb-0">Temps Réel</h3>
                <p class="text-gray mb-0">Synchronisation Totale</p>
            </div>
        </div>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <h2 class="display-5 fw-bold">Un espace, infinies possibilités.</h2>
            <p class="text-gray">IntraLink centralise tout ce dont vos employés ont besoin.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-box reveal">
                    <div class="icon-circle"><i class="bi bi-people"></i></div>
                    <h4>Flux d'actualités</h4>
                    <p class="text-gray small">Suivez les annonces officielles et les succès de vos collègues en un coup d'œil.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-box reveal">
                    <div class="icon-circle"><i class="bi bi-chat-dots"></i></div>
                    <h4>Chat d'équipe</h4>
                    <p class="text-gray small">Messagerie instantanée pour des échanges rapides et fluides sans sortir du contexte.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-box reveal">
                    <div class="icon-circle"><i class="bi bi-folder2-open"></i></div>
                    <h4>Espace Documentaire</h4>
                    <p class="text-gray small">Centralisez vos documents de référence et procédures pour un accès universel.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-box reveal">
                    <div class="icon-circle"><i class="bi bi-person-lines-fill"></i></div>
                    <h4>Annuaire Collaboratif</h4>
                    <p class="text-gray small">Retrouvez facilement les expertises internes et contactez les bons interlocuteurs.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="margin-top: 100px;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 reveal">
                <h2 class="display-6 fw-bold mb-4">Pourquoi IntraLink ?</h2>
                <p class="text-gray">
                    Dans une ère de travail hybride, maintenir le lien social et la culture d'entreprise est un défi. 
                    <strong>IntraLink</strong> a été créé pour transformer votre organisation en une communauté vibrante.
                </p>
                <ul class="list-unstyled mt-4">
                    <li class="mb-3 text-gray"><i class="bi bi-check2-circle text-primary me-2"></i> Réduction du sentiment d'isolement</li>
                    <li class="mb-3 text-gray"><i class="bi bi-check2-circle text-primary me-2"></i> Partage instantané de la connaissance</li>
                    <li class="mb-3 text-gray"><i class="bi bi-check2-circle text-primary me-2"></i> Valorisation des initiatives individuelles</li>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="reveal" style="background: linear-gradient(135deg, #121212, #1a1a2e); border-radius: 40px; padding: 50px; border: 1px solid var(--border-glass);">
                    <div class="text-center">
                        <i class="bi bi-quote display-1 text-primary opacity-25"></i>
                        <p class="fst-italic lead">"Depuis que nous utilisons IntraLink, la cohésion de nos équipes à distance a augmenté de 40%."</p>
                        <hr class="w-25 mx-auto my-4 opacity-25">
                        <p class="fw-bold mb-0">Direction des Ressources Humaines</p>
                        <p class="small text-gray">Groupe Innovation Co.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 my-5 text-center">
    <div class="container py-5">
        <div class="reveal">
            <h2 class="display-4 fw-bold mb-4">Prêt à unifier vos équipes ?</h2>
            <p class="text-gray mb-5">Rejoignez l'aventure IntraLink et redonnez du sens à votre collaboration.</p>
            <a href="{{ route('register') }}" class="btn-ultra btn-white">Créer votre réseau maintenant</a>
        </div>
    </div>
</section>

<script>
    const revealElements = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    revealElements.forEach(el => observer.observe(el));
</script>

@endsection