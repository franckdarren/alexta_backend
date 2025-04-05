<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SupplementLocalisation;

class SupplementLocalisationController extends Controller
{
    // Liste de tous les suppléments de localisation
    public function index()
    {
        return response()->json(SupplementLocalisation::all());
    }

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

    // Voir un supplément spécifique
    public function show($id)
    {
        $supplement = SupplementLocalisation::find($id);

        if (!$supplement) {
            return response()->json(['message' => 'Supplément localisation non trouvé.'], 404);
        }

        return response()->json($supplement);
    }

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