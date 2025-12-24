@extends('layouts.app')

@section('content')
<style>
  .card { border: 1px solid rgba(0,0,0,.06); border-radius: 16px; }
  .btn, .form-control { border-radius: 12px; }
  .feed-avatar { width:44px; height:44px; object-fit:cover; }
  .comment-avatar { width:30px; height:30px; object-fit:cover; }
  .muted { color: rgba(0,0,0,.55); }
  .post-media { border-radius: 14px; overflow: hidden; }
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
      @forelse($post->comments as $comment)
        <div class="d-flex gap-2 mb-3">
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
          </div>
        </div>
      @empty
        <div class="muted py-4 text-center">
          Aucun commentaire pour l’instant.
        </div>
      @endforelse

    </div>
  </div>
</div>
@endsection
