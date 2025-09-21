<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;

class PanierController extends Controller
{
    // Ajouter une formation au panier
    public function add(Request $request)
    {
        // Validation conseillée
        $request->validate([
            'formation_id' => 'required|integer|exists:formations,id',
        ]);

        $formationId = (int) $request->formation_id;

        // Récupère le panier (tableau d'IDs) et évite les doublons
        $panier = session()->get('panier', []);
        if (!in_array($formationId, $panier, true)) {
            $panier[] = $formationId;
            session()->put('panier', $panier);
        }

        // ✅ Après ajout, on revient au catalogue pour pouvoir continuer à ajouter
        return redirect()->route('test.catalogue')->with('success', 'Ajouté au panier.');
    }

    // Afficher le contenu du panier (si tu l’utilises encore)
    public function index()
    {
        $ids = session()->get('panier', []);
        if (empty($ids)) {
            $formations = collect();
        } else {
            $formations = Formation::whereIn('id', $ids)->get();
        }

        return view('panier.index', compact('formations'));
    }

    // Page "Mes formations" (liste basée sur la session/panier)
    public function mesFormations()
    {
        $ids = session()->get('panier', []);

        if (empty($ids)) {
            $formations = collect();
        } else {
            $formations = Formation::whereIn('id', $ids)
                ->withCount('videos')   // -> videos_count en vue
                ->orderBy('title')
                ->get();
        }

        // ✅ Vue qui affiche la grille cliquable vers le player
        return view('panier.mes-formations', compact('formations'));
    }
}
