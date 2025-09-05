<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        User::create([
            'name' => 'Utilisateur Test',
            'email' => 'remi.koutchinski@ac-creteil.fr',
            'password' => bcrypt('$Remi30*'), // Le mot de passe est 'password'
        ]);
        // Appelle les seeders dans un ordre logique
        $this->call([
            CategorySeeder::class,
            EntitySeeder::class,
            ApplicationSeeder::class,
            RelationSeeder::class,
        ]);
    }
}