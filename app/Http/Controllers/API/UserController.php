<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Lister tous les users
        try {
            return response()->json(User::all(), 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erreur serveur'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'role' => 'required|in:Administrateur,Superviseur,Client',
                'password' => 'required|string|min:6',
            ]);

            $user = User::create([
                'nom' => $validatedData['nom'],
                'email' => $validatedData['email'],
                'role' => $validatedData['role'],
                'password' => bcrypt($validatedData['password']),

                'telephone' => $request->telephone,
                'adresse' => $request->adresse,
                'zone_intervention' => $request->zone_intervention,
                'disponibilite' => true,
                'ajoute_par' => $request->ajoute_par,
                'team' => $request->team,

            ]);

            return response()->json($user->makeHidden(['password']), 201);
        } catch (Exception $e) {
            // return response()->json(['error' => 'Impossible de créer l\'utilisateur'], 500);
            return $e;
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Afficher un utilisateur spécifique
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $validatedData = $request->validate([
                'nom' => 'string|max:255',
                'password' => 'nullable|string|min:6',

                'role' => 'string|max:255',
                'telephone' => 'nullable|string|max:255',
                'adresse' => 'nullable|string|max:255',
                'zone_intervention' => 'nullable|string|max:255',
                'disponibilite' => 'boolean',
                'ajoute_par' => 'nullable|string|max:255',
                'team' => 'nullable|string|max:255',

            ]);

            $user->update($validatedData);
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
                $user->save();
            }
            return response()->json($user, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Utilisateur non trouvé'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erreur serveur'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['message' => 'Utilisateur supprimé avec succès'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Utilisateur non trouvé'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erreur serveur'], 500);
        }
    }


    public function commandes(string $id)
    {
        //Supprimer un user
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $commandes = $user->commandes();

        return response()->json($commandes, 200);
    }




}
