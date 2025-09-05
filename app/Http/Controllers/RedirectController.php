<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- Ajoutez cette ligne

class RedirectController extends Controller
{
    public function process(Application $application)
    {
        // Enregistre le clic avec l'ID de l'utilisateur et de l'application
        DB::table('application_clicks')->insert([
            'user_id' => Auth::id(),
            'application_id' => $application->id,
            'clicked_at' => now(),
        ]);

        // Redirige l'utilisateur vers la destination finale
        return redirect()->away($application->url);
    }
}