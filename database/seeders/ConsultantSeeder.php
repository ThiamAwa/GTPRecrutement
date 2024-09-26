<?php

namespace Database\Seeders;

use App\Models\Consultant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class ConsultantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Créer le deuxième consultant
        $user2 = User::create([
            'name' => 'Awa Thiam',
            'email' => 'thiamawa@groupeisi.com',
            'password' => Hash::make('password123'),
            'role_id' => 3
        ]);

        Consultant::create([
            'user_id' => $user2->id,
            'adresse' => 'Dakar',
            'telephone' => $faker->phoneNumber,
            'competences' => 'développeur Front_end',
            'experiences' => 'avance',
            'status' => 'disponible',
            'date_disponibilite' => '2022-01-01',
            'statut_evaluation' => 'évalué',
            'date_de_naissance' => '1990-05-15',
            'cv' => $faker->word . '.pdf',
            'notes_mission' => 1,
            'commentaires' => 'Je suis disponible.',
        ]);

        // Créer un troisième consultant
//        $user3 = User::create([
//            'name' => 'Consultant Trois',
//            'email' => 'thiamawa@groupeisi.com',
//            'password' => Hash::make('password123'),
//            'role_id' => 3
//        ]);
//
//        Consultant::create([
//            'user_id' => $user3->id,
//            'adresse' => 'Thies',
//            'telephone' => $faker->phoneNumber,
//            'competences' => 'développeur Fullstack',
//            'experiences' => 8,
//            'status' => 'disponible',
//            'date_disponibilite' => '2023-04-01',
//            'statut_evaluation' => 'en_cours',
//            'date_de_naissance' => '1988-03-22',
//            'cv' => $faker->word . '.pdf',
//            'notes_mission' => 2,
//            'commentaires' => 'Prêt pour de nouvelles missions.',
//        ]);
    }
}
