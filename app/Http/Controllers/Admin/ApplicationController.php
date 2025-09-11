<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Category;
use App\Models\Entity;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Ajout pour la validation

class ApplicationController extends Controller
{
    /**
     * Affiche la liste des applications.
     */
    public function index()
    {
        $applications = Application::with('category')->latest()->paginate(10);
        return view('admin.applications.index', compact('applications'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $icons = $this->getIconList(); // On récupère la liste des icônes
        return view('admin.applications.create', compact('categories', 'tags', 'icons'));
    }

    /**
     * Enregistre une nouvelle application.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'icon' => ['nullable', 'string', Rule::in(array_keys($this->getIconList()))],
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $application = Application::create($request->all());
        $application->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.applications.index')->with('success', 'Application créée avec succès.');
    }

    /**
     * Affiche le formulaire d'édition.
     */
    public function edit(Application $application)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $applicationTags = optional($application->tags)->pluck('id')->toArray() ?? [];
        $icons = $this->getIconList(); // On récupère la liste des icônes

        return view('admin.applications.edit', compact('application', 'categories', 'tags', 'applicationTags', 'icons'));
    }

    /**
     * Met à jour une application.
     */
    public function update(Request $request, Application $application)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'icon' => ['nullable', 'string', Rule::in(array_keys($this->getIconList()))],
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $application->update($request->all());
        $application->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.applications.index')->with('success', 'Application mise à jour avec succès.');
    }

    /**
     * Supprime une application.
     */
    public function destroy(Application $application)
    {
        $application->delete();
        return redirect()->route('admin.applications.index')->with('success', 'Application supprimée avec succès.');
    }

    /**
     * Affiche la page de gestion des entités pour une application.
     */
    public function manageEntitiesShow(Application $application)
    {
        $entities = Entity::all();
        $linkedEntityIds = $application->entities->pluck('id')->toArray();

        return view('admin.applications.manage-entities', compact('application', 'entities', 'linkedEntityIds'));
    }

    /**
     * Met à jour les entités liées à une application.
     */
    public function manageEntitiesUpdate(Request $request, Application $application)
    {
        $application->entities()->sync($request->input('entities', []));

        return redirect()->route('admin.applications.index')->with('success', 'Les entités pour l\'application ont été mises à jour.');
    }

    /**
     * Retourne une liste d'icônes prédéfinies.
     */
    private function getIconList(): array
    {
        return [
            'fas fa-server' => 'Server',
            'fas fa-database' => 'Database',
            'fas fa-cogs' => 'Cogs / Settings',
            'fas fa-user-shield' => 'Admin / Security',
            'fas fa-users' => 'Users / Group',
            'fas fa-terminal' => 'Terminal / Console',
            'fas fa-code' => 'Code / Development',
            'fab fa-gitlab' => 'GitLab',
            'fab fa-docker' => 'Docker',
            'fab fa-windows' => 'Windows',
            'fab fa-linux' => 'Linux',
            'fas fa-network-wired' => 'Network',
            'fas fa-shield-alt' => 'Security / Shield',
            'fas fa-envelope' => 'Email / Messaging',
            'fas fa-chart-bar' => 'Analytics / Stats',
            'fas fa-desktop' => 'Desktop / Workstation',
            'fas fa-ticket-alt' => 'Ticket / Support',
            'fas fa-folder-open' => 'Files / Storage',
            'fas fa-wifi' => 'WiFi / Wireless',
            'fas fa-cloud' => 'Cloud',
        ];
    }
}