<?php

namespace App\Http\Controllers\Admin;

use App\Models\Entity;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = Application::with('category')->latest()->paginate(10);
        return view('admin.applications.index', compact('applications'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all(); // <-- Ajoutez cette ligne
        return view('admin.applications.create', compact('categories', 'tags')); // <-- Modifiez cette ligne
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'icon' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $application = Application::create($request->except('tags'));
        $application->tags()->sync($request->input('tags', [])); // <-- Ajoutez cette ligne pour synchroniser les tags

        return redirect()->route('admin.applications.index')->with('success', 'Application créée avec succès.');
    }

    public function edit(Application $application)
    {
        $categories = Category::all();
        $tags = Tag::all(); // <-- Ajoutez cette ligne
        $applicationTags = optional($application->tags)->pluck('id')->toArray() ?? [];
        return view('admin.applications.edit', compact('application', 'categories', 'tags', 'applicationTags'));
    }

    public function update(Request $request, Application $application)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'icon' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $application->update($request->except('tags'));
        $application->tags()->sync($request->input('tags', [])); // <-- Ajoutez cette ligne pour synchroniser les tags

        return redirect()->route('admin.applications.index')->with('success', 'Application mise à jour avec succès.');
    }

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
        // La méthode sync() est parfaite pour les relations Many-to-Many.
        // Elle synchronise la table pivot avec le tableau d'IDs fourni.
        $application->entities()->sync($request->input('entities', []));

        return redirect()->route('admin.applications.index')->with('success', 'Les entités pour l\'application ont été mises à jour.');
    }

    // ... implémentez edit, update, destroy de la même manière
}