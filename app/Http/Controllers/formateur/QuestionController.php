<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;

class QuestionController extends Controller
{
    public function store(Request $request, Quiz $quiz)
    {
        abort_unless($quiz->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'prompt'         => ['required', 'string'],
            'type'           => ['required', 'in:single,multiple,text'],
            'options'        => ['nullable', 'array'],
            'correct_answer' => ['nullable', 'string'],
            'points'         => ['nullable', 'integer', 'min:1'],
            'ordre'          => ['nullable', 'integer', 'min:1'],
        ]);

        $data['points'] = $data['points'] ?? 1;
        $data['ordre']  = $data['ordre']  ?? ($quiz->questions()->max('ordre') + 1 ?? 1);

        $quiz->questions()->create($data);

        return back()->with('success', 'Question ajoutée.');
    }

    public function update(Request $request, Question $question)
    {
        $quiz = $question->quiz;
        abort_unless($quiz->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'prompt'         => ['required', 'string'],
            'type'           => ['required', 'in:single,multiple,text'],
            'options'        => ['nullable', 'array'],
            'correct_answer' => ['nullable', 'string'],
            'points'         => ['nullable', 'integer', 'min:1'],
            'ordre'          => ['nullable', 'integer', 'min:1'],
        ]);

        $question->update($data);

        return back()->with('success', 'Question mise à jour.');
    }

    public function destroy(Request $request, Question $question)
    {
        $quiz = $question->quiz;
        abort_unless($quiz->user_id === $request->user()->id, 403);

        $question->delete();

        return back()->with('success', 'Question supprimée.');
    }
}
