<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Category;
use App\Models\Tag; // <-- Ajoutez cette ligne
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $userEntityIds = $user->entities()->pluck('id');
        $favoriteIds = $user->favorites()->pluck('id')->toArray();

        $selectedCategoryId = $request->query('category');
        $searchTerm = $request->query('search');
        $filter = $request->query('filter');
        $selectedTagId = $request->query('tag'); // <-- On récupère le tag sélectionné

        $applicationsQuery = Application::query();

        if ($filter === 'favorites') {
            $applicationsQuery->whereIn('id', $favoriteIds);
        } else {
            $applicationsQuery->where(function ($query) use ($userEntityIds, $user) {
                $query->whereHas('entities', function ($subQuery) use ($userEntityIds) {
                    $subQuery->whereIn('id', $userEntityIds);
                })->orWhereHas('directUsers', function ($subQuery) use ($user) {
                    $subQuery->where('user_id', $user->id);
                });
            });
        }

        $applications = $applicationsQuery->with(['category', 'deeplinks', 'tags']) // <-- Eager load des tags
            ->where('is_active', true)
            ->when($selectedCategoryId, function ($query) use ($selectedCategoryId) {
                return $query->where('category_id', $selectedCategoryId);
            })
            ->when($selectedTagId, function ($query) use ($selectedTagId) { // <-- Logique de filtrage par tag
                $query->whereHas('tags', function ($subQuery) use ($selectedTagId) {
                    $subQuery->where('tags.id', $selectedTagId);
                });
            })
            ->when($searchTerm, function ($query) use ($searchTerm) {
                return $query->where(function ($subQuery) use ($searchTerm) {
                    $subQuery->where('name', 'like', "%{$searchTerm}%")
                        ->orWhere('description', 'like', "%{$searchTerm}%");
                });
            })
            ->orderBy('name')
            ->get();

        // On ne récupère que les tags qui sont réellement utilisés
        $tags = Tag::has('applications')->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        // ... (logique pour mostUsedApplications)
        $mostUsedIds = DB::table('application_clicks')->select('application_id', DB::raw('count(*) as click_count'))->where('user_id', Auth::id())->groupBy('application_id')->orderByDesc('click_count')->limit(3)->pluck('application_id');
        $mostUsedApplications = Application::whereIn('id', $mostUsedIds)->get()->sortBy(function ($app) use ($mostUsedIds) {
            return array_search($app->id, $mostUsedIds->toArray());
        });

        return view('dashboard', [
            'applications' => $applications,
            'categories' => $categories,
            'tags' => $tags, // <-- On envoie les tags à la vue
            'favoriteIds' => $favoriteIds,
            'mostUsedApplications' => $mostUsedApplications
        ]);
    }
}