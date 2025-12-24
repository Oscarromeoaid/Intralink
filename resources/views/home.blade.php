@extends('layouts.app')

@section('content')

{{-- === Styles UI Feed (simple & clean) === --}}
<style>
  .card { border: 1px solid rgba(0,0,0,.06); border-radius: 16px; }
  .btn, .form-control { border-radius: 12px; }
  .feed-avatar { width:44px; height:44px; object-fit:cover; }
  .comment-avatar { width:30px; height:30px; object-fit:cover; }
  .muted { color: rgba(0,0,0,.55); }
  .post-media { border-radius: 14px; overflow: hidden; }
  .chip { border:1px solid rgba(0,0,0,.08); border-radius:999px; padding:.35rem .7rem; background:#fff; }
</style>

<div class="container">
  <div class="row g-4">

    {{-- ===== FEED ===== --}}
    <div class="col-lg-8">

      {{-- Create Post --}}
      <div class="card mb-3">
        <div class="card-body">
          <div class="d-flex align-items-center gap-2 mb-2">
            <img
              src="{{ auth()->user()->avatar_path ? asset('storage/'.auth()->user()->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}"
              class="rounded-circle feed-avatar"
            >
            <div>
              <div class="fw-semibold">Nouvelle publication</div>
              <div class="muted" style="font-size:.9rem;">Partage une information</div>
            </div>
          </div>

          <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <textarea name="content" class="form-control" rows="3" required placeholder="Quoi de neuf ?">{{ old('content') }}</textarea>

            <div class="d-flex justify-content-between align-items-center mt-2 flex-wrap gap-2">
              <div class="chip">
                <input type="file" name="media" class="form-control border-0 p-0" style="box-shadow:none;" accept="image/*,video/*">
                <div class="muted" style="font-size:.8rem;">Photo / vidéo</div>
              </div>

              <button class="btn btn-dark px-4">Publier</button>
            </div>
          </form>
        </div>
      </div>

      {{-- Posts --}}
      @forelse($posts as $post)
        <div class="card mb-3">
          <div class="card-body">

            {{-- Header --}}
            <div class="d-flex align-items-center gap-2">
              <img
                src="{{ $post->user->avatar_path ? asset('storage/'.$post->user->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode($post->user->name) }}"
                class="rounded-circle feed-avatar"
              >
              <div>
                <div class="fw-semibold">{{ $post->user->name }}</div>
                <div class="muted" style="font-size:.9rem;">{{ $post->created_at->diffForHumans() }}</div>
              </div>
            </div>

            {{-- Content --}}
            <div class="mt-3" style="white-space:pre-wrap;">{{ $post->content }}</div>

            {{-- Media --}}
            @if($post->media_path)
              <div class="mt-3 post-media">
                @if($post->media_type === 'image')
                  <img src="{{ asset('storage/'.$post->media_path) }}" class="img-fluid">
                @else
                  <video controls class="w-100">
                    <source src="{{ asset('storage/'.$post->media_path) }}" type="{{ $post->media_mime }}">
                  </video>
                @endif
              </div>
            @endif

            {{-- Actions --}}
            <div class="mt-3 d-flex align-items-center gap-3">
              <form method="POST" action="{{ route('posts.like', $post) }}">
                @csrf
                <button class="btn btn-sm {{ $post->isLikedBy(auth()->user()) ? 'btn-danger' : 'btn-outline-danger' }}">
                  {{ $post->isLikedBy(auth()->user()) ? '♥' : '♡' }} J’aime
                </button>
              </form>

              <span class="muted">{{ $post->likes->count() }} j’aime</span>
              <span class="muted">{{ $post->comments->count() }} commentaire(s)</span>
            </div>

            {{-- Comment form --}}
            <div class="mt-3">
              <form method="POST" action="{{ route('posts.comments.store', $post) }}">
                @csrf
                <div class="d-flex gap-2">
                  <input type="text" name="content" class="form-control" placeholder="Écrire un commentaire…" required>
                  <button class="btn btn-outline-dark">Envoyer</button>
                </div>
              </form>
            </div>

            {{-- Comments --}}
@php
  $totalComments = $post->comments->count();
  $visibleComments = $post->comments->take(2);
@endphp

@if($totalComments)
  <div class="mt-3">

    {{-- Voir plus --}}
    @if($totalComments > 2)
      <a href="{{ route('posts.show', $post) }}" class="muted text-decoration-none mb-2 d-inline-block">
        Voir tous les commentaires ({{ $totalComments }})
      </a>
    @endif

    {{-- Commentaires visibles --}}
    @foreach($visibleComments as $comment)
      <div class="d-flex gap-2 mb-2">
        <img
          src="{{ $comment->user->avatar_path
            ? asset('storage/'.$comment->user->avatar_path)
            : 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name) }}"
          class="rounded-circle comment-avatar"
        >
        <div class="bg-light rounded-4 px-3 py-2 w-100">
          <div class="fw-semibold" style="font-size:.9rem;">
            {{ $comment->user->name }}
          </div>
          <div style="white-space:pre-wrap;">
            {{ $comment->content }}
          </div>
        </div>
      </div>
    @endforeach

  </div>
@endif
              

          </div>
        </div>
      @empty
        <div class="text-center muted py-5">Aucune publication pour le moment.</div>
      @endforelse

      {{ $posts->links() }}
    </div>

    {{-- ===== SIDEBAR ===== --}}
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center gap-2">
            <img
              src="{{ auth()->user()->avatar_path ? asset('storage/'.auth()->user()->avatar_path) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}"
              class="rounded-circle feed-avatar"
            >
            <div>
              <div class="fw-semibold">{{ auth()->user()->name }}</div>
              <div class="muted" style="font-size:.9rem;">{{ auth()->user()->email }}</div>
            </div>
          </div>

          <div class="d-grid gap-2 mt-3">
            <a href="{{ route('profile.show') }}" class="btn btn-outline-dark">Mon profil</a>
          </div>

          <hr>
          <div class="muted" style="font-size:.9rem;">
            Astuce : ajoute une photo de profil pour une meilleure reconnaissance.
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection
