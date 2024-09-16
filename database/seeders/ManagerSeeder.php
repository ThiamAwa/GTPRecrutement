<?php

namespace Database\Seeders;

use App\Models\Manager;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $user2 = User::create([
            'name' => 'manager Two',
            'email' => 'manager2@example.com',
            'password' => Hash::make('password123'),
            'role_id' => 1
        ]);

        // Créer un autre client lié à cet utilisateur
        Manager::create([
            'user_id' => $user2->id,
            'adresse' => 'diofior',
            'photo' => $faker->word . '.' . $faker->fileExtension,

        ]);
    }
}
