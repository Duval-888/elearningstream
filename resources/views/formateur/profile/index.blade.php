@extends('layouts.dashboard')

@section('content')
@php $user = $user ?? auth()->user(); @endphp

<div class="max-w-5xl mx-auto px-4 py-8">
    @if(session('success'))
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
        <div class="p-6 md:p-8 bg-gradient-to-r from-emerald-600 to-sky-500 text-white">
            <h1 class="text-2xl md:text-3xl font-bold"><i class="fa-solid fa-user-pen mr-2"></i>Mon profil</h1>
            <p class="text-white/90">Gère tes informations personnelles</p>
        </div>

        <form method="POST" action="{{ route('formateur.profile.update') }}" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                    @error('name') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                    @error('email') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                    <input type="password" name="password"
                           class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                           placeholder="Laisse vide pour ne pas changer">
                    @error('password') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation"
                           class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Avatar (optionnel)</label>
                    <input type="file" name="avatar"
                           class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 bg-white">
                    @error('avatar') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror

                    @if($user->avatar_path)
                        <div class="mt-3">
                            <img src="{{ asset('storage/'.$user->avatar_path) }}" class="h-16 w-16 rounded-full ring-2 ring-emerald-200 object-cover">
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('dashboard.formateur') }}" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700">
                    Annuler
                </a>
                <button class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
