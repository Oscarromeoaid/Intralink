<form method="POST" action="{{ route('posts.store') }}">
  @csrf
  <textarea name="content" class="form-control" required></textarea>
  <button class="btn btn-primary mt-2">Publier</button>
</form>

<hr>

@foreach($posts as $post)
<img
  src="{{ $post->user->avatar_path
        ? asset('storage/'.$post->user->avatar_path)
        : 'https://ui-avatars.com/api/?name='.urlencode($post->user->name) }}"
  class="rounded-circle"
  width="40"
  height="40"
>

@endforeach
