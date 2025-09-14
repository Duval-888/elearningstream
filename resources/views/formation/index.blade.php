@php use Illuminate\Support\Str; @endphp
@extends('layouts.dashboard')

@section('content')
<div class="container mt-5">
    <h2>📚 Mes formations</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('formations.create') }}" class="btn btn-success mb-3">➕ Ajouter une formation</a>

    @if($formations->isEmpty())
        <p>Aucune formation créée pour le moment.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Niveau</th>
                    <th>Prix (€)</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($formations as $formation)
                    <tr>
                        <td>{{ $formation->title }}</td>
                        <td>{{ ucfirst($formation->level) }}</td>
                        <td>{{ number_format($formation->price, 2) }} €</td>
                        <td>
                            @if($formation->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('formations.edit', $formation) }}" class="btn btn-sm btn-primary">✏️ Modifier</a>
                            <a href="{{ route('formations.show', $formation->slug) }}" class="btn btn-sm btn-info">👁️ Voir le cours</a>
                            <form action="{{ route('formations.destroy', $formation) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Confirmer la suppression ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">🗑️ Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- 🎬 Vidéos affichées en dehors du tableau --}}
        @foreach($formations as $formation)
            @if($formation->video_url)
                @php
                    $embedUrl = Str::replace('watch?v=', 'embed/', $formation->video_url);
                @endphp
                <div class="mb-4">
                    <h5 class="text-center">{{ $formation->title }} 🎬</h5>
                    <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;" class="rounded shadow-sm">
                        <iframe 
                            src="{{ $embedUrl }}" 
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" 
                            frameborder="0" 
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
</div>
@endsection
