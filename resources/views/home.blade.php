@extends('layouts.app')

@section('content')

{{-- === Styles UI Feed Professionnel === --}}
<style>
  :root {
    --primary-color: #1a73e8;
    --primary-hover: #1557b0;
    --danger-color: #dc3545;
    --bg-light: #f8f9fa;
    --border-color: #e1e4e8;
    --text-muted: #6c757d;
    --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
    --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
    --transition: all 0.2s ease;
  }

  .card { 
    border: 1px solid var(--border-color);
    border-radius: 12px;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    background: #fff;
  }
  
  .card:hover {
    box-shadow: var(--shadow-md);
  }

  .btn, .form-control { 
    border-radius: 8px;
    transition: var(--transition);
  }
  
  .btn-primary-custom {
    background: var(--primary-color);
    border: none;
    color: #fff;
    font-weight: 500;
    padding: 0.5rem 1.5rem;
  }
  
  .btn-primary-custom:hover {
    background: var(--primary-hover);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(26,115,232,0.3);
  }

  .feed-avatar { 
    width: 48px;
    height: 48px;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  
  .comment-avatar { 
    width: 32px;
    height: 32px;
    object-fit: cover;
    border: 2px solid #fff;
  }
  
  .muted { 
    color: var(--text-muted);
    font-size: 0.875rem;
  }
  
  .post-media { 
    border-radius: 12px;
    overflow: hidden;
    background: var(--bg-light);
  }
  
  .post-media img, .post-media video {
    width: 100%;
    display: block;
  }

  .media-upload-section {
    border: 2px dashed var(--border-color);
    border-radius: 8px;
    padding: 1rem;
    background: var(--bg-light);
    transition: var(--transition);
    cursor: pointer;
  }
  
  .media-upload-section:hover {
    border-color: var(--primary-color);
    background: #f0f7ff;
  }

  .media-upload-section input[type="file"] {
    border: none;
    background: transparent;
    font-size: 0.875rem;
  }

  .action-btn {
    border-radius: 20px;
    padding: 0.4rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: var(--transition);
  }

  .like-btn {
    background: transparent;
    border: 1px solid var(--border-color);
    color: var(--text-muted);
  }

  .like-btn:hover {
    background: #fff5f5;
    border-color: var(--danger-color);
    color: var(--danger-color);
  }

  .like-btn.liked {
    background: var(--danger-color);
    border-color: var(--danger-color);
    color: #fff;
  }

  .comment-input-wrapper {
    background: var(--bg-light);
    border-radius: 24px;
    padding: 0.25rem;
    display: flex;
    align-items: center;
  }

  .comment-input-wrapper input {
    border: none;
    background: transparent;
    padding: 0.5rem 1rem;
    outline: none;
    box-shadow: none;
  }

  .comment-input-wrapper input:focus {
    box-shadow: none;
  }

  .comment-box {
    background: var(--bg-light);
    border-radius: 16px;
    padding: 0.75rem 1rem;
  }

  .stats-section {
    padding: 0.75rem 0;
    border-top: 1px solid var(--border-color);
    border-bottom: 1px solid var(--border-color);
  }

  .stats-item {
    color: var(--text-muted);
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
  }

  .stats-item:hover {
    color: var(--primary-color);
  }

  .profile-card {
    position: sticky;
    top: 20px;
  }

  .profile-badge {
    background: linear-gradient(135deg, var(--primary-color), #4285f4);
    color: #fff;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
  }

  .post-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .post-content {
    line-height: 1.6;
    color: #212529;
    font-size: 0.95rem;
  }

  .view-more-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.875rem;
    transition: var(--transition);
  }

  .view-more-link:hover {
    color: var(--primary-hover);
    text-decoration: underline;
  }

  .empty-state {
    padding: 4rem 2rem;
    text-align: center;
  }

  .empty-state-icon {
    font-size: 3rem;
    color: var(--border-color);
    margin-bottom: 1rem;
  }

  .create-post-section {
    background: linear-gradient(to right, #f8f9fa, #ffffff);
  }

  textarea.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(26,115,232,0.15);
  }

  @media (max-width: 991px) {
    .profile-card {
      position: relative;
      top: 0;
    }
  }
</style>

<div class="container py-4">
  <div class="row g-4">

    {{-- ===== FEED ===== --}}
    <div class="col-lg-8">

      {{-- Create Post --}}
      <div class="card mb-4 create-post-section">
        <div class="card-body p-4">
          <div class="d-flex align-items-center gap-3 mb-3">
            <img
              src="{{ auth()->user()->avatar_path ? asset('storage/'.auth()->user()->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}"
              class="rounded-circle feed-avatar"
              alt="Avatar"
            >
            <div class="flex-grow-1">
              <h6 class="mb-0 fw-bold">Créer une publication</h6>
              <p class="muted mb-0">Partagez vos idées avec la communauté</p>
            </div>
          </div>

          <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <textarea 
              name="content" 
              class="form-control mb-3" 
              rows="4" 
              required 
              placeholder="Quoi de neuf ? Partagez vos pensées..."
              style="resize: none;"
            >{{ old('content') }}</textarea>

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
              <div class="media-upload-section flex-grow-1">
                <div class="d-flex align-items-center gap-2">
                  <svg width="20" height="20" fill="currentColor" class="text-primary" viewBox="0 0 16 16">
                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                    <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                  </svg>
                  <div>
                    <input 
                      type="file" 
                      name="media" 
                      class="form-control border-0 p-0" 
                      style="box-shadow:none; font-size: 0.875rem;" 
                      accept="image/*,video/*"
                    >
                  </div>
                </div>
              </div>

              <button type="submit" class="btn btn-primary-custom">
                <svg width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16" style="vertical-align: text-top;">
                  <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                </svg>
                Publier
              </button>
            </div>
          </form>
        </div>
      </div>

      {{-- Posts --}}
      @forelse($posts as $post)
        <div class="card mb-4">
          <div class="card-body p-4">

            {{-- Header --}}
            <div class="post-header mb-3">
              <div class="d-flex align-items-center gap-3">
                <img
                  src="{{ $post->user->avatar_path ? asset('storage/'.$post->user->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($post->user->name) }}"
                  class="rounded-circle feed-avatar"
                  alt="{{ $post->user->name }}"
                >
                <div>
                  <h6 class="mb-0 fw-bold">{{ $post->user->name }}</h6>
                  <p class="muted mb-0">{{ $post->created_at->diffForHumans() }}</p>
                </div>
              </div>
            </div>

            {{-- Content --}}
            <div class="post-content mb-3" style="white-space:pre-wrap;">{{ $post->content }}</div>

            {{-- Media --}}
            @if($post->media_path)
              <div class="post-media mb-3">
                @if($post->media_type === 'image')
                  <img src="{{ asset('storage/'.$post->media_path) }}" alt="Post media">
                @else
                  <video controls>
                    <source src="{{ asset('storage/'.$post->media_path) }}" type="{{ $post->media_mime }}">
                  </video>
                @endif
              </div>
            @endif

            {{-- Stats --}}
            <div class="stats-section mb-3">
              <div class="d-flex align-items-center gap-4">
                <span class="stats-item">
                  <svg width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                  </svg>
                  {{ $post->likes->count() }} J'aime
                </span>
                <span class="stats-item">
                  <svg width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                    <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                  </svg>
                  {{ $post->comments->count() }} Commentaires
                </span>
              </div>
            </div>

            {{-- Actions --}}
            <div class="d-flex align-items-center gap-2 mb-3">
              <form method="POST" action="{{ route('posts.like', $post) }}" class="flex-grow-1">
                @csrf
                <button type="submit" class="btn action-btn like-btn w-100 {{ $post->isLikedBy(auth()->user()) ? 'liked' : '' }}">
                  <svg width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                  </svg>
                  {{ $post->isLikedBy(auth()->user()) ? 'J\'aime' : 'J\'aime' }}
                </button>
              </form>
            </div>

            {{-- Comment form --}}
            <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="mb-3">
              @csrf
              <div class="comment-input-wrapper">
                <img
                  src="{{ auth()->user()->avatar_path ? asset('storage/'.auth()->user()->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}"
                  class="rounded-circle comment-avatar me-2"
                  alt="Votre avatar"
                >
                <input 
                  type="text" 
                  name="content" 
                  class="form-control flex-grow-1" 
                  placeholder="Écrire un commentaire…" 
                  required
                >
                <button type="submit" class="btn btn-primary-custom btn-sm ms-2">
                  <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                  </svg>
                </button>
              </div>
            </form>

            {{-- Comments --}}
            @php
              $totalComments = $post->comments->count();
              $visibleComments = $post->comments->take(2);
            @endphp

            @if($totalComments)
              <div>
                {{-- Voir plus --}}
                @if($totalComments > 2)
                  <a href="{{ route('posts.show', $post) }}" class="view-more-link d-inline-block mb-3">
                    Voir tous les {{ $totalComments }} commentaires
                  </a>
                @endif

                {{-- Commentaires visibles --}}
                @foreach($visibleComments as $comment)
                  <div class="d-flex gap-2 mb-2">
                    <img
                      src="{{ $comment->user->avatar_path ? asset('storage/'.$comment->user->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name) }}"
                      class="rounded-circle comment-avatar"
                      alt="{{ $comment->user->name }}"
                    >
                    <div class="comment-box flex-grow-1">
                      <h6 class="mb-1 fw-bold" style="font-size: 0.875rem;">{{ $comment->user->name }}</h6>
                      <p class="mb-0" style="white-space:pre-wrap; font-size: 0.875rem;">{{ $comment->content }}</p>
                      <small class="muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif

          </div>
        </div>
      @empty
        <div class="card">
          <div class="card-body empty-state">
            <div class="empty-state-icon">📭</div>
            <h5 class="fw-bold mb-2">Aucune publication</h5>
            <p class="muted mb-0">Soyez le premier à partager quelque chose avec la communauté !</p>
          </div>
        </div>
      @endforelse

      <div class="mt-4">
        {{ $posts->links() }}
      </div>
    </div>

    {{-- ===== SIDEBAR ===== --}}
    <div class="col-lg-4">
      <div class="card profile-card">
        <div class="card-body p-4">
          <div class="text-center mb-3">
            <img
              src="{{ auth()->user()->avatar_path ? asset('storage/'.auth()->user()->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}"
              class="rounded-circle mb-3"
              style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.15);"
              alt="Votre profil"
            >
            <h5 class="fw-bold mb-1">{{ auth()->user()->name }}</h5>
            <p class="muted mb-2">{{ auth()->user()->email }}</p>
            <span class="profile-badge">Membre actif</span>
          </div>

          <div class="d-grid gap-2 mb-3">
            <a href="{{ route('profile.show') }}" class="btn btn-primary-custom">
              <svg width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16" style="vertical-align: text-top;">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
              </svg>
              Voir mon profil
            </a>
          </div>

          <div class="alert alert-info" style="border-radius: 12px; background: #e7f3ff; border: 1px solid #b3d9ff;">
            <div class="d-flex gap-2">
              <svg width="20" height="20" fill="currentColor" class="text-primary flex-shrink-0" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
              </svg>
              <small class="mb-0">Ajoutez une photo de profil pour améliorer votre visibilité dans la communauté.</small>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection