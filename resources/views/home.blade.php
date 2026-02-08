@extends('layouts.app')

@section('content')

{{-- === Styles UI Feed Professionnel Amélioré === --}}
<style>
  :root {
    --primary-color: #1e40af;
    --primary-hover: #1e3a8a;
    --primary-light: #dbeafe;
    --danger-color: #ff3b30;
    --danger-hover: #ff2d1f;
    --success-color: #34c759;
    --bg-main: #ffffff;
    --bg-light: #ffffff;
    --border-color: #e0e7ff;
    --text-primary: #1e293b;
    --text-secondary: #475569;
    --text-muted: #94a3b8;
    --shadow-xs: 0 1px 2px rgba(30,64,175,0.04);
    --shadow-sm: 0 2px 8px rgba(30,64,175,0.06);
    --shadow-md: 0 4px 16px rgba(30,64,175,0.08);
    --shadow-lg: 0 8px 24px rgba(30,64,175,0.12);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;
  }

  body {
    background-color: var(--bg-main);
  }

  /* === Cards === */
  .card { 
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    background: var(--bg-light);
    overflow: hidden;
  }
  
  .card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
  }

  /* === Buttons === */
  .btn { 
    border-radius: var(--radius-md);
    transition: var(--transition);
    font-weight: 600;
    letter-spacing: 0.2px;
  }
  
  .btn-primary-custom {
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    border: none;
    color: #fff;
    padding: 0.625rem 1.75rem;
    box-shadow: 0 4px 12px rgba(30, 64, 175, 0.2);
  }
  
  .btn-primary-custom:hover {
    background: linear-gradient(135deg, #1e3a8a, #2563eb);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(30, 64, 175, 0.35);
  }

  .btn-primary-custom:active {
    transform: translateY(0);
  }

  /* === Avatars === */
  .feed-avatar { 
    width: 48px;
    height: 48px;
    object-fit: cover;
    border: 3px solid #fff;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
  }

  .feed-avatar:hover {
    transform: scale(1.05);
    box-shadow: var(--shadow-md);
  }
  
  .comment-avatar { 
    width: 36px;
    height: 36px;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: var(--shadow-xs);
  }

  .profile-avatar {
    width: 96px;
    height: 96px;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: var(--shadow-lg);
  }
  
  /* === Typography === */
  .muted { 
    color: var(--text-muted);
    font-size: 0.875rem;
  }

  .text-secondary {
    color: var(--text-secondary);
  }
  
  /* === Media === */
  .post-media { 
    border-radius: var(--radius-md);
    overflow: hidden;
    background: var(--bg-main);
    margin: 1rem 0;
  }
  
  .post-media img, .post-media video {
    width: 100%;
    display: block;
    transition: var(--transition);
  }

  .post-media:hover img {
    transform: scale(1.02);
  }

  /* === Upload Section === */
  .media-upload-section {
    border: 2px dashed var(--border-color);
    border-radius: var(--radius-md);
    padding: 1rem;
    background: var(--bg-main);
    transition: var(--transition);
    cursor: pointer;
  }
  
  .media-upload-section:hover {
    border-color: var(--primary-color);
    background: var(--primary-light);
  }

  .media-upload-section input[type="file"] {
    border: none;
    background: transparent;
    font-size: 0.875rem;
  }

  /* === Action Buttons === */
  .action-btn {
    border-radius: 50%;
    width: 44px;
    height: 44px;
    padding: 0;
    font-size: 0.875rem;
    font-weight: 600;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  .like-btn {
    background: transparent;
    border: 2px solid var(--border-color);
    color: var(--text-secondary);
  }

  .like-btn:hover {
    background: #fff5f5;
    border-color: var(--danger-color);
    color: var(--danger-color);
    transform: translateY(-2px) scale(1.05);
  }

  .like-btn.liked {
    background: var(--danger-color);
    border-color: var(--danger-color);
    color: #fff;
    box-shadow: 0 4px 12px rgba(255, 59, 48, 0.25);
  }

  .like-btn.liked:hover {
    background: var(--danger-hover);
    transform: translateY(-2px) scale(1.05);
  }

  /* === Comment Input === */
  .comment-input-wrapper {
    background: var(--bg-main);
    border-radius: var(--radius-xl);
    padding: 0.375rem;
    display: flex;
    align-items: center;
    border: 2px solid transparent;
    transition: var(--transition);
  }

  .comment-input-wrapper:focus-within {
    background: #fff;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px var(--primary-light);
  }

  .comment-input-wrapper input {
    border: none;
    background: transparent;
    padding: 0.5rem 1rem;
    outline: none;
    box-shadow: none;
    font-size: 0.9375rem;
  }

  .comment-input-wrapper input::placeholder {
    color: var(--text-muted);
  }

  .comment-input-wrapper .btn {
    border-radius: 50%;
    width: 36px;
    height: 36px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* === Comment Box === */
  .comment-box {
    background: var(--bg-main);
    border-radius: var(--radius-md);
    padding: 0.875rem 1.125rem;
    transition: var(--transition);
  }

  .comment-box:hover {
    background: #f0f3f7;
  }

  /* === Stats Section === */
  .stats-section {
    padding: 1rem 0;
    border-top: 1px solid var(--border-color);
    border-bottom: 1px solid var(--border-color);
    margin-top: 1rem;
    margin-bottom: 1rem;
  }

  .stats-item {
    color: var(--text-secondary);
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
  }

  .stats-item:hover {
    color: var(--primary-color);
    transform: translateY(-1px);
  }

  .stats-item svg {
    transition: var(--transition);
  }

  .stats-item:hover svg {
    transform: scale(1.1);
  }

  /* === Profile Card === */
  .profile-card {
    position: sticky;
    top: 20px;
  }

  .profile-badge {
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    color: #fff;
    padding: 0.375rem 1rem;
    border-radius: var(--radius-xl);
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
  }

  /* === Post Header === */
  .post-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .post-author-name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.125rem;
  }

  /* === Post Content === */
  .post-content {
    line-height: 1.7;
    color: var(--text-primary);
    font-size: 0.9375rem;
  }

  /* === Links === */
  .view-more-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.875rem;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
  }

  .view-more-link:hover {
    color: var(--primary-hover);
    gap: 0.5rem;
  }

  /* === Empty State === */
  .empty-state {
    padding: 5rem 2rem;
    text-align: center;
  }

  .empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1.5rem;
    opacity: 0.5;
  }

  /* === Create Post Section === */
  .create-post-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border: 2px solid transparent;
    transition: var(--transition);
  }

  .create-post-section:hover {
    border-color: var(--primary-light);
  }

  textarea.form-control {
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    transition: var(--transition);
    font-size: 0.9375rem;
    line-height: 1.6;
  }

  textarea.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px var(--primary-light);
  }

  textarea.form-control::placeholder {
    color: var(--text-muted);
  }

  /* === Info Alert === */
  .alert-info-custom {
    border-radius: var(--radius-md);
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border: 2px solid #93c5fd;
    padding: 1rem;
  }

  /* === Dropdown Menu === */
  .post-menu-btn {
    background: transparent;
    border: none;
    color: var(--text-muted);
    padding: 0.5rem;
    border-radius: 50%;
    transition: var(--transition);
    cursor: pointer;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .post-menu-btn:hover {
    background: var(--bg-main);
    color: var(--text-secondary);
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

  .card {
    animation: fadeIn 0.4s ease-out;
  }

  /* === Pulse Animation for Like === */
  @keyframes pulse {
    0% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.05);
    }
    100% {
      transform: scale(1);
    }
  }

  .like-btn.liked {
    animation: pulse 0.3s ease-out;
  }

  /* === Responsive === */
  @media (max-width: 991px) {
    .profile-card {
      position: relative;
      top: 0;
      margin-bottom: 1.5rem;
    }
  }

  @media (max-width: 576px) {
    .btn-primary-custom {
      padding: 0.5rem 1.25rem;
      font-size: 0.875rem;
    }

    .feed-avatar {
      width: 40px;
      height: 40px;
    }

    .post-content {
      font-size: 0.875rem;
    }
  }

  /* === Scrollbar === */
  ::-webkit-scrollbar {
    width: 8px;
  }

  ::-webkit-scrollbar-track {
    background: var(--bg-main);
  }

  ::-webkit-scrollbar-thumb {
    background: var(--border-color);
    border-radius: 4px;
  }

  ::-webkit-scrollbar-thumb:hover {
    background: var(--text-muted);
  }
  /* === Styles pour les réponses === */
.comment-reply-indent {
  margin-left: 40px;
  border-left: 2px solid var(--border-color);
  padding-left: 12px;
}

.reply-form-mini {
  background: rgba(30, 64, 175, 0.05);
  border-radius: var(--radius-sm);
  padding: 10px;
  margin-top: 8px;
}

.reply-form-mini input {
  font-size: 0.875rem !important;
  height: 32px;
}

.reply-form-mini .btn-sm {
  padding: 4px 12px;
  font-size: 0.8125rem;
}

.reply-link {
  color: var(--primary-color);
  font-size: 0.75rem;
  text-decoration: none;
  cursor: pointer;
}

.reply-link:hover {
  text-decoration: underline;
}
</style>

<div class="container py-4">
  <div class="row g-4">

    {{-- ===== FEED ===== --}}
    <div class="col-lg-8">

      {{-- Create Post --}}
      <div class="card mb-4 create-post-section">
        <div class="card-body p-4">
          <div class="d-flex align-items-center gap-3 mb-4">
            <img
              src="{{ auth()->user()->avatar_path ? asset('storage/'.auth()->user()->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=1e40af&color=fff' }}"
              class="rounded-circle feed-avatar"
              alt="Avatar"
            >
            <div class="flex-grow-1">
              <h5 class="mb-1 fw-bold" style="color: var(--text-primary);">Créer une publication</h5>
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
                  <svg width="22" height="22" fill="currentColor" style="color: var(--primary-color);" viewBox="0 0 16 16">
                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                    <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                  </svg>
                  <div class="flex-grow-1">
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
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
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
                  src="{{ $post->user->avatar_path ? asset('storage/'.$post->user->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($post->user->name).'&background=1e40af&color=fff' }}"
                  class="rounded-circle feed-avatar"
                  alt="{{ $post->user->name }}"
                >
                <div>
                  <h6 class="post-author-name mb-0">{{ $post->user->name }}</h6>
                  <p class="muted mb-0">{{ $post->created_at->diffForHumans() }}</p>
                </div>
              </div>
              <button class="post-menu-btn">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                </svg>
              </button>
            </div>

            {{-- Content --}}
            <div class="post-content mb-3" style="white-space:pre-wrap;">{{ $post->content }}</div>

            {{-- Media --}}
            @if($post->media_path)
              <div class="post-media">
                @if($post->media_type === 'image')
                  <img src="{{ asset('storage/'.$post->media_path) }}" alt="Post media">
                @else
                  <video controls style="border-radius: var(--radius-md);">
                    <source src="{{ asset('storage/'.$post->media_path) }}" type="{{ $post->media_mime }}">
                  </video>
                @endif
              </div>
            @endif

            {{-- Stats --}}
            <div class="stats-section">
              <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-4">
                  <span class="stats-item">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                    </svg>
                    <strong>{{ $post->likes->count() }}</strong> J'aime
                  </span>
                  <span class="stats-item">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                      <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                    </svg>
                    <strong>{{ $post->comments->count() }}</strong> Commentaires
                  </span>
                </div>
                
                {{-- Like Button --}}
                <form method="POST" action="{{ route('posts.like', $post) }}" class="d-inline">
                  @csrf
                  <button type="submit" class="btn action-btn like-btn {{ $post->isLikedBy(auth()->user()) ? 'liked' : '' }}" title="{{ $post->isLikedBy(auth()->user()) ? 'Retirer le J\'aime' : 'J\'aime' }}">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                    </svg>
                  </button>
                </form>
              </div>
            </div>

            {{-- Comment form --}}
            <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="mb-3">
              @csrf
              <div class="comment-input-wrapper">
                <img
                  src="{{ auth()->user()->avatar_path ? asset('storage/'.auth()->user()->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=1e40af&color=fff' }}"
                  class="rounded-circle comment-avatar"
                  alt="Votre avatar"
                >
                <input 
                  type="text" 
                  name="content" 
                  class="form-control flex-grow-1" 
                  placeholder="Écrire un commentaire…" 
                  required
                >
                <button type="submit" class="btn btn-primary-custom">
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
        <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
        </svg>
      </a>
    @endif

    {{-- Commentaires visibles --}}
    @foreach($post->comments->whereNull('parent_id')->take(2) as $comment)
      <div class="d-flex gap-2 mb-3">
        <img
          src="{{ $comment->user->avatar_path ? asset('storage/'.$comment->user->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name).'&background=3b82f6&color=fff' }}"
          class="rounded-circle comment-avatar flex-shrink-0"
          alt="{{ $comment->user->name }}"
        >
        <div class="comment-box flex-grow-1">
          <h6 class="mb-1 fw-bold" style="font-size: 0.875rem; color: var(--text-primary);">{{ $comment->user->name }}</h6>
          <p class="mb-2" style="white-space:pre-wrap; font-size: 0.875rem; color: var(--text-secondary);">{{ $comment->content }}</p>
          <div class="d-flex align-items-center gap-2">
            <small class="muted">{{ $comment->created_at->diffForHumans() }}</small>
            
            {{-- Bouton Répondre --}}
            <button type="button" class="btn btn-link p-0 text-decoration-none" 
                    onclick="showReplyForm({{ $comment->id }}, {{ $post->id }})"
                    style="font-size: 0.75rem;">
              Répondre
            </button>
            
            {{-- Nombre de réponses --}}
            @if($comment->replies->count() > 0)
              <small class="muted">• {{ $comment->replies->count() }} réponse(s)</small>
            @endif
          </div>
          
          {{-- Formulaire de réponse (caché) --}}
          <div id="reply-form-{{ $comment->id }}" class="mt-2" style="display: none;">
            <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="d-flex gap-2">
              @csrf
              <input type="hidden" name="parent_id" value="{{ $comment->id }}">
              <input 
                type="text" 
                name="content" 
                class="form-control form-control-sm" 
                placeholder="Écrire une réponse…" 
                required
                style="font-size: 0.875rem;"
              >
              <button type="submit" class="btn btn-primary btn-sm" style="font-size: 0.875rem;">
                Envoyer
              </button>
              <button type="button" class="btn btn-secondary btn-sm" 
                      onclick="hideReplyForm({{ $comment->id }})" style="font-size: 0.875rem;">
                Annuler
              </button>
            </form>
          </div>
          
          {{-- Afficher les réponses --}}
          @foreach($comment->replies as $reply)
            <div class="d-flex gap-2 mt-2" style="margin-left: 20px;">
              <img
                src="{{ $reply->user->avatar_path ? asset('storage/'.$reply->user->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($reply->user->name).'&background=3b82f6&color=fff' }}"
                class="rounded-circle comment-avatar flex-shrink-0"
                alt="{{ $reply->user->name }}"
                style="width: 28px; height: 28px;"
              >
              <div class="comment-box flex-grow-1">
                <h6 class="mb-1 fw-bold" style="font-size: 0.875rem; color: var(--text-primary);">{{ $reply->user->name }}</h6>
                <p class="mb-2" style="white-space:pre-wrap; font-size: 0.875rem; color: var(--text-secondary);">{{ $reply->content }}</p>
                <small class="muted">{{ $reply->created_at->diffForHumans() }}</small>
              </div>
            </div>
          @endforeach
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
            <h4 class="fw-bold mb-2" style="color: var(--text-primary);">Aucune publication</h4>
            <p class="text-secondary mb-0">Soyez le premier à partager quelque chose avec la communauté !</p>
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
          <div class="text-center mb-4">
            <img
              src="{{ auth()->user()->avatar_path ? asset('storage/'.auth()->user()->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=1e40af&color=fff&size=200' }}"
              class="rounded-circle mb-3 profile-avatar"
              alt="Votre profil"
            >
            <h5 class="fw-bold mb-2" style="color: var(--text-primary);">{{ auth()->user()->name }}</h5>
            <p class="text-secondary mb-3" style="font-size: 0.9375rem;">{{ auth()->user()->email }}</p>
            <span class="profile-badge">✨ Membre actif</span>
          </div>

          <div class="d-grid gap-2 mb-4">
            <a href="{{ route('profile.show') }}" class="btn btn-primary-custom">
              <svg width="18" height="18" fill="currentColor" class="me-2" viewBox="0 0 16 16" style="vertical-align: text-top;">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
              </svg>
              Voir mon profil
            </a>
          </div>

          <div class="alert-info-custom">
            <div class="d-flex gap-3">
              <svg width="24" height="24" fill="currentColor" style="color: var(--primary-color);" class="flex-shrink-0" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
              </svg>
              <div>
                <small class="mb-0" style="color: var(--text-primary); font-weight: 600; line-height: 1.5;">
                  <strong>Astuce :</strong> Ajoutez une photo de profil pour améliorer votre visibilité dans la communauté.
                </small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@section('scripts')
<script>
// Fonction pour afficher le formulaire de réponse
function showReplyForm(commentId) {
    console.log('Tentative d\'affichage du formulaire pour commentaire:', commentId);
    
    // Cacher tous les formulaires de réponse
    const allForms = document.querySelectorAll('[id^="reply-form-"]');
    allForms.forEach(form => {
        form.style.display = 'none';
    });
    
    // Afficher le formulaire correspondant
    const form = document.getElementById('reply-form-' + commentId);
    if (form) {
        console.log('Formulaire trouvé, affichage...');
        form.style.display = 'block';
        // Focus sur l'input
        const input = form.querySelector('input[name="content"]');
        if (input) {
            input.focus();
        }
    } else {
        console.error('Formulaire non trouvé pour commentId:', commentId);
    }
}

// Fonction pour cacher le formulaire de réponse
function hideReplyForm(commentId) {
    const form = document.getElementById('reply-form-' + commentId);
    if (form) {
        form.style.display = 'none';
        // Réinitialiser le champ
        const input = form.querySelector('input[name="content"]');
        if (input) {
            input.value = '';
        }
    }
}

// Cacher les formulaires quand on clique ailleurs
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM chargé, initialisation des événements...');
    
    // Délégation d'événement pour les boutons "Répondre"
    document.addEventListener('click', function(event) {
        // Si on clique sur un bouton "Répondre"
        if (event.target.matches('[onclick*="showReplyForm"]') || 
            event.target.closest('[onclick*="showReplyForm"]')) {
            console.log('Bouton Répondre cliqué');
            return; // Laisser l'événement onclick gérer
        }
        
        // Si on clique en dehors d'un formulaire de réponse
        if (!event.target.closest('[id^="reply-form-"]')) {
            console.log('Clic en dehors, masquage des formulaires...');
            const allForms = document.querySelectorAll('[id^="reply-form-"]');
            allForms.forEach(form => {
                form.style.display = 'none';
            });
        }
    });
    
    // Empêcher la propagation du clic dans les formulaires
    document.querySelectorAll('[id^="reply-form-"]').forEach(form => {
        form.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    });
});
</script>
@endsection
@endsection