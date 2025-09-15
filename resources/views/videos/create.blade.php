@extends('layouts.dashboard')

@section('content')
<div class="container mt-5">
    <h2>Ajouter une vidéo à la formation : {{ $formation->title }}</h2>

    <form method="POST" action="{{ route('videos.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="formation_id" value="{{ $formation->id }}">

        <div class="mb-3">
            <label for="title" class="form-label">Titre de la vidéo</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="video" class="form-label">Fichier vidéo (.mp4)</label>
            <input type="file" name="video" class="form-control" accept="video/mp4" required>
        </div>

        <div class="mb-3">
            <label for="ordre" class="form-label">Ordre (facultatif)</label>
            <input type="number" name="ordre" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Ajouter la vidéo</button>
    </form>
</div>
@endsection
