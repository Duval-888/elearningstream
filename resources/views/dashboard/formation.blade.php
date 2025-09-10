@extends('layouts.dashboard')

@section('content')
<div class="container">
    {{-- ✅ Message de bienvenue dynamique --}}
    <div class="alert alert-success mb-4">
        Bonjour {{ auth()->user()->name }} 👋, bienvenue dans votre espace <strong>Formateur</strong> !
    </div>
    <p class="text-muted">Créez vos formations, animez vos sessions live et suivez vos apprenants.</p>

    <h1 class="text-3xl font-bold mb-4">Bienvenue Formateur</h1>
    <p class="text-gray-600">Voici votre tableau de bord pour gérer vos cours, sessions live et apprenants.</p>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Mes Cours</h2>
            <p>{{ $stats['courses_count'] }} cours créés</p>
            <a href="{{ route('courses.index') }}" class="text-blue-600 hover:underline">Gérer mes cours</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Sessions Live</h2>
            <p>{{ $stats['live_sessions_count'] }} sessions planifiées</p>
            <a href="{{ route('live-sessions.index') }}" class="text-blue-600 hover:underline">Voir les sessions</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Apprenants</h2>
            <p>{{ $stats['students_count'] }} inscrits</p>
            <a href="{{ route('dashboard.formation') }}" class="text-blue-600 hover:underline">Voir les formations</a>
        </div>
    </div>

    {{-- Bouton d'action --}}
    <div class="mt-10">
        <a href="{{ route('courses.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Créer un nouveau cours
        </a>
    </div>

    {{-- Derniers cours créés --}}
    <div class="mt-10">
        <h2 class="text-2xl font-bold mb-4">Derniers cours créés</h2>
        @if(isset($recentCourses) && $recentCourses->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($recentCourses as $course)
                    <div class="bg-white p-4 rounded shadow">
                        <h3 class="text-lg font-semibold">{{ $course->title }}</h3>
                        <p class="text-sm text-gray-600">{{ $course->description }}</p>
                        <p class="text-xs text-gray-500">Créé le {{ $course->created_at->format('d/m/Y') }}</p>
                        <a href="{{ route('courses.show', $course->id) }}" class="text-blue-600 hover:underline mt-2 inline-block">Voir le cours</a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Aucun cours récent trouvé.</p>
        @endif
    </div>
</div>
@endsection
