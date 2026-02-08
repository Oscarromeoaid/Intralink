@extends('layouts.app')

@section('content')

{{-- === Styles UI Profil Moderne === --}}
<style>
  :root {
    --primary-gradient: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    --success-gradient: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);
    --primary-color: #1e40af;
    --primary-hover: #1e3a8a;
    --success-color: #3b82f6;
    --success-hover: #2563eb;
    --danger-color: #ef4444;
    --bg-main: #ffffff;
    --bg-card: #ffffff;
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
  .profile-edit-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem 1rem;
  }

  /* === Header === */
  .page-header {
    margin-bottom: 2rem;
    animation: fadeIn 0.5s ease-out;
  }

  .page-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .page-subtitle {
    color: var(--text-muted);
    font-size: 1rem;
  }

  /* === Alert === */
  .alert-custom {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border: 2px solid #fca5a5;
    border-radius: var(--radius-lg);
    padding: 1.25rem 1.5rem;
    margin-bottom: 2rem;
    animation: slideDown 0.4s ease-out;
  }

  .alert-custom ul {
    margin: 0;
    padding-left: 1.25rem;
  }

  .alert-custom li {
    color: var(--danger-color);
    font-weight: 600;
    font-size: 0.9375rem;
    margin-bottom: 0.5rem;
  }

  .alert-custom li:last-child {
    margin-bottom: 0;
  }

  /* === Form Card === */
  .form-card {
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    padding: 2.5rem;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    animation: fadeIn 0.6s ease-out;
  }

  /* === Form Group === */
  .form-group-custom {
    margin-bottom: 2rem;
  }

  .form-label-custom {
    display: block;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
    font-size: 0.9375rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .label-icon {
    color: var(--primary-color);
  }

  .required-star {
    color: var(--danger-color);
    margin-left: 0.25rem;
  }

  /* === Form Controls === */
  .form-control-custom {
    width: 100%;
    padding: 0.875rem 1.25rem;
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    font-size: 0.9375rem;
    color: var(--text-primary);
    background: var(--bg-main);
    transition: var(--transition);
    font-family: inherit;
  }

  .form-control-custom:focus {
    outline: none;
    border-color: var(--primary-color);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.1);
  }

  .form-control-custom::placeholder {
    color: var(--text-muted);
  }

  textarea.form-control-custom {
    resize: vertical;
    min-height: 120px;
    line-height: 1.6;
  }

  /* === File Input === */
  .file-upload-wrapper {
    position: relative;
  }

  .file-upload-custom {
    width: 100%;
    padding: 1.25rem;
    border: 2px dashed var(--border-color);
    border-radius: var(--radius-md);
    background: var(--bg-main);
    cursor: pointer;
    transition: var(--transition);
    text-align: center;
  }

  .file-upload-custom:hover {
    border-color: var(--primary-color);
    background: rgba(30, 64, 175, 0.05);
  }

  .file-upload-custom input[type="file"] {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
  }

  .file-upload-icon {
    color: var(--primary-color);
    margin-bottom: 0.5rem;
  }

  .file-upload-text {
    color: var(--text-secondary);
    font-weight: 600;
    font-size: 0.9375rem;
    margin-bottom: 0.25rem;
  }

  .file-upload-hint {
    color: var(--text-muted);
    font-size: 0.8125rem;
  }

  /* === Form Text === */
  .form-text-custom {
    display: block;
    margin-top: 0.5rem;
    color: var(--text-muted);
    font-size: 0.8125rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
  }

  /* === Section Divider === */
  .section-divider {
    display: flex;
    align-items: center;
    margin: 2.5rem 0 2rem 0;
    gap: 1rem;
  }

  .section-divider::before,
  .section-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--border-color), transparent);
  }

  .section-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  /* === Buttons === */
  .form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2.5rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border-color);
  }

  .btn-custom {
    padding: 0.875rem 2rem;
    border-radius: var(--radius-md);
    font-size: 0.9375rem;
    font-weight: 700;
    cursor: pointer;
    transition: var(--transition);
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    justify-content: center;
    text-decoration: none;
  }

  .btn-success-custom {
    background: var(--success-gradient);
    color: #fff;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
  }

  .btn-success-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
    color: #fff;
  }

  .btn-success-custom:active {
    transform: translateY(0);
  }

  .btn-secondary-custom {
    background: transparent;
    border: 2px solid var(--border-color);
    color: var(--text-secondary);
  }

  .btn-secondary-custom:hover {
    background: var(--bg-main);
    border-color: var(--text-muted);
    color: var(--text-primary);
    transform: translateY(-2px);
  }

  /* === Avatar Preview === */
  .avatar-preview-section {
    margin-bottom: 2rem;
    text-align: center;
  }

  .current-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: var(--shadow-lg);
    margin-bottom: 1rem;
  }

  .avatar-change-text {
    color: var(--text-muted);
    font-size: 0.875rem;
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
    .profile-edit-container {
      padding: 1rem 0.75rem;
    }

    .form-card {
      padding: 1.5rem;
    }

    .page-title {
      font-size: 1.5rem;
    }

    .form-actions {
      flex-direction: column;
    }

    .btn-custom {
      width: 100%;
    }
  }
  /* Améliore l'apparence des datalist */
input[list] {
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/></svg>');
    background-repeat: no-repeat;
    background-position: right 10px center;
    padding-right: 30px;
}

/* Style pour les suggestions */
datalist option {
    padding: 8px;
    font-size: 0.9rem;
}

/* Surligne les suggestions au survol */
datalist option:hover {
    background-color: var(--primary-color);
    color: white;
}
/* Style pour les selects */
.form-control-custom[multiple],
.form-control-custom[type="file"],
.form-control-custom[type="select"] {
    padding: 0.875rem 1.25rem;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-chevron-down" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/></svg>');
    background-repeat: no-repeat;
    background-position: right 10px center;
    padding-right: 30px;
    appearance: none;
}

/* Style des options */
.form-control-custom option {
    padding: 8px;
    background-color: white;
    color: var(--text-primary);
}

.form-control-custom option:hover {
    background-color: var(--primary-color);
    color: white;
}

/* Style pour les selects au focus */
.form-control-custom:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.1);
}
</style>

<div class="profile-edit-container">
    
    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">
            <svg width="32" height="32" fill="currentColor" style="color: var(--primary-color);" viewBox="0 0 16 16">
                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
            Modifier mon profil
        </h1>
        <p class="page-subtitle">Mettez à jour vos informations personnelles et professionnelles</p>
    </div>

    {{-- Errors --}}
    @if($errors->any())
        <div class="alert-custom">
            <ul>
                @foreach($errors->all() as $err)
                    <li>
                        <svg width="16" height="16" fill="currentColor" style="display: inline; margin-right: 0.5rem;" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                        {{ $err }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <div class="form-card">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Avatar Preview --}}
            @if($user->avatar_path)
            <div class="avatar-preview-section">
                <img 
                    src="{{ asset('storage/'.$user->avatar_path) }}" 
                    alt="Photo actuelle" 
                    class="current-avatar"
                >
                <p class="avatar-change-text">📸 Photo de profil actuelle</p>
            </div>
            @endif

            {{-- Informations personnelles --}}
            <div class="form-group-custom">
                <label class="form-label-custom">
                    <svg width="18" height="18" fill="currentColor" class="label-icon" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                    </svg>
                    Nom complet
                    <span class="required-star">*</span>
                </label>
                <input 
                    class="form-control-custom" 
                    name="name" 
                    value="{{ old('name', $user->name) }}" 
                    required
                    placeholder="Entrez votre nom complet"
                >
            </div>

            {{-- Section: Informations professionnelles --}}
            <div class="section-divider">
                <span class="section-title">
                    <svg width="16" height="16" fill="currentColor" style="margin-right: 0.5rem;" viewBox="0 0 16 16">
                        <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5zm1.886 6.914L15 7.151V12.5a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5V7.15l6.614 1.764a1.5 1.5 0 0 0 .772 0zM1.5 4h13a.5.5 0 0 1 .5.5v1.616L8.129 7.948a.5.5 0 0 1-.258 0L1 6.116V4.5a.5.5 0 0 1 .5-.5z"/>
                    </svg>
                    Informations professionnelles
                </span>
            </div>
{{-- Poste --}}
<div class="col-md-6 form-group-custom">
    <label class="form-label-custom">
        <!-- Icône SVG... -->
        Poste
    </label>
    <select class="form-control-custom" name="position_id">
        <option value="">Sélectionnez un poste</option>
        @foreach($positions as $position)
            <option value="{{ $position->id }}" 
                {{ old('position_id', $user->position_id) == $position->id ? 'selected' : '' }}>
                {{ $position->title }}
            </option>
        @endforeach
    </select>
</div>

{{-- Département --}}
<div class="col-md-6 form-group-custom">
    <label class="form-label-custom">
        <!-- Icône SVG... -->
        Département
    </label>
    <select class="form-control-custom" name="departement_id">
    <option value="">Sélectionnez un département</option>
    @foreach($departements as $department)
        <option value="{{ $department->id }}"
            {{ old('departement_id', $user->departement_id) == $department->id ? 'selected' : '' }}>
            {{ $department->name }}
        </option>
    @endforeach
</select>
</div>
            {{-- Section: Contact --}}
            <div class="section-divider">
                <span class="section-title">
                    <svg width="16" height="16" fill="currentColor" style="margin-right: 0.5rem;" viewBox="0 0 16 16">
                        <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                    </svg>
                    Coordonnées
                </span>
            </div>

            <div class="row">
                <div class="col-md-6 form-group-custom">
                    <label class="form-label-custom">
                        <svg width="18" height="18" fill="currentColor" class="label-icon" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                        </svg>
                        Téléphone
                    </label>
                    <input 
                        class="form-control-custom" 
                        name="phone" 
                        value="{{ old('phone', $user->phone) }}"
                        placeholder="+33 6 12 34 56 78"
                        type="tel"
                    >
                </div>
                <div class="col-md-6 form-group-custom">
                    <label class="form-label-custom">
                        <svg width="18" height="18" fill="currentColor" class="label-icon" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                        </svg>
                        Localisation
                    </label>
                    <input 
                        class="form-control-custom" 
                        name="location" 
                        value="{{ old('location', $user->location) }}"
                        placeholder="Ex: Paris, France"
                    >
                </div>
            </div>

            {{-- Bio --}}
            <div class="form-group-custom">
                <label class="form-label-custom">
                    <svg width="18" height="18" fill="currentColor" class="label-icon" viewBox="0 0 16 16">
                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                        <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                    Bio
                </label>
                <textarea 
                    class="form-control-custom" 
                    name="bio" 
                    rows="4"
                    placeholder="Parlez-nous de vous, vos compétences, vos passions..."
                >{{ old('bio', $user->bio) }}</textarea>
                <span class="form-text-custom">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                    </svg>
                    Une courte description vous aidera à vous présenter à la communauté
                </span>
            </div>

            {{-- Avatar Upload --}}
            <div class="form-group-custom">
                <label class="form-label-custom">
                    <svg width="18" height="18" fill="currentColor" class="label-icon" viewBox="0 0 16 16">
                        <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                        <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                    </svg>
                    Photo de profil
                </label>
                <div class="file-upload-wrapper">
                    <div class="file-upload-custom">
                        <input type="file" name="avatar" accept="image/*">
                        <div class="file-upload-icon">
                            <svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z"/>
                                <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                            </svg>
                        </div>
                        <div class="file-upload-text">Cliquez pour télécharger une photo</div>
                        <div class="file-upload-hint">PNG, JPG, WEBP – max 2MB</div>
                    </div>
                </div>
                <span class="form-text-custom">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                    </svg>
                    Formats acceptés : PNG, JPG, WEBP • Taille maximale : 2 Mo
                </span>
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <button type="submit" class="btn-custom btn-success-custom">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                    </svg>
                    Enregistrer les modifications
                </button>
                <a href="{{ route('profile.show') }}" class="btn-custom btn-secondary-custom">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    Annuler
                </a>
            </div>
        </form>
    </div>

</div>
@push('scripts')
<script>
// Améliore l'expérience des datalist
document.addEventListener('DOMContentLoaded', function() {
    const jobInput = document.querySelector('input[name="job_title"]');
    const deptInput = document.querySelector('input[name="department"]');
    
    // Met en majuscule la première lettre quand l'utilisateur quitte le champ
    [jobInput, deptInput].forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim()) {
                this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1).toLowerCase();
            }
        });
    });
    
    // Permet de sélectionner avec les flèches du clavier
    [jobInput, deptInput].forEach(input => {
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && this.list && this.list.options.length > 0) {
                // Si une option est sélectionnée, la remplir
                const datalist = document.getElementById(this.getAttribute('list'));
                if (datalist && this.value) {
                    const option = Array.from(datalist.options).find(opt => 
                        opt.value.toLowerCase() === this.value.toLowerCase()
                    );
                    if (option) {
                        this.value = option.value;
                    }
                }
            }
        });
    });
});
</script>
@endpush
@endsection