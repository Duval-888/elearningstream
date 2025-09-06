<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:apprenant');
    }

    /**
     * Store a new enrollment
     */
    public function store(Course $course)
    {
        $user = auth()->user();

        // Check if already enrolled
        $existingEnrollment = Enrollment::where('user_id', $user->id)
                                       ->where('course_id', $course->id)
                                       ->first();

        if ($existingEnrollment) {
            return back()->with('error', 'Vous êtes déjà inscrit à ce cours.');
        }

        // Check if course is published
        if (!$course->is_published) {
            return back()->with('error', 'Ce cours n\'est pas disponible pour l\'inscription.');
        }

        // Check max students limit
        if ($course->max_students && $course->enrollments()->count() >= $course->max_students) {
            return back()->with('error', 'Ce cours a atteint sa capacité maximale.');
        }

        // Create enrollment
        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        return back()->with('success', 'Inscription réussie! Vous pouvez maintenant accéder au contenu du cours.');
    }

    /**
     * Remove enrollment
     */
    public function destroy(Course $course)
    {
        $user = auth()->user();

        $enrollment = Enrollment::where('user_id', $user->id)
                               ->where('course_id', $course->id)
                               ->first();

        if (!$enrollment) {
            return back()->with('error', 'Vous n\'êtes pas inscrit à ce cours.');
        }

        $enrollment->delete();

        return back()->with('success', 'Désinscription réussie.');
    }

    /**
     * Update progress
     */
    public function updateProgress(Request $request, Course $course)
    {
        $user = auth()->user();

        $enrollment = Enrollment::where('user_id', $user->id)
                               ->where('course_id', $course->id)
                               ->first();

        if (!$enrollment) {
            return response()->json(['error' => 'Non inscrit à ce cours'], 403);
        }

        $validated = $request->validate([
            'progress' => 'required|numeric|min:0|max:100'
        ]);

        $enrollment->updateProgress($validated['progress']);

        return response()->json([
            'success' => true,
            'progress' => $enrollment->fresh()->progress,
            'completed' => $enrollment->fresh()->isCompleted()
        ]);
    }
}