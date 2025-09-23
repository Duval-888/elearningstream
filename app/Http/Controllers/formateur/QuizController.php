<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Course;
use App\Models\Video;
use App\Models\Formation;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $quizzes = Quiz::where('user_id', $request->user()->id)
            ->withCount('questions')
            ->latest()
            ->paginate(12);

        return view('formateur.quiz.index', compact('quizzes'));
    }

    public function create(Request $request)
    {
        // Tous les cours créés par ce formateur (id + title)
        $courses = Course::where('user_id', $request->user()->id)
            ->orderBy('title')
            ->get(['id','title']);

        return view('formateur.quiz.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'is_published' => ['nullable', 'boolean'],
            'course_id'    => ['required', 'exists:courses,id'], // attache à un cours
        ]);

        $data['user_id'] = $request->user()->id;
        $data['is_published'] = (bool)($data['is_published'] ?? false);

        $quiz = Quiz::create($data);

        // $video n’existe pas ici ; on redirige vers l’index ou l’édition du quiz
        return redirect()
            ->route('formateur.quizzes') // adapte si tu as une route d’édition: formateur.quizzes.edit
            ->with('success', 'Quiz créé avec succès.');
    }

    public function edit(Request $request, Quiz $quiz)
    {
        abort_unless($quiz->user_id === $request->user()->id, 403);

        $quiz->load('questions');

        // Utile pour permettre de changer le cours dans l’édition
        $courses = Course::where('user_id', $request->user()->id)
            ->orderBy('title')
            ->get(['id','title']);

        return view('formateur.quiz.edit', compact('quiz','courses'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        abort_unless($quiz->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'is_published' => ['nullable', 'boolean'],
            'course_id'    => ['required', 'exists:courses,id'],
        ]);

        $quiz->update([
            'title'        => $data['title'],
            'description'  => $data['description'] ?? null,
            'is_published' => (bool)($data['is_published'] ?? false),
            'course_id'    => $data['course_id'],
        ]);

        return back()->with('success', 'Quiz mis à jour.');
    }

    public function destroy(Request $request, Quiz $quiz)
    {
        abort_unless($quiz->user_id === $request->user()->id, 403);

        $quiz->delete();

        return redirect()
            ->route('formateur.quizzes')
            ->with('success', 'Quiz supprimé.');
    }

    /** ✅ Enregistrement d’un quiz rattaché à UNE vidéo */
    public function storeForVideo(Request $request, Video $video)
    {
        $userId = $request->user()->id;
        $creatorId = optional($video->formation)->creator_id ?? null;
        abort_unless($creatorId === $userId, 403);

        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $quiz = Quiz::create([
            'user_id'      => $userId,
            'video_id'     => $video->id, // lien direct à la vidéo
            'title'        => $data['title'],
            'description'  => $data['description'] ?? null,
            'is_published' => (bool)($data['is_published'] ?? false),
        ]);

        return redirect()
            ->route('formations.videos', $video->formation_id) // adapte selon tes routes
            ->with('success', 'Quiz créé et lié à la vidéo.');
    }

    /** Vérifie que l'user peut gérer cette vidéo (propriétaire de la formation ou admin) */
    private function authorizeVideo(\App\Models\User $user, Video $video): void
    {
        $formation = $video->formation; // nécessite la relation Video::formation()

        // Essaie plusieurs conventions possibles : creator_id, user_id, instructor_id
        $ownerId = $formation->creator_id
            ?? $formation->user_id
            ?? $formation->instructor_id
            ?? null;

        $isOwner = $ownerId && ($ownerId === $user->id);
        $isAdmin = ($user->role ?? null) === 'admin';
        $isFormateurOwner = ($user->role ?? null) === 'formateur' && $isOwner;

        if (!($isAdmin || $isFormateurOwner)) {
            abort(403, 'Accès refusé à cette vidéo.');
        }
    }

    /** Formulaire: créer un quiz POUR une vidéo donnée */
    public function createForVideo(Request $request, Video $video)
    {
        $this->authorizeVideo($request->user(), $video);

        // On peut réutiliser la vue "create" en lui passant $video
        return view('formateur.quiz.create', [
            'video'     => $video,
            'formation' => $video->formation,
        ]);
    }
}
