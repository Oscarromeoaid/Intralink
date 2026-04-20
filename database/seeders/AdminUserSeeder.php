<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
       
 // ADMIN
        User::updateOrCreate(
            ['email' => 'admin@intralink.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('1234567890'),
                'role' => 'admin',
                'job_title' => 'Administrateur',
                'location' => 'Paris',
                'bio' => 'Administrateur de la plateforme',
                'departement_id' => $informatique->id ?? null,
                'position_id' => $manager->id ?? null,
                'email_verified_at' => now(),
            ]
        );

        // MODERATEUR
        User::updateOrCreate(
            ['email' => 'moderator@intralink.com'],
            [
                'name' => 'Moderator',
                'password' => Hash::make('1234567890'),
                'role' => 'moderator',
                'job_title' => 'Modérateur',
                'location' => 'Lyon',
                'bio' => 'Modérateur de contenu',
                'departement_id' => $informatique->id ?? null,
                'position_id' => $manager->id ?? null,
                'email_verified_at' => now(),
            ]
        );

        // USER 1
        User::updateOrCreate(
            ['email' => 'user1@intralink.com'],
            [
                'name' => 'User 1',
                'password' => Hash::make('1234567890'),
                'role' => 'user',
                'job_title' => 'Développeur',
                'location' => 'Paris',
                'bio' => 'Développeur full stack',
                'departement_id' => $informatique->id ?? null,
                'position_id' => $developpeur->id ?? null,
                'email_verified_at' => now(),
            ]
        );

        // USER 2
        User::updateOrCreate(
            ['email' => 'user2@intralink.com'],
            [
                'name' => 'User 2',
                'password' => Hash::make('1234567890'),
                'role' => 'user',
                'job_title' => 'Commercial',
                'location' => 'Marseille',
                'bio' => 'Commercial sénior',
                'departement_id' => $commercial->id ?? null,
                'position_id' => $commercialPos->id ?? null,
                'email_verified_at' => now(),
            ]
        );

        // USER 3
        User::updateOrCreate(
            ['email' => 'user3@intralink.com'],
            [
                'name' => 'User 3',
                'password' => Hash::make('1234567890'),
                'role' => 'user',
                'job_title' => 'Marketing',
                'location' => 'Lyon',
                'bio' => 'Chargée de marketing digital',
                'departement_id' => $marketing->id ?? null,
                'position_id' => $marketingPos->id ?? null,
                'email_verified_at' => now(),
            ]
        );

        // USER 4
        User::updateOrCreate(
            ['email' => 'user4@intralink.com'],
            [
                'name' => 'User 4',
                'password' => Hash::make('1234567890'),
                'role' => 'user',
                'job_title' => 'RH',
                'location' => 'Bordeaux',
                'bio' => 'Responsable RH',
                'departement_id' => $rh->id ?? null,
                'position_id' => $manager->id ?? null,
                'email_verified_at' => now(),
            ]
        );

        // USER 5
        User::updateOrCreate(
            ['email' => 'user5@intralink.com'],
            [
                'name' => 'User 5',
                'password' => Hash::make('1234567890'),
                'role' => 'user',
                'job_title' => 'Finance',
                'location' => 'Nantes',
                'bio' => 'Analyste financier',
                'departement_id' => $finance->id ?? null,
                'position_id' => $analyste->id ?? null,
                'email_verified_at' => now(),
            ]
        );
    }
}