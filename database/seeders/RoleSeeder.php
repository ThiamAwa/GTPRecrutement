<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Role::create(['name' => 'Manager']);
        \App\Models\Role::create(['name' => 'Client']);
        \App\Models\Role::create(['name' => 'Consultant']);
        \App\Models\Role::create(['name' => 'Candidat']);
    }
}
