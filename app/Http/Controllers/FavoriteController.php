<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Application $application)
    {
        $user = Auth::user();

        // La magie de Laravel : ajoute/supprime la liaison dans la table pivot
        $user->favorites()->toggle($application->id);

        return response()->json(['status' => 'success']);
    }
}