<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Deeplink;
use Illuminate\Http\Request;

class DeeplinkController extends Controller
{
    public function create(Application $application)
    {
        return view('admin.deeplinks.create', compact('application'));
    }

    public function store(Request $request, Application $application)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
        ]);

        $application->deeplinks()->create($request->all());

        return redirect()->route('admin.applications.edit', $application)->with('success', 'Deeplink ajouté avec succès.');
    }

    public function edit(Application $application, Deeplink $deeplink)
    {
        return view('admin.deeplinks.edit', compact('application', 'deeplink'));
    }

    public function update(Request $request, Application $application, Deeplink $deeplink)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
        ]);

        $deeplink->update($request->all());

        return redirect()->route('admin.applications.edit', $application)->with('success', 'Deeplink mis à jour avec succès.');
    }

    public function destroy(Application $application, Deeplink $deeplink)
    {
        $deeplink->delete();
        return redirect()->route('admin.applications.edit', $application)->with('success', 'Deeplink supprimé avec succès.');
    }
}