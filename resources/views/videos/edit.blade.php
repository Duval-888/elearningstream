@extends('layouts.dashboard')

@section('content')
<div class="container mt-5">
    <h2>Modifier la vidéo : {{ $video->title }}</h2>

    <form method="POST" action="{{ route('videos.update', $video) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" class="form-control" value="{{ $video->title }}" required>
        </div>

        <div class="mb-3">
            <label for="ordre" class="form-label">Ordre</label>
            <input type="number" name="ordre" class="form-control" value="{{ $video->ordre }}">
        </div>

        <div class="mb-3">
            <label for="video" class="form-label">Remplacer la vidéo (facultatif)</label>
            <input type="file" name="video" class="form-control" accept="video/mp4">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
