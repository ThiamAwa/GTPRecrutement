<?php

namespace Database\Seeders;

use App\Models\Candidat;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CandidatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        // Créer un utilisateur associé au candidat


        $user = User::create([
            'name' => 'Moussa Diop',
            'email' => 'qbvvnnnnnnnqqm@groupeisi.com',
            'password' => Hash::make('password123'),
            'role_id' => 4  // Assurez-vous que le role_id 4 correspond au rôle de candidat
        ]);

// Créer un candidat
        Candidat::create([
            'user_id' => $user->id,
            'adresse' => 'Dakar',
            'telephone' => $faker->phoneNumber,
            'competences' => 'développeur Backend',
            'experience' => 'intermédiaire',
            'status' => 'disponible',
            'date_de_candidature' => now(), // Date actuelle pour la candidature
            'date_de_naissance' => '1992-03-12',
            'cv' => $faker->word . '.pdf',
            'lm' => $faker->word . '.pdf' // Lettre de motivation (LM)
        ]);
    }




}
