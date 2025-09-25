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

    // Collections vides par défaut si pas connecté (tu as dit que les routes ne sont pas protégées pour l’instant)
    $enrollments   = collect();
    $liveSessions  = collect();
    $certificates  = collect();
    $formations    = collect();

    if ($user) {
        $enrollments  = $user->enrollments()->with('course')->get();

        // adapte ces colonnes à ton modèle LiveSession si besoin
        $liveSessions = \App\Models\LiveSession::query()
            ->where('is_recorded', false)
            ->where('status', 'live')
            ->when($enrollments->isNotEmpty(), function ($q) use ($enrollments) {
                $q->whereIn('course_id', $enrollments->pluck('course_id'));
            })
            ->get();

        $certificates = $user->certificates()->with('course')->get();

        // ✅ récupère les formations suivies (via ta relation belongsToMany 'formations' sur User)
        // et pré-calcule le compteur de vidéos pour éviter un N+1
        $formations   = $user->formations()->withCount('videos')->get();
    }

    return view('dashboard.apprenant', compact('enrollments', 'liveSessions', 'certificates', 'formations'));
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
        return view('dashboard.formation');
    }
  
public function formateur()
{
    $user = auth()->user();

    $stats = [
        'courses_count' => Course::where('instructor_id', $user->id)->count(),
        'live_sessions_count' => LiveSession::where('instructor_id', $user->id)->count(),
        'students_count' => Enrollment::whereHas('course', function ($query) use ($user) {
            $query->where('instructor_id', $user->id);
        })->distinct('user_id')->count('user_id'),
    ];

    $recentCourses = Course::where('instructor_id', $user->id)
                           ->latest()
                           ->limit(5)
                           ->get();

    return view('dashboard.formateur', compact('stats', 'recentCourses'));
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
            'role' => 'required|string|in:apprenant,formateur,admin',

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

    //here the modification

    public function profil()
{
    $user = auth()->user();

    // Petites métriques facultatives (aucune logique cassée si tables absentes)
    try {
        $myCourses = \App\Models\Course::where('instructor_id', $user->id)->count();
        $myCertifs = method_exists($user, 'certificates') ? $user->certificates()->count() : 0;
    } catch (\Exception $e) {
        $myCourses = 0;
        $myCertifs = 0;
    }

    return view('admin.profil', compact('user','myCourses','myCertifs'));
}

}
