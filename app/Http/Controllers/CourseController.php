<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course; // <-- important

class CourseController extends Controller
{
    public function index()
    {
        return view('courses.formation');
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category'    => ['required', 'string', 'max:100'],
        ]);

        $course = Course::create([
            'title'         => $data['title'],
            'description'   => $data['description'] ?? null,
            'slug'          => \Illuminate\Support\Str::slug($data['title']),
            'category'      => $data['category'],
            'instructor_id' => auth()->id() ?? 1,
        ]);

        // redirige vers la page de détails du cours
        return redirect()->route('courses.show', $course)->with('success', 'Cours créé avec succès.');
    }

    // ✅ Ajoute ceci :
    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }
}
