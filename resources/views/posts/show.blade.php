@extends('layouts.app')

@section('content')
<style>
  .card { border: 1px solid rgba(0,0,0,.06); border-radius: 16px; }
  .btn, .form-control { border-radius: 12px; }
  .feed-avatar { width:44px; height:44px; object-fit:cover; }
  .comment-avatar { width:30px; height:30px; object-fit:cover; }
  .muted { color: rgba(0,0,0,.55); }
  .post-media { border-radius: 14px; overflow: hidden; }
  
  /* Styles pour les commentaires imbriqués */
  .comment-reply {
    margin-left: 50px;
    border-left: 2px solid #e9ecef;
    padding-left: 20px;
  }
  .reply-form {
    margin-top: 10px;
    background: rgba(0,0,0,0.02);
    padding: 15px;
    border-radius: 10px;
  }
  .reply-form textarea {
    font-size: 0.9rem;
  }
  .btn-reply {
    font-size: 0.8rem;
    padding: 4px 12px;
  }
  .btn-like {
    font-size: 0.8rem;
    padding: 4px 8px;
  }
  .liked {
    color: #2563eb;
    background-color: rgba(37, 99, 235, 0.1);
  }
</style>

<div class="container py-3" style="max-width: 900px;">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('home') }}" class="text-decoration-none muted">
      ← Retour au fil
    </a>
    <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-dark">
      Mon profil
    </a>
  </div>

  <div class="card">
    <div class="card-body">

      {{-- Header --}}
      <div class="d-flex align-items-center gap-2">
        <img
          src="{{ $post->user->avatar_path
            ? asset('storage/'.$post->user->avatar_path)
            : 'https://ui-avatars.com/api/?name='.urlencode($post->user->name) }}"
          class="rounded-circle feed-avatar"
          alt="avatar"
        >
        <div class="flex-grow-1">
          <div class="fw-semibold">{{ $post->user->name }}</div>
          <div class="muted" style="font-size:.9rem;">
            {{ $post->created_at->diffForHumans() }}
          </div>
        </div>
      </div>

      {{-- Content --}}
      <div class="mt-3" style="white-space:pre-wrap; font-size:1.05rem;">
        {{ $post->content }}
      </div>

      {{-- Media --}}
      @if($post->media_path)
        <div class="mt-3 post-media">
          @if($post->media_type === 'image')
            <img src="{{ asset('storage/'.$post->media_path) }}" class="img-fluid" alt="media">
          @elseif($post->media_type === 'video')
            <video controls class="w-100">
              <source src="{{ asset('storage/'.$post->media_path) }}" type="{{ $post->media_mime }}">
            </video>
          @endif
        </div>
      @endif

      <hr class="my-4">

      {{-- Comment form --}}
      <div class="mb-3">
        <form method="POST" action="{{ route('posts.comments.store', $post) }}">
          @csrf
          <div class="d-flex gap-2">
            <input
              type="text"
              name="content"
              class="form-control"
              placeholder="Écrire un commentaire…"
              required
            >
            <button class="btn btn-dark px-3">Envoyer</button>
          </div>
        </form>
      </div>

      {{-- Comments header --}}
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-semibold mb-0">
          Commentaires ({{ $post->comments->count() }})
        </h6>
      </div>

      {{-- Comments list --}}
      @forelse($post->comments->whereNull('parent_id') as $comment)
        {{-- Commentaire principal --}}
        <div class="mb-3" id="comment-{{ $comment->id }}">
          <div class="d-flex gap-2">
            <img
              src="{{ $comment->user->avatar_path
                ? asset('storage/'.$comment->user->avatar_path)
                : 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name) }}"
              class="rounded-circle comment-avatar"
              alt="avatar"
            >
            <div class="bg-light rounded-4 px-3 py-2 w-100">
              <div class="d-flex justify-content-between align-items-center">
                <div class="fw-semibold">{{ $comment->user->name }}</div>
                <div class="muted" style="font-size:.8rem;">
                  {{ $comment->created_at->diffForHumans() }}
                </div>
              </div>
              <div class="mt-1" style="white-space:pre-wrap;">
                {{ $comment->content }}
              </div>
              
              {{-- Boutons d'action --}}
              <div class="mt-2 d-flex gap-2">
                {{-- Bouton Répondre --}}
                <button type="button" class="btn btn-sm btn-outline-secondary btn-reply" 
                        onclick="showReplyForm({{ $comment->id }})">
                  <i class="fas fa-reply"></i> Répondre
                </button>
                
                {{-- Bouton Like --}}
                <form action="{{ route('comments.like', $comment) }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-sm btn-outline-primary btn-like {{ $comment->isLikedBy(auth()->user()) ? 'liked' : '' }}">
                    <i class="fas fa-thumbs-up"></i> {{ $comment->likesCount() }}
                  </button>
                </form>
                
                {{-- Bouton Supprimer (si autorisé) --}}
                @can('delete', $comment)
                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" 
                          onclick="return confirm('Supprimer ce commentaire ?')">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
                @endcan
              </div>
              
              {{-- Formulaire de réponse (caché) --}}
              <div id="reply-form-{{ $comment->id }}" class="reply-form" style="display: none;">
                <form method="POST" action="{{ route('posts.comments.store', $post) }}">
                  @csrf
                  <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                  <div class="d-flex gap-2">
                    <input
                      type="text"
                      name="content"
                      class="form-control"
                      placeholder="Écrire une réponse…"
                      required
                    >
                    <button class="btn btn-dark px-3">Envoyer</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          
          {{-- Réponses à ce commentaire --}}
          @foreach($comment->replies as $reply)
            <div class="comment-reply mt-2" id="comment-{{ $reply->id }}">
              <div class="d-flex gap-2">
                <img
                  src="{{ $reply->user->avatar_path
                    ? asset('storage/'.$reply->user->avatar_path)
                    : 'https://ui-avatars.com/api/?name='.urlencode($reply->user->name) }}"
                  class="rounded-circle comment-avatar"
                  alt="avatar"
                >
                <div class="bg-light rounded-4 px-3 py-2 w-100">
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="fw-semibold">{{ $reply->user->name }}</div>
                    <div class="muted" style="font-size:.8rem;">
                      {{ $reply->created_at->diffForHumans() }}
                    </div>
                  </div>
                  <div class="mt-1" style="white-space:pre-wrap;">
                    {{ $reply->content }}
                  </div>
                  
                  {{-- Boutons pour les réponses --}}
                  <div class="mt-2 d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-reply" 
                            onclick="showReplyForm({{ $reply->id }})">
                      <i class="fas fa-reply"></i> Répondre
                    </button>
                    
                    {{-- Bouton Like pour la réponse --}}
                    <form action="{{ route('comments.like', $reply) }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-outline-primary btn-like {{ $reply->isLikedBy(auth()->user()) ? 'liked' : '' }}">
                        <i class="fas fa-thumbs-up"></i> {{ $reply->likesCount() }}
                      </button>
                    </form>
                    
                    @can('delete', $reply)
                    <form action="{{ route('comments.destroy', $reply) }}" method="POST" class="d-inline">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" 
                              onclick="return confirm('Supprimer cette réponse ?')">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                    @endcan
                  </div>
                  
                  {{-- Formulaire de réponse pour une réponse (caché) --}}
                  <div id="reply-form-{{ $reply->id }}" class="reply-form" style="display: none;">
                    <form method="POST" action="{{ route('posts.comments.store', $post) }}">
                      @csrf
                      <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                      <div class="d-flex gap-2">
                        <input
                          type="text"
                          name="content"
                          class="form-control"
                          placeholder="Écrire une réponse…"
                          required
                        >
                        <button class="btn btn-dark px-3">Envoyer</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @empty
        <div class="muted py-4 text-center">
          Aucun commentaire pour l'instant.
        </div>
      @endforelse

    </div>
  </div>
</div>

@push('scripts')
<script>
// Fonction pour afficher le formulaire de réponse
function showReplyForm(commentId) {
    console.log('Appel de showReplyForm avec ID:', commentId);
    
    // Cacher tous les formulaires de réponse
    const replyForms = document.querySelectorAll('.reply-form');
    
    // Cacher tous sauf celui qu'on veut afficher
    replyForms.forEach(form => {
        if (form.id === 'reply-form-' + commentId) {
            form.style.display = 'block';
            // Focus sur le champ de saisie
            const input = form.querySelector('input[type="text"]');
            if (input) input.focus();
        } else {
            form.style.display = 'none';
        }
    });
}

// Initialisation quand la page est chargée
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page chargée, formulaires de réponse:', document.querySelectorAll('.reply-form').length);
    
    // Cacher tous les formulaires de réponse au chargement
    document.querySelectorAll('.reply-form').forEach(form => {
        form.style.display = 'none';
    });
    
    // Événement global pour cacher les formulaires quand on clique ailleurs
    document.addEventListener('click', function(e) {
        // Si on ne clique pas sur un bouton Répondre ou dans un formulaire
        if (!e.target.closest('.btn-reply') && !e.target.closest('.reply-form')) {
            document.querySelectorAll('.reply-form').forEach(form => {
                form.style.display = 'none';
            });
        }
    });
    
    // Empêcher la fermeture du formulaire quand on clique dedans
    document.querySelectorAll('.reply-form').forEach(form => {
        form.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
});
</script>
@endpush
@endsection