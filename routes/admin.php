<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EntityController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DeeplinkController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ApplicationController; // Ajoutez le use

// Toutes les routes dans ce fichier auront le préfixe /admin et le middleware 'admin'
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// ... route du dashboard

Route::resource('applications', ApplicationController::class);
Route::get('applications/{application}/manage-entities', [ApplicationController::class, 'manageEntitiesShow'])->name('applications.manageEntities.show');
Route::put('applications/{application}/manage-entities', [ApplicationController::class, 'manageEntitiesUpdate'])->name('applications.manageEntities.update');

// Routes pour les Deeplinks, imbriquées dans les applications
Route::resource('applications.deeplinks', DeeplinkController::class)->except(['index', 'show']);

Route::resource('categories', CategoryController::class);
Route::resource('entities', EntityController::class);
Route::resource('tags', TagController::class);

Route::get('users/import', [UserController::class, 'importShow'])->name('users.import.show');
Route::post('users/import', [UserController::class, 'importStore'])->name('users.import.store');
Route::resource('users', UserController::class)->only(['index', 'edit', 'update', 'destroy']);