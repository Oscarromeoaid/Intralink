<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'post_id' => 'required|exists:posts,id'
        ]);

        $user = auth()->user();

        $comment = Comment::create([
            'content' => $request->content,
            'user_id' => $user->id,
            'post_id' => $request->post_id,
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Commentaire ajouté');
    }

    public function destroy(Comment $comment)
    {
        $user = auth()->user();

        if ($comment->user_id === $user->id || $user->role === 'admin' || $user->role === 'moderator') {
            $comment->replies()->delete();
            $comment->delete();
            return back()->with('success', 'Commentaire supprimé');
        }

        return back()->with('error', 'Vous n\'êtes pas autorisé à supprimer ce commentaire');
    }

    public function like(Request $request, Comment $comment)
    {
        $user = $request->user();

        if ($comment->likes()->where('user_id', $user->id)->exists()) {
            $comment->likes()->detach($user->id);
            $message = 'Like retiré';
        } else {
            $comment->likes()->attach($user->id);
            $message = 'Commentaire aimé';
        }

        return back()->with('success', $message);
    }

    public function report(Comment $comment)
    {
        if (in_array(auth()->user()->role, ['admin', 'moderator'])) {
            return back()->with('error', 'Les modérateurs peuvent directement supprimer les commentaires.');
        }

        $comment->update([
            'reported' => true,
            'reported_at' => now(),
        ]);

        return back()->with('success', 'Commentaire signalé. Un modérateur va l\'examiner.');
    }
}
