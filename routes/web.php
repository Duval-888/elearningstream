<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\LiveSessionController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ChatController;
use Illuminate\Database\Schema\Blueprint;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StreamingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\VideosController;



Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/videos',[AuthController::class,'showVideos'])->name('show.videos');
Route::get('/search', [SearchController::class, 'global'])->name('search.global');
Route::get('/admin/apprenants', [AdminController::class, 'apprenants'])->name('admin.apprenants');
Route::get('/admin/formateurs', [AdminController::class, 'formateurs'])->name('admin.formateurs');
Route::get('/streaming', [StreamingController::class, 'index'])->name('streaming.index');
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::resource('formations', FormationController::class);
Route::get('/mes-formations', [FormationController::class, 'mesFormations'])->name('formations.mes');
Route::get('formations/{formation}/inscrits', [FormationController::class, 'inscrits'])->name('formations.inscrits');
Route::post('/inscriptions', [InscriptionController::class, 'store'])->name('inscriptions.store');
// Vue de création de formation (déjà gérée par Route::resource)
Route::get('/formations/create', [FormationController::class, 'create'])->name('formations.create');

// Vue de modification de formation
Route::get('/formations/{formation}/edit', [FormationController::class, 'edit'])->name('formations.edit');
Route::put('/formations/{formation}', [FormationController::class, 'update'])->name('formations.update');

// Vue d’affichage des formations du formateur (déjà présente)
Route::get('/mes-formations', [FormationController::class, 'mesFormations'])->name('formations.mes');

// Vue d’affichage des inscrits à une formation (déjà présente)
Route::get('/formations/{formation}/inscrits', [FormationController::class, 'inscrits'])->name('formations.inscrits');

// Vue de détail d’une formation
Route::get('/formations/{formation}', [FormationController::class, 'show'])->name('formations.show');

// Suppression d’une formation
Route::delete('/formations/{formation}', [FormationController::class, 'destroy'])->name('formations.destroy');

// Inscription à une formation (déjà présente)
Route::post('/inscriptions', [InscriptionController::class, 'store'])->name('inscriptions.store');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/mes-formations', [FormationController::class, 'mesFormations'])->name('formations.mes');
Route::get('/formations/{formation}/certificat', [FormationController::class, 'certificat'])->name('formations.certificat');

// Routes liées aux vidéos
Route::get('/formations/{formation}/videos/create', [VideosController::class, 'create'])->name('videos.create');
Route::post('/videos', [VideosController::class, 'store'])->name('videos.store');
Route::get('/videos/{video}/edit', [VideosController::class, 'edit'])->name('videos.edit');
Route::put('/videos/{video}', [VideosController::class, 'update'])->name('videos.update');
Route::delete('/videos/{video}', [VideosController::class, 'destroy'])->name('videos.destroy');
Route::post('/videos/{video}/vue', [VideosController::class, 'marquerVue'])->name('videos.vue');
Route::get('/formations/{formation}/videos', [FormationController::class, 'gererVideos'])->name('formations.videos');












Route::middleware('guest')->controller(AuthController::class)->group(function (){
    Route::get('/inscription','showInscription')->name('show.inscription');
    Route::get('/connexion','showConnexion')->name('show.connexion');
    Route::post('/inscription','inscription')->name('inscription');
    Route::post('/connexion','connexion')->name('connexion');
});

Route::resource('courses', CourseController::class);
Route::patch('/courses/{course}/toggle-publish', [CourseController::class, 'togglePublish'])->name('courses.toggle-publish');
Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');

Route::post('/deconnexion',[AuthController::class,'deconnexion'])->name('deconnexion');

// Dashboard Formation
Route::get('/dashboard/formateur', [FormationController::class, 'dashboard'])->name('dashboard.formateur');

// Dashboard Apprenant
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/apprenant', [DashboardController::class, 'apprenant'])->name('dashboard.apprenant');
    Route::get('/dashboard/apprenant/courses', [DashboardController::class, 'courses'])->name('apprenant.courses');
    Route::get('/dashboard/apprenant/progress', [DashboardController::class, 'progression'])->name('apprenant.progression');
    Route::get('/dashboard/apprenant/sessionlive', [DashboardController::class, 'sessionlive'])->name('apprenant.sessionlive');
    Route::get('/dashboard/apprenant/certificates', [DashboardController::class, 'certificates'])->name('apprenant.certificates');
    Route::get('/dashboard/formateur', [DashboardController::class, 'formateur'])->name('dashboard.formateur');
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/admin/users/{user}/edit', [DashboardController::class, 'editUser'])->name('admin.edit');
    Route::put('/admin/users/{user}', [DashboardController::class, 'updateUser'])->name('admin.update');
    Route::delete('/admin/users/{user}', [DashboardController::class, 'deleteUser'])->name('admin.delete');
});


// Live Sessions routes - vues publiques
Route::middleware(['auth'])->group(function () {
    Route::get('/live-sessions', [LiveSessionController::class, 'index'])->name('live-sessions.index');
    Route::get('/live-sessions/{liveSession}', [LiveSessionController::class, 'show'])->name('live-sessions.show');
    Route::get('/live-sessions/{liveSession}/join', [LiveSessionController::class, 'join'])->name('live-sessions.join');
    Route::get('/live-sessions/{liveSession}/room', [LiveSessionController::class, 'room'])->name('live-sessions.room');
});

// Live Sessions routes - gestion (formateurs et admins)
Route::middleware(['auth', 'role:formateur,admin'])->group(function () {
    Route::get('/live-sessions/create', [LiveSessionController::class, 'create'])->name('live-sessions.create');
    Route::post('/live-sessions', [LiveSessionController::class, 'store'])->name('live-sessions.store');
    Route::get('/live-sessions/{liveSession}/edit', [LiveSessionController::class, 'edit'])->name('live-sessions.edit');
    Route::put('/live-sessions/{liveSession}', [LiveSessionController::class, 'update'])->name('live-sessions.update');
    Route::delete('/live-sessions/{liveSession}', [LiveSessionController::class, 'destroy'])->name('live-sessions.destroy');
    Route::post('/live-sessions/{liveSession}/start', [LiveSessionController::class, 'start'])->name('live-sessions.start');
    Route::post('/live-sessions/{liveSession}/end', [LiveSessionController::class, 'end'])->name('live-sessions.end');
});

// Enrollment routes (apprenants seulement)
Route::middleware(['auth', 'role:apprenant'])->group(function () {
    Route::post('/enroll/{course}', [EnrollmentController::class, 'store'])->name('enrollment.store');
    Route::delete('/enroll/{course}', [EnrollmentController::class, 'destroy'])->name('enrollment.destroy');
    Route::post('/courses/{course}/progress', [EnrollmentController::class, 'updateProgress'])->name('enrollment.progress');
});

// Certificate routes
Route::middleware(['auth'])->group(function () {
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificate.download');
});

// Certificate management (admins et formateurs)
Route::middleware(['auth', 'role:formateur,admin'])->group(function () {
    Route::post('/certificates/issue', [CertificateController::class, 'issue'])->name('certificate.issue');
});

// Forum routes
Route::middleware(['auth'])->group(function () {
    Route::get('/forums', [ForumController::class, 'index'])->name('forums.index');
    Route::get('/forums/create', [ForumController::class, 'create'])->name('forums.create');
    Route::post('/forums', [ForumController::class, 'store'])->name('forums.store');
    Route::get('/forums/search', [ForumController::class, 'search'])->name('forums.search');
    Route::get('/forums/category/{category}', [ForumController::class, 'category'])->name('forums.category');
    Route::get('/forums/{discussion}', [ForumController::class, 'show'])->name('forums.discussion');
    Route::post('/forums/{discussion}/reply', [ForumController::class, 'reply'])->name('forums.reply');
    Route::get('/forums/my/contributions', [ForumController::class, 'myContributions'])->name('forums.my-contributions');
});

// Chat routes
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{chat}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/{chat}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/mark-read', [ChatController::class, 'markAsRead'])->name('chat.mark-read');
    Route::get('/chat/private/{user}', [ChatController::class, 'startPrivateChat'])->name('chat.private');
    Route::get('/api/chat/online-users', [ChatController::class, 'getOnlineUsers'])->name('chat.online-users');
});

// Routes de création pour formation et session live
Route::get('/dashboard/formation/create', function() {
    return view('dashboard.formation-create');
})->name('formation.create');

Route::get('/dashboard/sessionlive/create', function() {
    return view('dashboard.sessionlive-create');
})->name('sessionlive.create');

Route::get('dashboard', function() {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Dashboard Chat
Route::middleware(['auth'])->get('/dashboard/chat', [DashboardController::class, 'chat'])->name('dashboard.chat');
// Dashboard Forums
Route::middleware(['auth'])->get('/dashboard/forums', [DashboardController::class, 'forums'])->name('dashboard.forums');

Route::post('signup',[AuthController::class,'store'])->name('signup.store');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';

Route::get('/dashboard/formation', [DashboardController::class, 'formation'])->name('dashboard.formation');
//here
Route::middleware(['auth', 'role:formateur,admin'])->group(function () {
    Route::get('/dashboard/formateur', [FormationController::class, 'dashboard'])->name('dashboard.formateur');
});



Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard/sessionlive', [DashboardController::class, 'sessionlive'])
    ->middleware(['auth'])
    ->name('dashboard.sessionlive');