<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Affiche tous les posts
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return view('home', compact('posts'));
    }

    // Crée un nouveau post
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

       $user = auth()->user();
$user->posts()->create([
    'content' => $request->content
]);

        return back()->with('success', 'Post publié avec succès !');
    }
}
