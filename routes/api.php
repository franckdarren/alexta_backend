<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\CommandeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/users', [UserController::class, 'store']);  // Créer un nouvel utilisateur

Route::middleware('auth:sanctum')->group(function () {

    // Actions utilisateurs
    Route::get('/users', [UserController::class, 'index']);   // Liste tous les utilisateurs
    Route::get('/users/{id}', [UserController::class, 'show']); // Afficher un utilisateur spécifique
    Route::put('/users/{id}', [UserController::class, 'update']); // Mettre à jour un utilisateur
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // Supprimer un utilisateur

    Route::get('/users/{id}/commandes', [UserController::class, 'commandes']); // Lister les commandes

    // Gestion des Services
    Route::prefix('services')->group(function () {
        Route::get('/', [ServiceController::class, 'index']); // Récupérer toutes les services
        Route::get('{id}', [ServiceController::class, 'show']); // Récupérer un service par son ID
        Route::post('/', [ServiceController::class, 'store']); // Créer un nouveau service
        Route::put('{id}', [ServiceController::class, 'update']); // Mettre à jour un service
        Route::delete('{id}', [ServiceController::class, 'destroy']); // Supprimer un service
    });

    // Gestion des Commandes
    Route::prefix('commandes')->group(function () {
        Route::get('/', [CommandeController::class, 'index']); // Récupérer toutes les commandes
        Route::get('{id}', [CommandeController::class, 'show']); // Récupérer une commande par son ID
        Route::post('/', [CommandeController::class, 'store']); // Créer un nouvelle commande
        Route::put('{id}', [CommandeController::class, 'update']); // Mettre à jour une commande
        Route::delete('{id}', [CommandeController::class, 'destroy']); // Supprimer une commande
    });

});