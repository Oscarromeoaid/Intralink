<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
$posts = \App\Models\Post::with(['user', 'likes', 'comments.user'])
    ->latest()
    ->paginate(10);

return view('home', compact('posts'));


    }
    public function show(Post $post)
{
    $post->load(['user','likes','comments.user']);

    return view('posts.show', compact('post'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'content' => ['required', 'string', 'max:1000'],
        'media' => ['nullable', 'file', 'max:51200'], // 50 MB (en KB)
        'media_type' => ['nullable', 'in:image,video'],
    ]);

    $data = [
        'content' => $validated['content'],
    ];

    if ($request->hasFile('media')) {
        $file = $request->file('media');

        // Déterminer type réel
        $mime = $file->getMimeType();
        $isImage = str_starts_with($mime, 'image/');
        $isVideo = str_starts_with($mime, 'video/');

        // Sécurité : n’accepter que image/video
        if (!$isImage && !$isVideo) {
            return back()->withErrors(['media' => 'Format non supporté.'])->withInput();
        }

        // Règles spécifiques (optionnelles mais utiles)
        if ($isVideo && $file->getSize() > 50 * 1024 * 1024) { // 50MB
            return back()->withErrors(['media' => 'La vidéo dépasse 50MB.'])->withInput();
        }

        $data['media_type'] = $isImage ? 'image' : 'video';
        $data['media_mime'] = $mime;
        $data['media_size'] = $file->getSize();
        $data['media_path'] = $file->store('posts', 'public');
    }

    $request->user()->posts()->create($data);

    return back()->with('success', 'Post publié avec succès !');
}

}
