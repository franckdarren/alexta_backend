<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\SupplementGabarit;
use App\Http\Controllers\Controller;

class SupplementGabaritController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/supplements",
     *     summary="Afficher tous les suppléments gabarits",
     *     tags={"SupplementGabarit"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des suppléments gabarits",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/SupplementGabarit")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur interne du serveur"
     *     )
     * )
     */

    // Liste de tous les suppléments gabarits
    public function index()
    {
        $supplements = SupplementGabarit::all();
        return response()->json($supplements);
    }

    /**
     * @OA\Post(
     *     path="/api/supplements",
     *     summary="Créer un supplément gabarit",
     *     tags={"SupplementGabarit"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"type", "montant"},
     *             @OA\Property(property="type", type="string", example="Type B"),
     *             @OA\Property(property="montant", type="integer", example=150)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Supplément gabarit créé avec succès",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/SupplementGabarit"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides"
     *     )
     * )
     */

    // Créer un supplément gabarit
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'montant' => 'required|integer|min:0',
        ]);

        $supplement = SupplementGabarit::create($validated);

        return response()->json([
            'message' => 'Supplément gabarit créé avec succès.',
            'supplement' => $supplement
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/supplements/{id}",
     *     summary="Afficher un supplément gabarit spécifique",
     *     tags={"SupplementGabarit"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du supplément gabarit",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Supplément gabarit trouvé",
     *         @OA\JsonContent(ref="#/components/schemas/SupplementGabarit")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Supplément gabarit non trouvé"
     *     )
     * )
     */

    // Afficher un supplément spécifique
    public function show($id)
    {
        $supplement = SupplementGabarit::find($id);

        if (!$supplement) {
            return response()->json(['message' => 'Supplément gabarit non trouvé.'], 404);
        }

        return response()->json($supplement);
    }

    /**
     * @OA\Put(
     *     path="/api/supplements/{id}",
     *     summary="Mettre à jour un supplément gabarit",
     *     tags={"SupplementGabarit"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du supplément gabarit",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="type", type="string", example="Type C"),
     *             @OA\Property(property="montant", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Supplément gabarit mis à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/SupplementGabarit")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Supplément gabarit non trouvé"
     *     )
     * )
     */

    // Mettre à jour un supplément
    public function update(Request $request, $id)
    {
        $supplement = SupplementGabarit::find($id);

        if (!$supplement) {
            return response()->json(['message' => 'Supplément gabarit non trouvé.'], 404);
        }

        $validated = $request->validate([
            'type' => 'sometimes|required|string|max:255',
            'montant' => 'sometimes|required|integer|min:0',
        ]);

        $supplement->update($validated);

        return response()->json([
            'message' => 'Supplément gabarit mis à jour avec succès.',
            'supplement' => $supplement
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/supplements/{id}",
     *     summary="Supprimer un supplément gabarit",
     *     tags={"SupplementGabarit"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du supplément gabarit",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Supplément gabarit supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Supplément gabarit non trouvé"
     *     )
     * )
     */

    // Supprimer un supplément
    public function destroy($id)
    {
        $supplement = SupplementGabarit::find($id);

        if (!$supplement) {
            return response()->json(['message' => 'Supplément gabarit non trouvé.'], 404);
        }

        $supplement->delete();

        return response()->json(['message' => 'Supplément gabarit supprimé avec succès.']);
    }
}