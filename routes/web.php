<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('guest')->controller(AuthController::class)->group(function (){
Route::get('/inscription','showInscription')->name('show.inscription');
Route::get('/connexion','showConnexion')->name('show.connexion');
Route::post('/inscription','inscription')->name('inscription');
Route::post('/connexion','connexion')->name('connexion');
});

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');

Route::post('/deconnexion',[AuthController::class,'deconnexion'])->name('deconnexion');



Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::post('signup',[AuthController::class,'store'])->name('signup.store');
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
