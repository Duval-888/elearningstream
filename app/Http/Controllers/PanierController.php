<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;

class PanierController extends Controller
{
    // Ajouter une formation au panier
   public function add(Request $request)
{
    $formationId = $request->formation_id;
    $panier = session()->get('panier', []);

    if (!in_array($formationId, $panier)) {
        $panier[] = $formationId;
        session()->put('panier', $panier);
    }

    return redirect()->back()->with('success', 'Formation ajoutée au panier.');
}


    // Afficher le contenu du panier
    public function index()
    {
        $formationIds = session()->get('panier', []);
        $formations = Formation::whereIn('id', $formationIds)->get();

        return view('panier.index', compact('formations'));
    }

    public function mesFormations()
{
    $panier = session()->get('panier', []);
    $formations = \App\Models\Formation::whereIn('id', $panier)->get();

    return view('panier.mes-formations', compact('formations'));
}

}
