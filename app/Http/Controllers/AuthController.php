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
    public function showConnexion()
    {
        return view('auth.connexion');
    }

    public function showVideos()
    {
        return view('auth.videos');
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
            'role' => ['required', Rule::in(['apprenant', 'formateur', 'admin'])],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect($this->redirectTo());
    }

    protected function redirectTo()
    {
        $role = auth()->user()->role;

        return match ($role) {
            'admin' => route('dashboard.admin'),
            'formateur' => route('dashboard.formateur'),
            'apprenant' => route('dashboard.apprenant'),
            default => '/home',
        };
    }

    /**
     * Handle login.
     */
    public function connexion(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            $user = auth()->user();

            // 🔁 Redirection intelligente selon le rôle
            return match ($user->role) {
                'admin' => redirect()->route('dashboard.admin'),
                'formateur' => redirect()->route('dashboard.formateur'),
                'apprenant' => redirect()->route('dashboard.apprenant'),
                default => auth()->logout() && abort(403, 'Rôle inconnu.'),
            };
        }

        return back()->withErrors(['email' => 'Identifiants incorrects']);
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
