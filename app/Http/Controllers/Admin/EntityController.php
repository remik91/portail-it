<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    public function index()
    {
        $entities = Entity::latest()->paginate(10);
        return view('admin.entities.index', compact('entities'));
    }

    public function create()
    {
        return view('admin.entities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:entities',
            'description' => 'nullable|string',
        ]);

        Entity::create($request->all());

        return redirect()->route('admin.entities.index')->with('success', 'Entité créée avec succès.');
    }

    public function edit(Entity $entity)
    {
        return view('admin.entities.edit', compact('entity'));
    }

    public function update(Request $request, Entity $entity)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:entities,name,' . $entity->id,
            'description' => 'nullable|string',
        ]);

        $entity->update($request->all());

        return redirect()->route('admin.entities.index')->with('success', 'Entité mise à jour avec succès.');
    }

    public function destroy(Entity $entity)
    {
        $entity->delete();
        return redirect()->route('admin.entities.index')->with('success', 'Entité supprimée avec succès.');
    }
}