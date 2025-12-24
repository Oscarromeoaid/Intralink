<?php

namespace App\Models;

use App\Models\Post; // ✅ AJOUTE ÇA
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name','email','password',
        'job_title','department','phone','location','bio','avatar_path',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function likes()
{
    return $this->hasMany(Like::class);
}

public function comments()
{
    return $this->hasMany(Comment::class);
}
}
