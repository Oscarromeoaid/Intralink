<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departement;

class DepartementSeeder extends Seeder
{
    public function run()
    {
        $departements = [
            'Direction',
            'Ressources Humaines',
            'Informatique',
            'Commercial',
            'Marketing',
            'Production',
            'Finance',
            'Administratif',
            'Recherche & Développement',
            'Support Technique'
        ];

        foreach ($departements as $dept) {
            Departement::create(['name' => $dept]);
        }
    }
}