<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Category;
use App\Models\Entity;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'userCount' => User::count(),
            'applicationCount' => Application::count(),
            'categoryCount' => Category::count(),
            'entityCount' => Entity::count(), // Assurez-vous d'avoir un modèle Entity
        ];

        return view('admin.dashboard', compact('stats'));
    }
}