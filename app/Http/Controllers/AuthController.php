<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show registration page.
     */
    public function showInscription()
    {
        return view('auth.inscription');
    }

    /**
     * Show login page.
     */
public function showVideos(){
    return view('auth.videos');
}
    public function showConnexion()
    {
        return view('auth.connexion');
    }

    /**
     * Handle registration.
     */
    public function inscription(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'apprenant', // Rôle par défaut
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('status', 'Bienvenue!');
    }

    /**
     * Handle login.
     */
    public function connexion(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt($validated)){
            $request->session()->regenerate();
             return redirect()->route('home');
        }
        throw ValidationException::withMessages([
            'credentials'=>'Desolé, les informations entrées sont incohérentes.'
        ]);
    }

    /**
     * Handle logout.
     */
    public function deconnexion(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('show.connexion');
    }

    /**
     * Optional: additional signup endpoint mapped to the same registration logic.
     */
    public function store(Request $request)
    {
        return $this->inscription($request);
    }


}