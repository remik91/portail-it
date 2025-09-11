<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        // // Récupérer les catégories par leur nom
        // $supervision = Category::where('name', 'Supervision')->first();
        // $gestionParc = Category::where('name', 'Gestion de parc')->first();
        // $communication = Category::where('name', 'Communication')->first();
        // $developpement = Category::where('name', 'Développement')->first();

        // // Créer les applications
        // Application::create([
        //     'name' => 'Nagios',
        //     'description' => 'Supervision système et réseau.',
        //     'url' => 'http://nagios.example.com',
        //     'icon' => 'fas fa-server',
        //     'category_id' => $supervision->id
        // ]);

        // Application::create([
        //     'name' => 'GLPI',
        //     'description' => 'Gestion de parc et service desk.',
        //     'url' => 'http://glpi.example.com',
        //     'icon' => 'fas fa-cogs',
        //     'category_id' => $gestionParc->id
        // ]);

        // Application::create([
        //     'name' => 'Microsoft Teams',
        //     'description' => 'Plateforme de communication collaborative.',
        //     'url' => 'https://teams.microsoft.com',
        //     'icon' => 'fab fa-microsoft',
        //     'category_id' => $communication->id
        // ]);

        // Application::create([
        //     'name' => 'GitLab',
        //     'description' => 'Gestion de code source et CI/CD.',
        //     'url' => 'http://gitlab.example.com',
        //     'icon' => 'fab fa-gitlab',
        //     'category_id' => $developpement->id
        // ]);
    }
}