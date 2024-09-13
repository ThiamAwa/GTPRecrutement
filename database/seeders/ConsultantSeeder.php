<?php

namespace Database\Seeders;

use App\Models\Consultant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;



class ConsultantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        $faker = Faker::create();

//        foreach (range(1, 10) as $index) {
//            DB::table('consultants')->insert([
//                'nom' => $faker->lastName,
//                'prenom' => $faker->firstName,
//                'telephone' => $faker->phoneNumber,
//                'email' => $faker->unique()->safeEmail,
//                'adresse' => $faker->address,
//                'competences' => $faker->words(3, true),
//                'experiences' => $faker->sentence,
//                'status' => $faker->randomElement(['Actif', 'Inactif']),
//                'date_disponibilite' => $faker->date,
//                'statut_evaluation' => $faker->randomElement(['Évalué', 'Non Évalué']),
//                'date_de_naissance' => $faker->date,
//                'cv' => $faker->word . '.pdf',
//                'notes_mission' => $faker->sentence,
//                'commentaires' => $faker->sentence,
//            ]);
//        }
        $faker = Faker::create();
        $user2 = User::create([
            'name' => 'Consultant frits',
            'email' => 'consultant5@example.com',
            'password' => Hash::make('password123'),
            'role_id' => 3
        ]);

        // Créer un autre client lié à cet utilisateur
        Consultant::create([
            'user_id' => $user2->id,
            'adresse' => 'diofior',
            'telephone' => $faker->phoneNumber,
            'competences'=>'developpeur Back_end et Front_end',
            'experiences'=>7,
            'status'=>'disponible',
            'date_disponibilite'=>'01/07/2021',
            'statut_evaluation'=>'en_cours',
            'date_de_naissance'=>'01/07/2004',
            'cv' => $faker->word . '.pdf',
            'notes_mission'=>0,
            'commentaires'=>'bonjour',
        ]);
    }

}
