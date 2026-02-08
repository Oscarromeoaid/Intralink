<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    public function run()
    {
        $positions = [
            'Directeur/Directrice',
            'Manager',
            'Développeur/Développeuse',
            'Chef de projet',
            'Commercial(e)',
            'Chargé(e) de marketing',
            'Analyste',
            'Assistant(e)',
            'Ingénieur',
            'Consultant(e)',
            'Technicien(ne)',
            'Stagiaire'
        ];

        foreach ($positions as $position) {
            Position::create(['title' => $position]);
        }
    }
}