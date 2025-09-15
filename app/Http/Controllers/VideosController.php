<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;


class VideosController extends Controller

{
    public function create($formationId)
{
    $formation = Formation::findOrFail($formationId);
    return view('videos.create', compact('formation'));
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'video' => 'required|mimes:mp4|max:51200',
        'formation_id' => 'required|exists:formations,id',
    ]);

    $path = $request->file('video')->store('videos', 'public');

    Video::create([
        'title' => $request->title,
        'video_url' => '/storage/' . $path,
        'ordre' => $request->ordre,
        'formation_id' => $request->formation_id,
    ]);

    return redirect()->route('formations.show', $request->formation_id)->with('success', 'Vidéo ajoutée avec succès !');
}

    public function edit(Video $video)
    {
        return view('videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'ordre' => 'nullable|integer',
            'video' => 'nullable|mimes:mp4|max:51200',
        ]);

        $data = [
            'title' => $request->title,
            'ordre' => $request->ordre,
        ];

        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('videos', 'public');
            $data['video_url'] = Storage::url($path);
        }

        $video->update($data);

        return redirect()->route('formations.show', $video->formation_id)->with('success', 'Vidéo mise à jour !');
    }

    public function destroy(Video $video)
    {
        $formationId = $video->formation_id;
        $video->delete();

        return redirect()->route('formations.show', $formationId)->with('success', 'Vidéo supprimée.');
    }

}