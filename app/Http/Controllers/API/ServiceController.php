<?php

namespace App\Http\Controllers\API;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    // Afficher tous les services
    public function index()
    {
        $services = Service::all();
        return response()->json($services);
    }

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

    // Afficher un service spécifique
    public function show($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['message' => 'Service non trouvé.'], 404);
        }

        return response()->json($service);
    }

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