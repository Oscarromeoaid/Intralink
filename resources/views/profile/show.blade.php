@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex align-items-center gap-3 mb-4">
        <img
            src="{{ $user->avatar_path ? asset('storage/'.$user->avatar_path) : 'https://via.placeholder.com/96' }}"
            alt="Avatar"
            width="96" height="96"
            class="rounded-circle object-fit-cover"
        >
        <div>
            <h3 class="mb-0">{{ $user->name }}</h3>
            <div class="text-muted">
                {{ $user->job_title ?? '—' }} • {{ $user->department ?? '—' }}
            </div>
            <div class="mt-2">
                <a class="btn btn-primary btn-sm" href="{{ route('profile.edit') }}">Modifier mon profil</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <p><strong>Email :</strong> {{ $user->email }}</p>
            <p><strong>Téléphone :</strong> {{ $user->phone ?? '—' }}</p>
            <p><strong>Localisation :</strong> {{ $user->location ?? '—' }}</p>
            <p class="mb-0"><strong>Bio :</strong><br>{{ $user->bio ?? '—' }}</p>
        </div>
    </div>
</div>
<hr>

<h5 class="fw-semibold mb-3">Mes publications</h5>

@forelse($posts as $post)
  <div class="card mb-2">
    <div class="card-body">
      <div class="muted" style="font-size:.9rem;">
        {{ $post->created_at->diffForHumans() }}
      </div>
      <div class="mt-1" style="white-space:pre-wrap;">
        {{ $post->content }}
      </div>
      <div class="muted mt-2" style="font-size:.9rem;">
        {{ $post->likes_count }} j’aime • {{ $post->comments_count }} commentaires
      </div>
    </div>
  </div>
@empty
  <div class="muted">Aucune publication.</div>
@endforelse

@endsection
