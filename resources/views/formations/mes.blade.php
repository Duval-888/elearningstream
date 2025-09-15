@extends('layouts.dashboard')

@section('content')
<div class="container mt-5">
    <h2>Mes formations suivies</h2>

    @forelse($formations as $formation)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $formation->title }}</h5>
                <p>{{ $formation->description }}</p>
                <p><strong>Vidéos :</strong> {{ $formation->videos_count }}</p>
                <a href="{{ route('formations.show', $formation) }}" class="btn btn-primary">Accéder</a>
            </div>
        </div>
    @empty
        <p>Tu n'es inscrit à aucune formation pour le moment.</p>
    @endforelse
</div>
@endsection
