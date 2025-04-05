<?php

namespace App\Http\Controllers\API;

use App\Models\Commande;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommandeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/commandes",
     *     summary="Afficher toutes les commandes",
     *     tags={"Commandes"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des commandes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Commande")
     *         )
     *     )
     * )
     */

    // Afficher toutes les commandes
    public function index()
    {
        $commandes = Commande::with(['user', 'service', 'supplementGabarit', 'supplementLocalisation'])->get();
        return response()->json($commandes);
    }

    /**
     * @OA\Post(
     *     path="/api/commandes",
     *     summary="Créer une nouvelle commande",
     *     tags={"Commandes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status", "localisation", "prix_total"},
     *             @OA\Property(property="status", type="string", example="en attente"),
     *             @OA\Property(property="localisation", type="string", example="Libreville, Akanda"),
     *             @OA\Property(property="prix_total", type="string", example="15000"),
     *             @OA\Property(property="service_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=2),
     *             @OA\Property(property="supplement_gabarit_id", type="integer", example=1),
     *             @OA\Property(property="supplement_localisation_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Commande créée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Commande créée avec succès."),
     *             @OA\Property(property="commande", ref="#/components/schemas/Commande")
     *         )
     *     )
     * )
     */


    // Créer une nouvelle commande
    public function store(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'localisation' => 'required|string',
            'prix_total' => 'required|string',
            'service_id' => 'nullable|exists:services,id',
            'user_id' => 'nullable|exists:users,id',
            'supplement_gabarit_id' => 'nullable|exists:supplement_gabarits,id',
            'supplement_localisation_id' => 'nullable|exists:supplement_localisations,id',
        ]);

        $commande = Commande::create($validated);

        return response()->json([
            'message' => 'Commande créée avec succès.',
            'commande' => $commande
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/commandes/{id}",
     *     summary="Afficher une commande spécifique",
     *     tags={"Commandes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la commande",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails de la commande",
     *         @OA\JsonContent(ref="#/components/schemas/Commande")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Commande non trouvée"
     *     )
     * )
     */

    // Afficher une commande spécifique
    public function show($id)
    {
        $commande = Commande::with(['user', 'service', 'supplementGabarit', 'supplementLocalisation'])->find($id);

        if (!$commande) {
            return response()->json(['message' => 'Commande non trouvée.'], 404);
        }

        return response()->json($commande);
    }

    /**
     * @OA\Put(
     *     path="/api/commandes/{id}",
     *     summary="Mettre à jour une commande",
     *     tags={"Commandes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la commande à mettre à jour",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="livrée"),
     *             @OA\Property(property="localisation", type="string", example="Owendo"),
     *             @OA\Property(property="prix_total", type="string", example="17000"),
     *             @OA\Property(property="service_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=2),
     *             @OA\Property(property="supplement_gabarit_id", type="integer", example=1),
     *             @OA\Property(property="supplement_localisation_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Commande mise à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Commande mise à jour avec succès."),
     *             @OA\Property(property="commande", ref="#/components/schemas/Commande")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Commande non trouvée"
     *     )
     * )
     */

    // Mettre à jour une commande
    public function update(Request $request, $id)
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json(['message' => 'Commande non trouvée.'], 404);
        }

        $validated = $request->validate([
            'status' => 'sometimes|required|string',
            'localisation' => 'sometimes|required|string',
            'prix_total' => 'sometimes|required|string',
            'service_id' => 'nullable|exists:services,id',
            'user_id' => 'nullable|exists:users,id',
            'supplement_gabarit_id' => 'nullable|exists:supplement_gabarits,id',
            'supplement_localisation_id' => 'nullable|exists:supplement_localisations,id',
        ]);

        $commande->update($validated);

        return response()->json([
            'message' => 'Commande mise à jour avec succès.',
            'commande' => $commande
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/commandes/{id}",
     *     summary="Supprimer une commande",
     *     tags={"Commandes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la commande à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Commande supprimée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Commande supprimée avec succès.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Commande non trouvée"
     *     )
     * )
     */

    // Supprimer une commande
    public function destroy($id)
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json(['message' => 'Commande non trouvée.'], 404);
        }

        $commande->delete();

        return response()->json(['message' => 'Commande supprimée avec succès.']);
    }
}