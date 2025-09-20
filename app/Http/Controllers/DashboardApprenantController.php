<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\SessionLive;
use App\Models\Certificate;

class DashboardApprenantController extends Controller
{
  public function index()
{
    $user = auth()->user();

    $enrollments = $user->enrollments()->with('course')->get();
    $courseIds = $enrollments->pluck('course_id');

    $liveSessions = SessionLive::where('is_active', true)
        ->whereIn('course_id', $courseIds)
        ->get();

    $certificates = $user->certificates()->with('course')->get();

    // ✅ Ajout des formations suivies
   $formations = \App\Models\Inscription::where('user_id', $user->id)
    ->with('formation')
    ->get()
    ->pluck('formation');

    return view('dashboard.apprenant', compact('enrollments', 'liveSessions', 'certificates', 'formations'));
}


    public function courses()
    {
        $user = auth()->user();
        $courses = $user->enrollments()->with('course')->get();
        return view('dashboard.apprenant-courses', compact('courses'));
    }

    public function progression()
    {
        $user = auth()->user();
        $progression = []; // À calculer
        return view('dashboard.apprenant-progression', compact('progression'));
    }

    public function sessionlive()
    {
        $sessions = SessionLive::where('is_active', true)->get();
        return view('dashboard.apprenant-sessionlive', compact('sessions'));
    }

    public function certificates()
    {
        $user = auth()->user();
        $certificates = Certificate::where('user_id', $user->id)->get();
        return view('dashboard.apprenant-certificates', compact('certificates'));
    }
}
