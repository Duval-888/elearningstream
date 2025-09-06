<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\LiveSession;
use App\Models\Certificate;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Middleware d'authentification seulement
    }

    public function apprenant()
    {
        $user = auth()->user();
        
        // Données par défaut pour éviter les erreurs
        $courses = collect(); // Variable attendue par la vue
        $progression = 0;
        $notifications = collect();
        $certificates = collect();

        // Si les tables existent, récupérer les vraies données
        try {
            $courses = Course::published()->latest()->get();
            $certificates = Certificate::where('user_id', $user->id)
                                      ->with('course')
                                      ->latest()
                                      ->get();
        } catch (\Exception $e) {
            // Si les tables n'existent pas encore, utiliser des données par défaut
        }

        return view('dashboard.apprenant', compact('courses', 'progression', 'notifications', 'certificates'));
    }

    public function formateur()
    {
        $user = auth()->user();
        
        // Données par défaut
        $courses = collect();
        $students = collect();

        try {
            // Get instructor's courses
            $courses = Course::where('instructor_id', $user->id)->get();
            $students = User::where('role', 'apprenant')->get();
        } catch (\Exception $e) {
            // Tables pas encore créées
        }

        return view('dashboard.formateur', compact('courses', 'students'));
    }

    public function admin()
    {
        // Get all users
        $users = User::latest()->paginate(15);

        // Get system statistics avec gestion d'erreur
        $stats = [
            'total_users' => User::count(),
            'students' => User::where('role', 'apprenant')->count(),
            'instructors' => User::where('role', 'formateur')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'total_courses' => 0,
            'published_courses' => 0,
            'total_enrollments' => 0,
            'live_sessions' => 0,
            'certificates_issued' => 0,
        ];

        $recentEnrollments = collect();
        $recentCourses = collect();

        try {
            $stats['total_courses'] = Course::count();
            $stats['published_courses'] = Course::where('is_published', true)->count();
            $stats['total_enrollments'] = Enrollment::count();
            $stats['live_sessions'] = LiveSession::count();
            $stats['certificates_issued'] = Certificate::count();

            $recentEnrollments = Enrollment::with('user', 'course')
                                         ->latest()
                                         ->limit(10)
                                         ->get();

            $recentCourses = Course::with('instructor')
                                  ->latest()
                                  ->limit(5)
                                  ->get();
        } catch (\Exception $e) {
            // Tables pas encore créées
        }

        return view('dashboard.admin', compact('users', 'stats', 'recentEnrollments', 'recentCourses'));
    }

    public function formation()
    {
        try {
            $formations = Course::all();
        } catch (\Exception $e) {
            $formations = collect();
        }
        
        return view('dashboard.formation', compact('formations'));
    }

    public function sessionlive()
    {
        try {
            $sessions = LiveSession::all();
        } catch (\Exception $e) {
            $sessions = collect();
        }
        
        return view('dashboard.sessionlive', compact('sessions'));
    }

    public function forums()
    {
        return app(ForumController::class)->index();
    }

    public function chat()
    {
        return app(ChatController::class)->index();
    }

    public function editUser(User $user)
    {
        // Seuls les admins peuvent modifier les utilisateurs
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        // Seuls les admins peuvent modifier les utilisateurs
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:apprenant,formateur,admin',
            'is_active' => 'boolean'
        ]);

        $user->update($request->only(['name', 'email', 'role', 'is_active']));

        return redirect()->route('dashboard.admin')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function deleteUser(User $user)
    {
        // Seuls les admins peuvent supprimer les utilisateurs
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }
        
        // Empêcher la suppression de son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->route('dashboard.admin')->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }
        
        $user->delete();
        return redirect()->route('dashboard.admin')->with('success', 'Utilisateur supprimé avec succès.');
    }
}