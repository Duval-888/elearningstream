@extends('layouts.dashboard')

@section('title', 'Dashboard Formateur')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- ✅ Message de bienvenue --}}
    <div class="bg-green-100 text-green-800 text-center font-medium px-4 py-3 rounded-lg mb-4">
        <i class="fa-solid fa-hand-peace mr-2"></i>
        Bonjour {{ auth()->user()->name }} 👋, bienvenue dans votre espace <strong>Formateur</strong> !
    </div>
    <p class="text-gray-600 text-center mb-8">
        Créez vos formations, animez vos sessions live et suivez vos apprenants.
    </p>

    {{-- 🔍 Barre de recherche --}}
    <form action="{{ route('search.global') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 mb-10">
        <div class="md:col-span-6">
            <input type="text" name="query"
                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="Rechercher...">
        </div>
        <div class="md:col-span-3">
            <select name="type"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Tous les types</option>
                <option value="cours">Cours</option>
                <option value="session">Sessions live</option>
                <option value="apprenant">Apprenants</option>
            </select>
        </div>
        <div class="md:col-span-3">
            <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 font-semibold text-white hover:bg-blue-700 transition">
                <i class="fa-solid fa-magnifying-glass"></i>
                Rechercher
            </button>
        </div>
    </form>

    {{-- 🧑‍🏫 Stat cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">
        {{-- Mes cours --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                        <i class="fa-solid fa-book text-lg"></i>
                    </span>
                    <div>
                        <div class="text-sm uppercase text-gray-500">Mes cours</div>
                        <div class="text-2xl font-semibold">{{ $stats['courses_count'] ?? 0 }}</div>
                    </div>
                </div>
                <a href="{{ route('courses.index') }}"
                   class="text-blue-600 hover:text-blue-700 text-sm font-medium inline-flex items-center gap-1">
                    Gérer <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Sessions Live --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                        <i class="fa-solid fa-video text-lg"></i>
                    </span>
                    <div>
                        <div class="text-sm uppercase text-gray-500">Sessions Live</div>
                        <div class="text-2xl font-semibold">{{ $stats['live_sessions_count'] ?? 0 }}</div>
                    </div>
                </div>
                <a href="{{ route('live-sessions.index') }}"
                   class="text-indigo-600 hover:text-indigo-700 text-sm font-medium inline-flex items-center gap-1">
                    Voir <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Apprenants --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                        <i class="fa-solid fa-graduation-cap text-lg"></i>
                    </span>
                    <div>
                        <div class="text-sm uppercase text-gray-500">Apprenants</div>
                        <div class="text-2xl font-semibold">{{ $stats['students_count'] ?? 0 }}</div>
                    </div>
                </div>
                <a href="{{ route('dashboard.formation') }}"
                   class="text-emerald-600 hover:text-emerald-700 text-sm font-medium inline-flex items-center gap-1">
                    Formations <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- 📘 Derniers cours créés --}}
    <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-4">📘 Derniers cours créés</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @forelse($recentCourses as $course)
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition">
                <h3 class="text-lg font-semibold text-gray-900">{{ $course->title }}</h3>
                <p class="text-sm text-gray-600 mt-1">{{ $course->description }}</p>
                <div class="mt-3 text-xs text-gray-500">
                    <i class="fa-regular fa-calendar mr-1"></i>
                    Créé le {{ optional($course->created_at)->format('d/m/Y') }}
                </div>
                <a href="{{ route('courses.show', $course->id) }}"
                   class="mt-4 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">
                    <i class="fa-solid fa-eye"></i> Voir le cours
                </a>
            </div>
        @empty
            <p class="text-gray-500">Aucun cours récent.</p>
        @endforelse
    </div>

    {{-- 📊 Formations & inscriptions --}}
    <h2 class="text-xl md:text-2xl font-bold text-gray-900 mt-10 mb-4">📊 Mes formations & inscriptions</h2>

    <div class="space-y-5">
        @forelse($formations as $formation)
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition overflow-hidden">
                @if($formation->cover_image)
                    <img src="{{ asset('storage/' . $formation->cover_image) }}"
                         alt="Cover {{ $formation->title }}"
                         class="w-full h-48 object-cover">
                @endif

                <div class="p-5">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $formation->title }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $formation->description }}</p>

                    <div class="mt-3 text-sm text-gray-700">
                        <i class="fa-solid fa-users mr-2 text-emerald-600"></i>
                        <span class="font-medium">Inscriptions :</span>
                        {{ $formation->inscriptions_count }}
                    </div>

                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('formations.show', $formation) }}"
                           class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">
                            <i class="fa-solid fa-eye"></i> Voir la formation
                        </a>

                        <a href="{{ route('formations.inscrits', $formation) }}"
                           class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-3 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                            <i class="fa-solid fa-user-group"></i> Voir les inscrits
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Aucune formation créée pour le moment.</p>
        @endforelse
    </div>

</div>
@endsection
