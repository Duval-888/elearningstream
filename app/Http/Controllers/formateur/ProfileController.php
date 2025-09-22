<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user(); // peut être null, la vue gère le cas
        return view('formateur.profile', compact('user'));
    }

    public function index()
    {
        $user = auth()->user(); // si non connecté, la vue gèrera ça
        return view('formateur.profile.index', compact('user'));
    }


    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', 'min:6'],
            'avatar'   => ['nullable', 'image', 'max:2048'],
        ]);

        // avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_path = $path;
        }

        $user->name  = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}



