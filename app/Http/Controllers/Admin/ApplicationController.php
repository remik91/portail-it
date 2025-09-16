<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Entity;
use App\Models\Category;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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
        $icons = $this->getIconList();
        return view('admin.applications.create', compact('categories', 'tags', 'icons'));
    }


    /**
     * Enregistre une nouvelle application.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'icon' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation du logo
            'tags' => 'nullable|array'
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        $application = Application::create($validated);
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
        $icons = $this->getIconList();
        return view('admin.applications.edit', compact('application', 'categories', 'tags', 'applicationTags', 'icons'));
    }

    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'icon' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tags' => 'nullable|array'
        ]);

        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo s'il existe
            if ($application->logo_path) {
                Storage::disk('public')->delete($application->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        $application->update($validated);
        $application->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.applications.index')->with('success', 'Application mise à jour avec succès.');
    }

    public function destroy(Application $application)
    {
        // Supprimer le logo associé avant de supprimer l'application
        if ($application->logo_path) {
            Storage::disk('public')->delete($application->logo_path);
        }
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