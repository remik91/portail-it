<?php

namespace Database\Seeders;

use App\Models\Entity;
use Illuminate\Database\Seeder;

class EntitySeeder extends Seeder
{
    public function run(): void
    {
        Entity::create(['name' => 'Équipe Technique', 'description' => 'Support N1 et N2.']);
        Entity::create(['name' => 'Développement', 'description' => 'Équipes de développement logiciel.']);
        Entity::create(['name' => 'Direction', 'description' => 'Management et direction.']);
    }
}