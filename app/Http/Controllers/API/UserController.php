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
     * @OA\Get(
     *     path="/api/users",
     *     summary="Lister tous les utilisateurs",
     *     tags={"User"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des utilisateurs",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
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
     * @OA\Post(
     *     path="/api/users",
     *     summary="Créer un nouvel utilisateur",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom", "email", "role", "password"},
     *             @OA\Property(property="nom", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="role", type="string", example="Client"),
     *             @OA\Property(property="password", type="string", example="password123"),
     *             @OA\Property(property="telephone", type="string", example="123456789"),
     *             @OA\Property(property="adresse", type="string", example="123 rue de Paris"),
     *             @OA\Property(property="zone_intervention", type="string", example="Paris"),
     *             @OA\Property(property="ajoute_par", type="string", example="admin"),
     *             @OA\Property(property="team", type="string", example="Equipe 1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Utilisateur créé avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides"
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Afficher un utilisateur spécifique",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur trouvé",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Mettre à jour un utilisateur",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nom", type="string", example="John Smith"),
     *             @OA\Property(property="role", type="string", example="Superviseur"),
     *             @OA\Property(property="telephone", type="string", example="987654321"),
     *             @OA\Property(property="adresse", type="string", example="456 rue de Paris"),
     *             @OA\Property(property="zone_intervention", type="string", example="Lyon"),
     *             @OA\Property(property="disponibilite", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur mis à jour",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Supprimer un utilisateur",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     )
     * )
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

    /**
     * @OA\Get(
     *     path="/api/users/{id}/commandes",
     *     summary="Afficher les commandes d'un utilisateur",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liste des commandes de l'utilisateur",
     *         @OA\JsonContent(type="array", @OA\Items(type="string"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     )
     * )
     */
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