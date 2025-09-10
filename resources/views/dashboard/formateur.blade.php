@extends('layouts.dashboard')

@section('content')
<div class="container py-5">

    {{-- ✅ Message de bienvenue dynamique --}}
    <div class="alert alert-success text-center mb-4">
        Bonjour {{ auth()->user()->name }} 👋, bienvenue dans votre espace <strong>Formateur</strong> !
    </div>
    <p class="text-muted text-center mb-4">Créez vos formations, animez vos sessions live et suivez vos apprenants.</p>

    {{-- 🔍 Barre de recherche avec filtre --}}
    <form action="{{ route('search.global') }}" method="GET" class="mb-5">
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" name="query" class="form-control" placeholder="Rechercher...">
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select">
                    <option value="">Tous les types</option>
                    <option value="cours">Cours</option>
                    <option value="session">Sessions live</option>
                    <option value="apprenant">Apprenants</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100" type="submit">🔍 Rechercher</button>
            </div>
        </div>
    </form>

    {{-- 🧑‍🏫 Blocs horizontaux --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <x-dashboard-card title="Mes cours" color="primary" icon="📚">
                <p>{{ $stats['courses_count'] }} cours créés</p>
                <a href="{{ route('courses.index') }}" class="btn btn-outline-primary btn-sm">Gérer</a>
            </x-dashboard-card>
        </div>
        <div class="col-md-4">
            <x-dashboard-card title="Sessions Live" color="danger" icon="🎥">
                <p>{{ $stats['live_sessions_count'] }} sessions planifiées</p>
                <a href="{{ route('live-sessions.index') }}" class="btn btn-outline-danger btn-sm">Voir</a>
            </x-dashboard-card>
        </div>
        <div class="col-md-4">
            <x-dashboard-card title="Apprenants" color="success" icon="🎓">
                <p>{{ $stats['students_count'] }} inscrits</p>
                <a href="{{ route('dashboard.formation') }}" class="btn btn-outline-success btn-sm">Voir les formations</a>
            </x-dashboard-card>
        </div>
    </div>

    {{-- Derniers cours créés --}}
    <h2 class="text-2xl fw-bold mb-4">📘 Derniers cours créés</h2>
    <div class="row g-4">
        @forelse($recentCourses as $course)
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->title }}</h5>
                        <p class="card-text text-muted">{{ $course->description }}</p>
                        <small class="text-muted">Créé le {{ $course->created_at->format('d/m/Y') }}</small><br>
                        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary btn-sm mt-2">Voir le cours</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Aucun cours récent.</p>
        @endforelse
    </div>
</div>
@endsection
