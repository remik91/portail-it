<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Entity;
use App\Models\User;
use Illuminate\Database\Seeder;

class RelationSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Récupérer les éléments
        $testUser = User::where('email', 'remi.koutchinski@ac-creteil.fr')->first();
        $techEntity = Entity::where('name', 'Équipe Technique')->first();
        $devEntity = Entity::where('name', 'Développement')->first();

        $nagios = Application::where('name', 'Nagios')->first();
        $glpi = Application::where('name', 'GLPI')->first();
        $gitlab = Application::where('name', 'GitLab')->first();

        // 2. Lier l'utilisateur à l'entité "Équipe Technique"
        // La méthode attach() est utilisée pour les relations Many-to-Many
        if ($testUser && $techEntity) {
            $testUser->entities()->attach($techEntity->id);
        }

        // 3. Lier les applications aux entités
        if ($nagios && $techEntity) {
            $nagios->entities()->attach($techEntity->id);
        }
        if ($glpi && $techEntity) {
            $glpi->entities()->attach($techEntity->id);
        }
        if ($gitlab && $devEntity) {
            // GitLab est pour l'entité Développement
            $gitlab->entities()->attach($devEntity->id);
        }

        // 4. Lier une application directement à l'utilisateur (pour tester la 2ème règle)
        if ($testUser && $gitlab) {
            $testUser->directApplications()->attach($gitlab->id);
        }
    }
}