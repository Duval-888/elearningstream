@php use Illuminate\Support\Str; @endphp
@extends('layouts.dashboard')

@section('content')
<div class="container mt-5">
    <h2>📘 Ajouter une nouvelle formation</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('formations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug (identifiant URL)</label>
            <input type="text" name="slug" id="slug" class="form-control" required>
            <small class="text-muted">Exemple : laravel-pour-debutants</small>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label for="level" class="form-label">Niveau</label>
            <select name="level" id="level" class="form-select" required>
                <option value="debutant">Débutant</option>
                <option value="intermediaire">Intermédiaire</option>
                <option value="avance">Avancé</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Prix (€)</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" min="0" value="0">
        </div>

        <div class="mb-3">
    <label for="video_url" class="form-label">Lien YouTube</label>
    <input type="url" name="video_url" id="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
</div>


        <div class="mb-3">
            <label for="is_active" class="form-label">Activer la formation</label>
            <select name="is_active" id="is_active" class="form-select">
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="cover_image" class="form-label">Image de couverture</label>
            <input type="file" name="cover_image" id="cover_image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Créer la formation</button>
    </form>
</div>
@endsection
