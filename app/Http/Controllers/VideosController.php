<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;

class VideosController extends Controller
{
    /** Afficher le formulaire d’ajout */
    public function create($formationId)
    {
        $formation = Formation::findOrFail($formationId);
        return view('videos.create', compact('formation'));
    }

    /** Enregistrer une nouvelle vidéo */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'formation_id'  => 'required|exists:formations,id',

            // Upload direct (petits fichiers)
            'video'         => 'nullable|file|mimes:mp4,mkv,webm,avi,mov,ogg,m4v|max:51200', // 50 Mo

            // YouTube
            'youtube_url'   => 'nullable|url',

            // Upload en chunks (Dropzone)
            'uploaded_path' => 'nullable|string',  // ex: /storage/videos/xxx.ext
            'uploaded_mime' => 'nullable|string',  // ex: video/x-matroska

            'ordre'         => 'nullable|integer',
        ]);

        // ✅ Priorité: chunked → direct file → YouTube
        $videoUrl = null;
        $mime     = null;

        if ($request->filled('uploaded_path')) {
            // Upload en chunks déjà terminé (Dropzone)
            $videoUrl = $request->uploaded_path;
            $mime     = $request->uploaded_mime;
        } elseif ($request->hasFile('video')) {
            // Upload direct (fallback)
            $path = $request->file('video')->store('videos', 'public');
            $videoUrl = '/storage/' . $path;
            $mime     = $request->file('video')->getMimeType();
        } elseif ($request->filled('youtube_url')) {
            // Lien YouTube
            $videoUrl = $request->youtube_url;
            $mime     = null;
        } else {
            return back()
                ->withErrors(['video' => 'Fournis un fichier (chunked/direct) ou un lien YouTube.'])
                ->withInput();
        }

        Video::create([
            'title'         => $request->title,
            'video_url'     => $videoUrl,
            'mime_type'     => $mime, // nullable
            'ordre'         => $request->ordre,
            'formation_id'  => $request->formation_id,
        ]);

        return redirect()
            ->route('formations.videos', $request->formation_id)
            ->with('success', 'Vidéo ajoutée avec succès !');
    }

    /** Éditer une vidéo */
    public function edit(Video $video)
    {
        return view('videos.edit', compact('video'));
    }

    /** Mettre à jour une vidéo */
    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'ordre'         => 'nullable|integer',

            // Direct
            'video'         => 'nullable|file|mimes:mp4,mkv,webm,avi,mov,ogg,m4v|max:51200',

            // YouTube
            'youtube_url'   => 'nullable|url',

            // Chunked
            'uploaded_path' => 'nullable|string',
            'uploaded_mime' => 'nullable|string',
        ]);

        $data = [
            'title' => $request->title,
            'ordre' => $request->ordre,
        ];

        // Remplacement du média si fourni
        if ($request->filled('uploaded_path')) {
            // Nouveau fichier (chunked)
            if ($this->isLocalStorageUrl($video->video_url)) {
                $this->deleteLocalVideo($video->video_url);
            }
            $data['video_url'] = $request->uploaded_path;
            $data['mime_type'] = $request->uploaded_mime;
        } elseif ($request->hasFile('video')) {
            // Nouveau fichier (direct)
            $path = $request->file('video')->store('videos', 'public');
            if ($this->isLocalStorageUrl($video->video_url)) {
                $this->deleteLocalVideo($video->video_url);
            }
            $data['video_url'] = '/storage/' . $path;
            $data['mime_type'] = $request->file('video')->getMimeType();
        } elseif ($request->filled('youtube_url')) {
            // Passage à YouTube
            if ($this->isLocalStorageUrl($video->video_url)) {
                $this->deleteLocalVideo($video->video_url);
            }
            $data['video_url'] = $request->youtube_url;
            $data['mime_type'] = null;
        }

        $video->update($data);

        return redirect()
            ->route('formations.videos', $video->formation_id)
            ->with('success', 'Vidéo mise à jour !');
    }

    /** Supprimer une vidéo */
    public function destroy(Video $video)
    {
        $formationId = $video->formation_id;

        if ($this->isLocalStorageUrl($video->video_url)) {
            $this->deleteLocalVideo($video->video_url);
        }

        $video->delete();

        return redirect()
            ->route('formations.videos', $formationId)
            ->with('success', 'Vidéo supprimée.');
    }

    /* ============= Chunk Upload (Dropzone) ============= */

    /** Réception des chunks et assemblage */
    public function storeChunk(Request $request)
    {
        // ⚠️ Doit matcher Dropzone paramName (dans ta vue j’ai mis paramName: 'file')
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            return response()->json(['error' => 'Aucun fichier'], 400);
        }

        $save = $receiver->receive(); // reçoit le chunk courant

        if ($save->isFinished()) {
            // Upload terminé → on assemble & sauvegarde
            $file = $save->getFile();                  // \Illuminate\Http\UploadedFile
            $path = $file->store('videos', 'public');  // storage/app/public/videos/...
            $mime = $file->getMimeType();
            $file->delete();                           // nettoie le tmp

            return response()->json([
                'ok'   => true,
                'path' => '/storage/'.$path,
                'mime' => $mime,
            ], 200);
        }

        // Encore des chunks à recevoir
        $handler = $save->handler();
        return response()->json(['done' => $handler->getPercentageDone()], 202);
    }

    /* ============= Helpers ============= */

    /** Détecte si l’URL pointe vers le disque public (fichier local) */
    private function isLocalStorageUrl(?string $url): bool
    {
        if (!$url) return false;
        return str_starts_with($url, '/storage/');
    }

    /** Supprime le fichier local correspondant à l’URL /storage/... */
    private function deleteLocalVideo(string $publicUrl): void
    {
        $relativePath = ltrim(str_replace('/storage/', '', $publicUrl), '/');
        if ($relativePath) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
