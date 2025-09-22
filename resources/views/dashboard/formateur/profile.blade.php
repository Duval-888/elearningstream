@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">
            <i class="fa-solid fa-user text-emerald-600 mr-2"></i> Mon profil (Formateur)
        </h1>
        <p class="text-gray-500">Gérez vos informations personnelles et les préférences de votre compte.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Carte profil --}}
        <div class="lg:col-span-1 rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
            <div class="flex items-center gap-4">
                <img
                    src="{{ asset('images/profil.png') }}"
                    alt="Avatar"
                    class="h-16 w-16 rounded-full object-cover border border-emerald-200"
                />
                <div>
                    <div class="font-semibold text-gray-900 text-lg">{{ auth()->user()->name ?? 'Formateur' }}</div>
                    <div class="text-sm text-emerald-700 inline-flex items-center gap-2">
                        <i class="fa-solid fa-chalkboard-user"></i> Formateur
                    </div>
                </div>
            </div>

            <div class="mt-6 space-y-2 text-sm">
                <div class="flex items-center gap-2 text-gray-600">
                    <i class="fa-regular fa-envelope text-emerald-600"></i>
                    <span>{{ auth()->user()->email ?? '—' }}</span>
                </div>
                <div class="flex items-center gap-2 text-gray-600">
                    <i class="fa-regular fa-id-badge text-emerald-600"></i>
                    <span>ID : {{ auth()->id() ?? '—' }}</span>
                </div>
            </div>
        </div>

        {{-- Carte actions --}}
        <div class="lg:col-span-2 rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Actions rapides</h2>
            <div class="flex flex-wrap gap-3">
                {{-- Ces routes existent dans ton app (Livewire Settings) d’après ton route:list --}}
                <a href="{{ route('settings.profile') }}"
                   class="inline-flex items-center gap-2 rounded-xl border border-emerald-300 bg-emerald-50 px-4 py-2 text-emerald-700 hover:bg-emerald-100">
                    <i class="fa-solid fa-user-pen"></i> Modifier mon profil
                </a>
                <a href="{{ route('settings.password') }}"
                   class="inline-flex items-center gap-2 rounded-xl border border-indigo-300 bg-indigo-50 px-4 py-2 text-indigo-700 hover:bg-indigo-100">
                    <i class="fa-solid fa-key"></i> Changer mon mot de passe
                </a>
                <a href="{{ route('settings.appearance') }}"
                   class="inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-gray-50 px-4 py-2 text-gray-700 hover:bg-gray-100">
                    <i class="fa-solid fa-palette"></i> Apparence
                </a>
            </div>

            <div class="mt-8">
                <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500 mb-3">Conseils</h3>
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                    <li>Ajoute une bio et une photo de profil pour inspirer confiance à tes apprenants.</li>
                    <li>Active les notifications pour ne manquer aucune inscription ou commentaire.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
