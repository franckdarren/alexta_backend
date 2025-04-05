<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SupplementLocalisation;

class SupplementLocalisationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/supplements-localisation",
     *     summary="Afficher tous les suppléments de localisation",
     *     tags={"SupplementLocalisation"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des suppléments de localisation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/SupplementLocalisation")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur interne du serveur"
     *     )
     * )
     */

    // Liste de tous les suppléments de localisation
    public function index()
    {
        return response()->json(SupplementLocalisation::all());
    }

    /**
     * @OA\Post(
     *     path="/api/supplements-localisation",
     *     summary="Créer un supplément de localisation",
     *     tags={"SupplementLocalisation"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"lieu", "montant"},
     *             @OA\Property(property="lieu", type="string", example="Paris"),
     *             @OA\Property(property="montant", type="integer", example=15000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Supplément de localisation créé avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/SupplementLocalisation")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides"
     *     )
     * )
     */

    // Créer un nouveau supplément de localisation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lieu' => 'required|string|max:255',
            'montant' => 'required|integer|min:0',
        ]);

        $supplement = SupplementLocalisation::create($validated);

        return response()->json([
            'message' => 'Supplément localisation créé avec succès.',
            'supplement' => $supplement
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/supplements-localisation/{id}",
     *     summary="Afficher un supplément de localisation spécifique",
     *     tags={"SupplementLocalisation"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du supplément de localisation",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Supplément de localisation trouvé",
     *         @OA\JsonContent(ref="#/components/schemas/SupplementLocalisation")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Supplément de localisation non trouvé"
     *     )
     * )
     */

    // Voir un supplément spécifique
    public function show($id)
    {
        $supplement = SupplementLocalisation::find($id);

        if (!$supplement) {
            return response()->json(['message' => 'Supplément localisation non trouvé.'], 404);
        }

        return response()->json($supplement);
    }

    /**
     * @OA\Put(
     *     path="/api/supplements-localisation/{id}",
     *     summary="Mettre à jour un supplément de localisation",
     *     tags={"SupplementLocalisation"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du supplément de localisation",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="lieu", type="string", example="Lyon"),
     *             @OA\Property(property="montant", type="integer", example=20000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Supplément de localisation mis à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/SupplementLocalisation")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Supplément de localisation non trouvé"
     *     )
     * )
     */

    // Modifier un supplément
    public function update(Request $request, $id)
    {
        $supplement = SupplementLocalisation::find($id);

        if (!$supplement) {
            return response()->json(['message' => 'Supplément localisation non trouvé.'], 404);
        }

        $validated = $request->validate([
            'lieu' => 'sometimes|required|string|max:255',
            'montant' => 'sometimes|required|integer|min:0',
        ]);

        $supplement->update($validated);

        return response()->json([
            'message' => 'Supplément localisation mis à jour avec succès.',
            'supplement' => $supplement
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/supplements-localisation/{id}",
     *     summary="Supprimer un supplément de localisation",
     *     tags={"SupplementLocalisation"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du supplément de localisation",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Supplément de localisation supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Supplément de localisation non trouvé"
     *     )
     * )
     */

    // Supprimer un supplément
    public function destroy($id)
    {
        $supplement = SupplementLocalisation::find($id);

        if (!$supplement) {
            return response()->json(['message' => 'Supplément localisation non trouvé.'], 404);
        }

        $supplement->delete();

        return response()->json(['message' => 'Supplément localisation supprimé avec succès.']);
    }
}