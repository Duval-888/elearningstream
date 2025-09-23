@php
    use Illuminate\Support\Str;

    // Poster (miniature) optionnel : on réutilise l'image de couverture de la formation si dispo
    $posterUrl = isset($formation->cover_image) && $formation->cover_image
        ? (Str::startsWith($formation->cover_image, ['http://','https://'])
            ? $formation->cover_image
            : asset('storage/'.$formation->cover_image))
        : null;
@endphp

@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-start gap-3">
            <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100">
                <i class="fa-solid fa-clapperboard text-emerald-600 text-xl"></i>
            </span>
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900">
                    Gestion des vidéos — <span class="text-indigo-600">{{ $formation->title }}</span>
                </h1>
                <p class="text-sm text-gray-500">{{ $videos->count() }} vidéo(s) au total</p>
            </div>
        </div>

        <a href="{{ route('videos.create', $formation) }}"
           class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/60 focus:ring-offset-2">
            <i class="fa-solid fa-plus"></i> Ajouter une vidéo
        </a>
    </div>

    {{-- Liste des vidéos --}}
    @forelse($videos as $video)

        @php
            // Pour les badges (YouTube / type de fichier)
            $url = $video->video_url ?? '';
            $isYouTube = (bool) preg_match('/(youtube\.com|youtu\.be)/i', $url);

            // Déterminer une étiquette simple côté badge (MP4, MKV, WEBM, …)
            $path = parse_url($url, PHP_URL_PATH) ?? '';
            $ext  = Str::lower(pathinfo($path, PATHINFO_EXTENSION));
            $typeText = $isYouTube ? 'YouTube' : ($ext ? Str::upper($ext) : 'Fichier');
        @endphp

        <div class="mb-6 rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
            {{-- En-tête carte --}}
            <div class="flex items-start justify-between gap-3 p-5">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $video->title }}</h3>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-200">
                            <i class="fa-solid fa-list-ol"></i>
                            Ordre : {{ $video->ordre ?? '—' }}
                        </span>
                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-200">
                            <i class="{{ $isYouTube ? 'fa-brands fa-youtube' : 'fa-solid fa-film' }}"></i>
                            {{ $typeText }}
                        </span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('videos.edit', $video) }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-indigo-200 bg-white px-3 py-2 text-sm font-semibold text-indigo-700 hover:bg-indigo-50">
                        <i class="fa-solid fa-pen-to-square"></i> Modifier
                    </a>

                    {{-- Créer un quiz pour cette vidéo (assure-toi d'avoir défini cette route) --}}
                    <a href="{{ route('videos.quizzes.create', $video) }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-600 px-3 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                        <i class="fa-solid fa-clipboard-question"></i> Créer un quiz
                    </a>

                    <form action="{{ route('videos.destroy', $video) }}" method="POST"
                          onsubmit="return confirm('Supprimer cette vidéo ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-2 rounded-lg border border-rose-200 bg-white px-3 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-50">
                            <i class="fa-solid fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>

            {{-- Player (UN SEUL) via le partial réutilisable --}}
            <div class="bg-gray-50">
                @include('partials.video_player', [
                    'video'  => $video,
                    'poster' => $posterUrl,   // optionnel, peut être null
                ])
            </div>
        </div>
    @empty
        {{-- Empty state --}}
        <div class="rounded-2xl border-2 border-dashed border-gray-300 p-10 text-center bg-white">
            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100">
                <i class="fa-solid fa-video text-indigo-600"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Aucune vidéo pour le moment</h3>
            <p class="mt-1 text-sm text-gray-500">Ajoute ta première vidéo pour cette formation.</p>
            <a href="{{ route('videos.create', $formation) }}"
               class="mt-4 inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">
                <i class="fa-solid fa-plus"></i> Ajouter une vidéo
            </a>
        </div>
    @endforelse

</div>
@endsection
