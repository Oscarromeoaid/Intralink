<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function delete(User $user, Comment $comment): bool
    {
        // Seulement si l'utilisateur est le propriétaire du commentaire
        return $user->id === $comment->user_id;
        
        // Si vous voulez ajouter des admins plus tard :
        // return $user->id === $comment->user_id || $user->role === 'admin';
    }
    
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }
}