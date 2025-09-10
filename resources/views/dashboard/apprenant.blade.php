@extends('layouts.dashboard')

@section('content')
<div class="container py-5">

    {{-- ✅ Message de bienvenue dynamique --}}
    <div class="alert alert-success text-center mb-4">
        Bonjour {{ auth()->user()->name }} 👋, bienvenue dans votre espace <strong>Apprenant</strong> !
    </div>
    <p class="text-muted text-center mb-4">Explorez vos cours, participez aux sessions en direct et téléchargez vos certificats.</p>

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
                    <option value="certificat">Certificats</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100" type="submit">🔍 Rechercher</button>
            </div>
        </div>
    </form>

    {{-- 🎓 Blocs horizontaux --}}
    <div class="row g-4 mb-5">
        {{-- 📚 Mes cours suivis --}}
        <div class="col-md-4">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📚 Mes cours suivis</h5>
                </div>
                <div class="card-body">
                    @forelse($enrollments as $enrollment)
                        <h6 class="text-primary">{{ $enrollment->course->title }}</h6>
                        <p class="text-muted small">{{ $enrollment->course->description }}</p>
                        <div class="progress mb-2" style="height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $enrollment->progress ?? 0 }}%;" aria-valuenow="{{ $enrollment->progress ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">Progression : {{ $enrollment->progress ?? 0 }}%</small><br>
                        <a href="{{ route('courses.show', $enrollment->course->id) }}" class="btn btn-outline-primary btn-sm mt-2">Continuer</a>
                        <hr>
                    @empty
                        <p class="text-muted">Aucun cours suivi pour le moment.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- 🎥 Sessions en direct --}}
        <div class="col-md-4">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">🎥 Sessions en direct</h5>
                </div>
                <div class="card-body">
                    @forelse($liveSessions as $session)
                        <h6 class="text-danger">{{ $session->title }}</h6>
                        <p class="text-muted small">{{ $session->description }}</p>
                        <small class="text-muted">Prévue le : {{ $session->scheduled_at->format('d M Y à H:i') }}</small><br>
                        <a href="{{ $session->meeting_url }}" target="_blank" class="btn btn-danger btn-sm mt-2">Rejoindre</a>
                        <hr>
                    @empty
                        <p class="text-muted">Aucune session en direct pour le moment.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- 📜 Mes certificats --}}
        <div class="col-md-4">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">📜 Mes certificats</h5>
                </div>
                <div class="card-body">
                    @forelse($certificates as $cert)
                        <h6 class="text-success">{{ $cert->course->title }}</h6>
                        <p class="small">Score final : {{ $cert->final_score ?? 0 }}%</p>
                        <small class="text-muted">Délivré le : {{ $cert->issued_at ? $cert->issued_at->format('d M Y') : '' }}</small><br>
                        <a href="{{ asset($cert->file_path) }}" download class="btn btn-success btn-sm mt-2">📥 Télécharger</a>
                        <hr>
                    @empty
                        <p class="text-muted">Pas encore de certificats obtenus.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
