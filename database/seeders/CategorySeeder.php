<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Supervision', 'description' => 'Outils de monitoring et d\'alerte.']);
        Category::create(['name' => 'Gestion de parc', 'description' => 'Gestion des actifs matériels et logiciels.']);
        Category::create(['name' => 'Communication', 'description' => 'Outils de messagerie et de collaboration.']);
        Category::create(['name' => 'Développement', 'description' => 'Outils pour le cycle de vie logiciel.']);
    }
}