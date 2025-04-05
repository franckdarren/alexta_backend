<?php

namespace App\Http\Controllers\API;

use App\Models\Commande;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommandeController extends Controller
{
    // Afficher toutes les commandes
    public function index()
    {
        $commandes = Commande::with(['user', 'service', 'supplementGabarit', 'supplementLocalisation'])->get();
        return response()->json($commandes);
    }

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

    // Afficher une commande spécifique
    public function show($id)
    {
        $commande = Commande::with(['user', 'service', 'supplementGabarit', 'supplementLocalisation'])->find($id);

        if (!$commande) {
            return response()->json(['message' => 'Commande non trouvée.'], 404);
        }

        return response()->json($commande);
    }

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