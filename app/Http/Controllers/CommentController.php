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

    // Store a new comment or a reply
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ]);

        $comment = new Comment();
        $comment->user_id = $request->user()->id;
        $comment->post_id = $post->id;
        $comment->content = $validated['content'];
        
        // Si c'est une réponse à un commentaire
        if (isset($validated['parent_id'])) {
            $comment->parent_id = $validated['parent_id'];
        }
        
        $comment->save();

        return back()->with('success', 'Commentaire ajouté !');
    }
    
    // Supprimer un commentaire
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        
        return back()->with('success', 'Commentaire supprimé !');
    }
    
    // Like/unlike a comment
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
    // Vérifier que l'utilisateur n'est pas admin/modo
    if (in_array(auth()->user()->role, ['admin', 'moderator'])) {
        return back()->with('error', 'Les modérateurs peuvent directement supprimer les commentaires.');
    }
    
    // Marquer directement comme signalé avec un timestamp valide
    $comment->update([
        'reported' => true,
        'reported_at' => now(), // Carbon instance
    ]);
    
    return back()->with('success', 'Commentaire signalé. Un modérateur va l\'examiner.');
}
}