@extends('layouts.dashboard')

@section('content')
<div class="container mt-5">
    <h2>🎬 Gestion des vidéos – {{ $formation->title }}</h2>

    <a href="{{ route('videos.create', $formation->id) }}" class="btn btn-primary mb-4">
        ➕ Ajouter une nouvelle vidéo
    </a>

    @forelse($videos as $video)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $video->title }}</h5>
                <p><strong>Ordre :</strong> {{ $video->ordre ?? 'Non défini' }}</p>

                {{-- 🎥 Affichage de la vidéo --}}
                @php
                    $isYoutube = Str::contains($video->video_url, 'youtube.com') || Str::contains($video->video_url, 'youtu.be');
                    if ($isYoutube && Str::contains($video->video_url, 'watch?v=')) {
                        $embedUrl = Str::replace('watch?v=', 'embed/', $video->video_url);
                    } elseif ($isYoutube && Str::contains($video->video_url, 'youtu.be/')) {
                        $videoId = Str::after($video->video_url, 'youtu.be/');
                        $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                    }
                @endphp

                @if($isYoutube)
                    <div class="ratio ratio-16x9 mb-3">
                        <iframe src="{{ $embedUrl }}" frameborder="0" allowfullscreen></iframe>
                    </div>
                @else
                    <video width="100%" controls class="mb-3">
                        <source src="{{ asset($video->video_url) }}" type="video/mp4">
                        Votre navigateur ne supporte pas la vidéo.
                    </video>
                @endif

                {{-- 🛠️ Actions --}}
                <a href="{{ route('videos.edit', $video) }}" class="btn btn-warning btn-sm">✏️ Modifier</a>
                <form action="{{ route('videos.destroy', $video) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette vidéo ?')">🗑️ Supprimer</button>
                </form>
            </div>
        </div>
    @empty
        <p>Aucune vidéo n’a encore été ajoutée à cette formation.</p>
    @endforelse
</div>
@endsection
