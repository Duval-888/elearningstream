@extends('layouts.dashboard')

@section('content')
<div class="container mt-5">
    <h2>✏️ Modifier la formation</h2>

    <form action="{{ route('formations.update', $formation) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $formation->title }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ $formation->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="level" class="form-label">Niveau</label>
            <select name="level" id="level" class="form-select">
                <option value="debutant" {{ $formation->level == 'debutant' ? 'selected' : '' }}>Débutant</option>
                <option value="intermediaire" {{ $formation->level == 'intermediaire' ? 'selected' : '' }}>Intermédiaire</option>
                <option value="avance" {{ $formation->level == 'avance' ? 'selected' : '' }}>Avancé</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Prix (€)</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ $formation->price }}">
        </div>

        <div class="mb-3">
            <label for="is_active" class="form-label">Statut</label>
            <select name="is_active" id="is_active" class="form-select">
                <option value="1" {{ $formation->is_active ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$formation->is_active ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
    </form>
</div>
@endsection
