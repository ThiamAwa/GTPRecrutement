<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur associé à un client
        $user1 = User::create([
            'name' => 'Client One',
            'email' => 'client1@example.com',
            'password' => Hash::make('password123'),
            'role_id' => 2
        ]);
        Client::create([
            'user_id' => $user1->id,
            'adresse' => 'Dakar',
        ]);

        // Créer un autre utilisateur associé à un client
        $user2 = User::create([
            'name' => 'Client Two',
            'email' => 'client2@example.com',
            'password' => Hash::make('password123'),
            'role_id' => 2
        ]);

        // Créer un autre client lié à cet utilisateur
        Client::create([
            'user_id' => $user2->id,
            'adresse' => 'diofior',
        ]);

        // Vous pouvez répéter pour créer plusieurs clients
    }


}
