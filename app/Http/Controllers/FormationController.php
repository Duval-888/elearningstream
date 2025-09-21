<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Inscription;

class FormationController extends Controller
{
  public function landing()
{
    $formations = Formation::all();
    return view('courses.formation', compact('formations'));

}

public function index()
{
    $formations = Formation::all();
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
            'video_url' => 'nullable|url|regex:/^https:\/\/(www\.)?youtube\.com\/watch\?v=.+$/',
        'cover_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title) . '-' . uniqid(); // Slug unique
        $data['creator_id'] = auth()->id();

        if ($request->hasFile('cover_image')) {
        $path = $request->file('cover_image')->store('formations', 'public');
        $data['cover_image'] = $path;
    }

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
            'video_url' => 'nullable|url|regex:/^https:\/\/(www\.)?youtube\.com\/watch\?v=.+$/',
        'cover_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title) . '-' . uniqid(); // Regénère le slug si le titre change
        if ($request->hasFile('cover_image')) {
        $path = $request->file('cover_image')->store('formations', 'public');
        $data['cover_image'] = $path;
    }

        $formation->update($data);

        return redirect()->route('formations.index')->with('success', 'Formation mise à jour !');
    }
    public function watch(\App\Models\Formation $formation)
{
    // Récupère les vidéos triées
    $videos = $formation->videos()->orderBy('ordre')->get();

    return view('formations.watch', compact('formation', 'videos'));
}


    public function destroy(Formation $formation)
    {
        $formation->delete();
        return redirect()->route('formations.index')->with('success', 'Formation supprimée.');
    }

public function mesFormations()
{
    $formationIds = Inscription::where('user_id', auth()->id())->pluck('formation_id');
$formations = Formation::whereIn('id', $formationIds)->withCount('videos')->get();

    return view('formations.mes', compact('formations'));
}

public function inscrits(Formation $formation)
{
    $inscriptions = $formation->inscriptions()->with('user')->get();
    return view('formations.inscrits', compact('formation', 'inscriptions'));
}

public function dashboard()
{
    $formations = Formation::where('creator_id', auth()->id())->withCount('inscriptions')->get();

    $stats = [
        'courses_count' => $formations->count(),
        'live_sessions_count' => 0,
        'students_count' => Inscription::whereIn('formation_id', $formations->pluck('id'))->count(),
    ];

    $recentCourses = $formations->sortByDesc('created_at')->take(5);

    // ✅ Ajoute 'formations' ici
    return view('dashboard.formateur', compact('formations', 'stats', 'recentCourses'));
}
public function show(Formation $formation)
{
    $videosTotal = $formation->videos()->count();
    $videosVues = $formation->videos()
        ->whereIn('id', auth()->user()->videosVues->pluck('id'))
        ->count();

    $progression = $videosTotal > 0 ? round(($videosVues / $videosTotal) * 100) : 0;

    return view('formations.show', compact('formation', 'progression'));
}

public function certificat(Formation $formation)
{
    $videosTotal = $formation->videos()->count();
    $videosVues = $formation->videos()
        ->whereIn('id', auth()->user()->videosVues->pluck('id'))
        ->count();

    $progression = $videosTotal > 0 ? round(($videosVues / $videosTotal) * 100) : 0;

    if ($progression < 100) {
        abort(403, 'Formation non complétée.');
    }

    // Ici tu peux générer ou afficher le certificat
    return view('formations.certificat', compact('formation'));
}

public function gererVideos(Formation $formation)
{
    // Vérifie que l'utilisateur est bien le créateur
    if (auth()->id() !== $formation->creator_id) {
        abort(403);
    }

    $videos = $formation->videos()->orderBy('ordre')->get();

    return view('formations.gerer-videos', compact('formation', 'videos'));
}

}
