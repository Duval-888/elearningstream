@php use Illuminate\Support\Str; @endphp

@extends('layouts.dashboard')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container mt-5">
    <h2>{{ $formation->title }}</h2>

    <p class="text-muted">{{ $formation->description }}</p>

    <p><strong>Niveau :</strong> {{ ucfirst($formation->level) }}</p>
    <p><strong>Prix :</strong> {{ $formation->price }} €</p>

    {{-- 🎬 Affichage de la vidéo --}}
    @if($formation->video_url)
        @php
            $embedUrl = $formation->video_url;
            $isYoutube = false;

            if (Str::contains($embedUrl, 'watch?v=')) {
                $embedUrl = Str::replace('watch?v=', 'embed/', $embedUrl);
                $isYoutube = true;
            } elseif (Str::contains($embedUrl, 'youtu.be/')) {
                $videoId = Str::after($embedUrl, 'youtu.be/');
                $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                $isYoutube = true;
            }
        @endphp

        @if($isYoutube)
            {{-- YouTube embed --}}
            <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; margin-bottom: 30px;">
                <iframe 
                    src="{{ $embedUrl }}" 
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" 
                    frameborder="0" 
                    allowfullscreen>
                </iframe>
            </div>
        @else
            {{-- Vidéo locale --}}
            <h4>Vidéo locale :</h4>

            <video width="720" controls class="mb-3">
    <source src="{{ asset($formation->video_url) }}" type="video/mp4">
    Votre navigateur ne supporte pas la vidéo.
</video>


            {{-- 📥 Bouton de téléchargement --}}
            <a href="{{ asset($formation->video_url) }}" download class="btn btn-outline-primary mb-3">
                📥 Télécharger la vidéo
            </a>

            {{-- 📄 Nom du fichier --}}
            <p><strong>Fichier :</strong> {{ basename($formation->video_url) }}</p>
        @endif
    @else
        <p>Aucune vidéo disponible pour cette formation.</p>
    @endif

    <hr>
<h3>Vidéos de la formation</h3>

    <h4>Progression de la formation</h4>
<div class="progress mb-4" style="height: 25px;">
    <div class="progress-bar bg-success" role="progressbar"
         style="width: {{ $progression }}%;"
         aria-valuenow="{{ $progression }}" aria-valuemin="0" aria-valuemax="100">
        {{ $progression }}%
    </div>
</div>
@if($progression < 100)
    <p class="text-muted">📈 Tu as complété {{ $progression }}% de cette formation. Continue comme ça !</p>
@endif


@if($progression === 100)
    <a href="{{ route('formations.certificat', $formation) }}" class="btn btn-outline-info mt-3">
        🎓 Télécharger mon certificat
    </a>
    <div class="alert alert-success mt-3">
        Félicitations 🎉 Tu as complété toute la formation !
    </div>
@endif

     {{-- 🎞️ Galerie de vidéos de la formation --}}

    <h3>Contenu vidéo de la formation :</h3>

<p><strong>Vidéos vues :</strong> {{ auth()->user()->videosVues->intersect($formation->videos)->count() }} / {{ $formation->videos->count() }}</p>


@forelse($formation->videos as $video)
    <div class="mb-4 {{ auth()->user()->videosVues->contains($video->id) ? 'border border-success p-2' : '' }}">
        <h5>{{ $video->title }}</h5>
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
    <video width="720" controls class="mb-3">
        <source src="{{ asset($video->video_url) }}" type="video/mp4">
        Votre navigateur ne supporte pas la vidéo.
    </video>
@endif



        {{-- ✅ Progression individuelle --}}
     @auth
    @if(auth()->user()->videosVues->contains($video->id))
        <span class="badge bg-success">✔️ Vue</span>
    @else
        <form method="POST" action="{{ route('videos.vue', $video) }}">
            @csrf
            <button type="submit" class="btn btn-outline-success btn-sm mt-2">✅ Marquer comme vue</button>
        </form>
    @endif
@endauth

    </div>

  @if(auth()->user()->id === $formation->creator_id)
    <a href="{{ route('videos.create', $formation->id) }}" class="btn btn-primary mb-4">
        ➕ Ajouter une vidéo
    </a>
@endif

@empty
    <p>Aucune vidéo n’a encore été ajoutée à cette formation.</p>
@endforelse

    {{-- 📷 Image de couverture --}}
    @if($formation->cover_image)
        <img src="{{ asset('storage/' . $formation->cover_image) }}" class="img-fluid mb-3" alt="Image de couverture">
    @endif

    {{-- 👥 Bouton vers les inscrits --}}
    <a href="{{ route('formations.inscrits', $formation) }}" class="btn btn-success">👥 Voir les inscrits</a>

    <a href="{{ route('formations.mes') }}" class="btn btn-secondary mt-4">⬅️ Retour à mes formations</a>

</div>
@endsection
