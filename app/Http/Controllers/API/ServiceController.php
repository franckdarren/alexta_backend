<?php

namespace App\Http\Controllers\API;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/services",
     *     summary="Afficher tous les services",
     *     tags={"Services"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des services",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Service")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur interne du serveur"
     *     )
     * )
     */

    // Afficher tous les services
    public function index()
    {
        $services = Service::all();
        return response()->json($services);
    }

    /**
     * @OA\Post(
     *     path="/api/services",
     *     summary="Créer un nouveau service",
     *     tags={"Services"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom", "description", "prix_base"},
     *             @OA\Property(property="nom", type="string", example="Service de nettoyage"),
     *             @OA\Property(property="description", type="string", example="Service de nettoyage à domicile"),
     *             @OA\Property(property="prix_base", type="integer", example=2000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Service créé avec succès",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Service"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides"
     *     )
     * )
     */

    // Créer un nouveau service
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix_base' => 'required|integer|min:0',
        ]);

        $service = Service::create($validated);

        return response()->json([
            'message' => 'Service créé avec succès.',
            'service' => $service
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/services/{id}",
     *     summary="Afficher un service spécifique",
     *     tags={"Services"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du service",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Service trouvé",
     *         @OA\JsonContent(ref="#/components/schemas/Service")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service non trouvé"
     *     )
     * )
     */

    // Afficher un service spécifique
    public function show($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['message' => 'Service non trouvé.'], 404);
        }

        return response()->json($service);
    }

    /**
     * @OA\Put(
     *     path="/api/services/{id}",
     *     summary="Mettre à jour un service",
     *     tags={"Services"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du service",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nom", type="string", example="Service de nettoyage amélioré"),
     *             @OA\Property(property="description", type="string", example="Service de nettoyage à domicile amélioré"),
     *             @OA\Property(property="prix_base", type="integer", example=2500)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Service mis à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Service")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service non trouvé"
     *     )
     * )
     */

    // Mettre à jour un service
    public function update(Request $request, $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['message' => 'Service non trouvé.'], 404);
        }

        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'prix_base' => 'sometimes|required|integer|min:0',
        ]);

        $service->update($validated);

        return response()->json([
            'message' => 'Service mis à jour avec succès.',
            'service' => $service
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/services/{id}",
     *     summary="Supprimer un service",
     *     tags={"Services"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du service",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Service supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service non trouvé"
     *     )
     * )
     */

    // Supprimer un service
    public function destroy($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['message' => 'Service non trouvé.'], 404);
        }

        $service->delete();

        return response()->json(['message' => 'Service supprimé avec succès.']);
    }
}