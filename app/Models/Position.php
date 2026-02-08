<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = ['title', 'is_active'];
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
}