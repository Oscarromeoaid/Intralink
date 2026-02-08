<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_id', 'content', 'parent_id'];

    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }
    
    public function post() 
    { 
        return $this->belongsTo(Post::class); 
    }
    
    // Réponses d'un commentaire
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'asc');
    }
    
    // Commentaire parent
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
    
    // Pour vérifier si un commentaire est une réponse
    public function isReply()
    {
        return !is_null($this->parent_id);
    }
    
    // Likes
    public function likes()
    {
        return $this->belongsToMany(User::class, 'comment_likes')
                    ->withTimestamps();
    }
    
    // Vérifie si l'utilisateur connecté a liké ce commentaire
    public function isLikedBy(User $user = null)
    {
        if (!$user) {
            return false;
        }
        
        return $this->likes()->where('user_id', $user->id)->exists();
    }
    
    // Compteur de likes
    public function likesCount()
    {
        return $this->likes()->count();
    }
}