<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Inscription; // 🔹 Import du modèle

class InscriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'formation_id' => 'required|exists:formations,id',
        ]);

        $already = Inscription::where('user_id', auth()->id())
            ->where('formation_id', $request->formation_id)
            ->exists();

        if ($already) {
            return back()->with('error', 'Vous êtes déjà inscrit à cette formation.');
        }

        Inscription::create([
            'user_id' => auth()->id(),
            'formation_id' => $request->formation_id,
        ]);

        return back()->with('success', 'Inscription réussie !');
    }

    public function index()
{
    $inscriptions = Inscription::with('user', 'formation')->get();
    return view('inscriptions.index', compact('inscriptions'));
}

}

