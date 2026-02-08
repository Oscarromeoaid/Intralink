@extends('layouts.app')

@section('content')

{{-- === Styles UI Profil Vue Moderne === --}}
<style>
  :root {
    --primary-gradient: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    --success-gradient: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);
    --primary-color: #1e40af;
    --primary-hover: #1e3a8a;
    --success-color: #3b82f6;
    --bg-main: #ffffff;
    --bg-card: #ffffff;
    --bg-light: #f0f9ff;
    --border-color: #e0e7ff;
    --text-primary: #1e293b;
    --text-secondary: #475569;
    --text-muted: #94a3b8;
    --shadow-sm: 0 2px 8px rgba(30, 64, 175, 0.08);
    --shadow-md: 0 4px 16px rgba(30, 64, 175, 0.12);
    --shadow-lg: 0 8px 24px rgba(30, 64, 175, 0.16);
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  body {
    background: var(--bg-main);
  }

  /* === Container === */
  .profile-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem 1rem;
  }

  /* === Success Alert === */
  .alert-success-custom {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border: 2px solid #93c5fd;
    border-radius: var(--radius-lg);
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
    color: #1e40af;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    animation: slideDown 0.4s ease-out;
  }

  /* === Profile Header === */
  .profile-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    border-radius: var(--radius-lg);
    padding: 2.5rem;
    margin-bottom: 2rem;
    color: #fff;
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
    animation: fadeIn 0.5s ease-out;
  }

  .profile-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    z-index: 0;
  }

  .profile-header::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -5%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
    z-index: 0;
  }

  .profile-header-content {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 2rem;
  }

  .profile-avatar-large {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    transition: var(--transition);
  }

  .profile-avatar-large:hover {
    transform: scale(1.05);
    border-color: rgba(255, 255, 255, 0.5);
  }

  .profile-header-info {
    flex: 1;
  }

  .profile-name {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .profile-title {
    font-size: 1.125rem;
    opacity: 0.95;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .profile-badge {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    padding: 0.375rem 1rem;
    border-radius: var(--radius-xl);
    font-size: 0.875rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-edit-profile {
    background: rgba(255, 255, 255, 0.95);
    color: #1e40af;
    border: none;
    padding: 0.75rem 1.75rem;
    border-radius: var(--radius-md);
    font-weight: 700;
    font-size: 0.9375rem;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(30, 64, 175, 0.2);
  }

  .btn-edit-profile:hover {
    background: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(30, 64, 175, 0.3);
    color: #1e3a8a;
  }

  /* === Info Card === */
  .info-card {
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    animation: fadeIn 0.6s ease-out;
  }

  .info-section {
    margin-bottom: 1.5rem;
  }

  .info-section:last-child {
    margin-bottom: 0;
  }

  .info-label {
    font-weight: 700;
    color: var(--text-secondary);
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .info-value {
    color: var(--text-primary);
    font-size: 1rem;
    line-height: 1.6;
  }

  .info-icon {
    color: var(--primary-color);
  }

  /* === Section Header === */
  .section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--border-color);
  }

  .section-title {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .section-count {
    background: var(--primary-gradient);
    color: #fff;
    padding: 0.25rem 0.875rem;
    border-radius: var(--radius-xl);
    font-size: 0.875rem;
    font-weight: 700;
  }

  /* === Post Card === */
  .post-card {
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    padding: 1.75rem;
    margin-bottom: 1.25rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-color);
    transition: var(--transition);
    animation: fadeIn 0.4s ease-out;
  }

  .post-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
  }

  .post-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
  }

  .post-date {
    color: var(--text-muted);
    font-size: 0.875rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.375rem;
  }

  .post-content {
    color: var(--text-secondary);
    font-size: 0.9375rem;
    line-height: 1.7;
    white-space: pre-wrap;
    margin-bottom: 1rem;
  }

  .post-stats {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
  }

  .stat-item {
    color: var(--text-muted);
    font-size: 0.875rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.375rem;
    transition: var(--transition);
    cursor: pointer;
  }

  .stat-item:hover {
    color: var(--primary-color);
  }

  .stat-item svg {
    transition: var(--transition);
  }

  .stat-item:hover svg {
    transform: scale(1.1);
  }

  /* === Empty State === */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    border: 2px dashed var(--border-color);
  }

  .empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.4;
  }

  .empty-state-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
  }

  .empty-state-text {
    color: var(--text-muted);
    font-size: 0.9375rem;
  }

  /* === Divider === */
  .section-divider {
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--border-color), transparent);
    margin: 2.5rem 0;
    border: none;
  }

  /* === Animations === */
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* === Responsive === */
  @media (max-width: 768px) {
    .profile-container {
      padding: 1rem 0.75rem;
    }

    .profile-header {
      padding: 1.75rem;
    }

    .profile-header-content {
      flex-direction: column;
      text-align: center;
      gap: 1.5rem;
    }

    .profile-avatar-large {
      width: 100px;
      height: 100px;
    }

    .profile-name {
      font-size: 1.5rem;
    }

    .profile-title {
      justify-content: center;
    }

    .info-card {
      padding: 1.5rem;
    }

    .post-card {
      padding: 1.25rem;
    }

    .section-header {
      flex-direction: column;
      align-items: flex-start;
      gap: 0.75rem;
    }
  }
</style>

<div class="profile-container">

  {{-- Success Message --}}
  @if(session('success'))
    <div class="alert-success-custom">
      <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
      </svg>
      {{ session('success') }}
    </div>
  @endif
{{-- Profile Header --}}

<div class="profile-header">
    <div class="profile-header-content">
        <img
            src="{{ $user->avatar_path ? asset('storage/'.$user->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=1e40af&color=ffffff&size=240&bold=true' }}"
            alt="{{ $user->name }}"
            class="profile-avatar-large"
        >
        <div class="profile-header-info">
            <h1 class="profile-name">{{ $user->name }}</h1>
            <div class="profile-title">
    @php
        // Récupère manuellement les données
        $position = $user->position_id ? \App\Models\Position::find($user->position_id) : null;
        $departement = $user->departement_id ? \App\Models\Departement::find($user->departement_id) : null;
    @endphp
    
    @if($position || $departement)
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
            <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
        </svg>
        {{ $position?->title ?? 'Poste non renseigné' }} • {{ $departement?->name ?? 'Département non renseigné' }}
    @else
        <span class="profile-badge">
            ✨ Membre de la communauté
        </span>
    @endif
</div>
            <a href="{{ route('profile.edit') }}" class="btn-edit-profile">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                </svg>
                Modifier mon profil
            </a>
        </div>
    </div>
</div>
  {{-- Info Card --}}
  <div class="info-card">
    <div class="row">
      <div class="col-md-6">
        <div class="info-section">
          <div class="info-label">
            <svg width="16" height="16" fill="currentColor" class="info-icon" viewBox="0 0 16 16">
              <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
            </svg>
            Email
          </div>
          <div class="info-value">{{ $user->email }}</div>
        </div>

        <div class="info-section">
          <div class="info-label">
            <svg width="16" height="16" fill="currentColor" class="info-icon" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
            </svg>
            Téléphone
          </div>
          <div class="info-value">{{ $user->phone ?? 'Non renseigné' }}</div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="info-section">
          <div class="info-label">
            <svg width="16" height="16" fill="currentColor" class="info-icon" viewBox="0 0 16 16">
              <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
            </svg>
            Localisation
          </div>
          <div class="info-value">{{ $user->location ?? 'Non renseigné' }}</div>
        </div>

        <div class="info-section">
          <div class="info-label">
            <svg width="16" height="16" fill="currentColor" class="info-icon" viewBox="0 0 16 16">
              <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
              <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
            </svg>
            Bio
          </div>
          <div class="info-value">{{ $user->bio ?? 'Aucune bio ajoutée pour le moment.' }}</div>
        </div>
      </div>
    </div>
  </div>

  {{-- Divider --}}
  <hr class="section-divider">

  {{-- Posts Section --}}
  <div class="section-header">
    <h2 class="section-title">
      <svg width="28" height="28" fill="currentColor" style="color: var(--primary-color);" viewBox="0 0 16 16">
        <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
        <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z"/>
      </svg>
      Mes publications
    </h2>
    @if($posts->count() > 0)
      <span class="section-count">{{ $posts->count() }}</span>
    @endif
  </div>

  {{-- Posts List --}}
  @forelse($posts as $post)
    <div class="post-card">
      <div class="post-header">
        <div class="post-date">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
          </svg>
          {{ $post->created_at->diffForHumans() }}
        </div>
      </div>

      <div class="post-content">{{ $post->content }}</div>

      <div class="post-stats">
        <div class="stat-item">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
          </svg>
          <strong>{{ $post->likes_count }}</strong> J'aime
        </div>
        <div class="stat-item">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
            <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
          </svg>
          <strong>{{ $post->comments_count }}</strong> Commentaires
        </div>
      </div>
    </div>
  @empty
    <div class="empty-state">
      <div class="empty-state-icon">📝</div>
      <h3 class="empty-state-title">Aucune publication</h3>
      <p class="empty-state-text">Vous n'avez pas encore partagé de publications. Commencez à partager vos idées avec la communauté !</p>
    </div>
  @endforelse

</div>

@endsection