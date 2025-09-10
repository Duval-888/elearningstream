<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Course;
class DashboardFormateurController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $courses = Course::where('instructor_id', $user->id)->with('enrollments.user')->get();
        return view('dashboard.formateur', compact('courses'));
    }
}
