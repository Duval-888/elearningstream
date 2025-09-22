<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Course; // <= important

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
        // tous les cours créés par ce formateur (id + title)
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
            'course_id'    => ['required', 'exists:courses,id'], // <= attache à un cours
        ]);

        $data['user_id'] = $request->user()->id;
        $data['is_published'] = (bool)($data['is_published'] ?? false);

        $quiz = Quiz::create($data);

        return redirect()
            ->route('formateur.quizzes.edit', $quiz)
            ->with('success', 'Quiz créé. Ajoute des questions maintenant.');
    }

    public function edit(Request $request, Quiz $quiz)
    {
        abort_unless($quiz->user_id === $request->user()->id, 403);

        $quiz->load('questions');

        // utile si tu veux permettre de changer le cours dans l’édition
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
            'course_id'    => ['required', 'exists:courses,id'], // <= si tu l’édite aussi
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
}
