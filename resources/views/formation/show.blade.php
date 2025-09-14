@php use Illuminate\Support\Str; @endphp

@extends('layouts.dashboard')

@section('content')
<div class="container mt-5">
    <h2>{{ $formation->title }}</h2>

    <p class="text-muted">{{ $formation->description }}</p>

   <p><strong>Niveau :</strong> {{ ucfirst($formation->level) }}</p>
<p><strong>Prix :</strong> {{ $formation->price }} €</p>

{{-- 🎬 Intégration de la vidéo YouTube en grand format --}}
@if($formation->video_url)
    @php
        $embedUrl = $formation->video_url;

        if (Str::contains($embedUrl, 'watch?v=')) {
            $embedUrl = Str::replace('watch?v=', 'embed/', $embedUrl);
        } elseif (Str::contains($embedUrl, 'youtu.be/')) {
            $videoId = Str::after($embedUrl, 'youtu.be/');
            $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
        }
    @endphp

    <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; margin-bottom: 30px;">
        <iframe 
            src="{{ $embedUrl }}" 
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" 
            frameborder="0" 
            allowfullscreen>
        </iframe>
    </div>
@endif



    {{-- 📷 Image de couverture --}}
    @if($formation->cover_image)
        <img src="{{ asset('storage/' . $formation->cover_image) }}" class="img-fluid mb-3" alt="Image de couverture">
    @endif

    <a href="{{ route('formations.inscrits', $formation) }}" class="btn btn-success">👥 Voir les inscrits</a>
</div>
@endsection
