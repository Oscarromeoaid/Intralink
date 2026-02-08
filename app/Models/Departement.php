<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    // ✅ Spécifie le nom de la table si différent de 'departements'
    // Si ta table s'appelle 'depatments' (sans 'r' ni 'e')
    protected $table = 'departements';
    
    protected $fillable = ['name', 'is_active'];
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
}