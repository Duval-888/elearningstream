<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::where('creator_id', auth()->id())->get();
        return view('formations.index', compact('formations'));
    }

    public function create()
    {
        return view('formations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'level' => 'required',
            'price' => 'required|numeric',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title) . '-' . uniqid(); // Slug unique
        $data['creator_id'] = auth()->id();

        Formation::create($data);

        return redirect()->route('formations.index')->with('success', 'Formation créée avec succès !');
    }

    public function edit(Formation $formation)
    {
        return view('formations.edit', compact('formation'));
    }

    public function update(Request $request, Formation $formation)
    {
        $request->validate([
            'title' => 'required',
            'level' => 'required',
            'price' => 'required|numeric',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title) . '-' . uniqid(); // Regénère le slug si le titre change

        $formation->update($data);

        return redirect()->route('formations.index')->with('success', 'Formation mise à jour !');
    }

    public function destroy(Formation $formation)
    {
        $formation->delete();
        return redirect()->route('formations.index')->with('success', 'Formation supprimée.');
    }
}
