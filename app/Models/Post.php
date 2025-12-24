<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory;

protected $fillable = [
    'user_id',
    'content',
    'media_path',
    'media_type',
    'media_mime',
    'media_size',
];

public function mediaUrl(): ?string
{
    return $this->media_path ? asset('storage/'.$this->media_path) : null;
}


    // Relation vers l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
{
    return $this->hasMany(Like::class);
}

public function comments()
{
    return $this->hasMany(Comment::class)->latest();
}

public function isLikedBy(?\App\Models\User $user): bool
{
    if (!$user) return false;
    return $this->likes->contains('user_id', $user->id);
}
}
