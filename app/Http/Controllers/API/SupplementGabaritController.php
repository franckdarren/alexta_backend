<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\SupplementGabarit;
use App\Http\Controllers\Controller;

class SupplementGabaritController extends Controller
{
    // Liste de tous les suppléments gabarits
    public function index()
    {
        $supplements = SupplementGabarit::all();
        return response()->json($supplements);
    }

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

    // Afficher un supplément spécifique
    public function show($id)
    {
        $supplement = SupplementGabarit::find($id);

        if (!$supplement) {
            return response()->json(['message' => 'Supplément gabarit non trouvé.'], 404);
        }

        return response()->json($supplement);
    }

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