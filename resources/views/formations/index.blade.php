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
                        <td>{{ number_format($formation->price, 2) }}</td>
                        <td>
                            @if($formation->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('formations.edit', $formation) }}" class="btn btn-sm btn-primary">✏️ Modifier</a>

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
    @endif
</div>
@endsection
