@php
    use Illuminate\Support\Str;

    // Sécurise le comptage si l'utilisateur n'est pas connecté
    $seenCount = auth()->check()
        ? auth()->user()->videosVues->intersect($formation->videos)->count()
        : 0;
@endphp

@extends('layouts.dashboard')

@section('content')
    {{-- Flash succès --}}
    @if(session('success'))
        <div class="max-w-6xl mx-auto px-4 mt-6">
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3">
                <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
            </div>
        </div>
    @endif

    <div class="max-w-6xl mx-auto px-4 py-8">
        {{-- En-tête formation --}}
        <div class="flex items-start gap-4 mb-6">
            <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100">
                <i class="fa-solid fa-graduation-cap text-emerald-600 text-xl"></i>
            </span>
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $formation->title }}</h1>
                <p class="text-gray-500 mt-1">{{ $formation->description }}</p>
                <div class="mt-3 flex flex-wrap items-center gap-3 text-sm">
                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 text-emerald-700 px-3 py-1 border border-emerald-200">
                        <i class="fa-solid fa-signal"></i> Niveau : <span class="font-semibold">{{ ucfirst($formation->level) }}</span>
                    </span>
                    <span class="inline-flex items-center gap-2 rounded-full bg-indigo-50 text-indigo-700 px-3 py-1 border border-indigo-200">
                        <i class="fa-solid fa-tag"></i> Prix : <span class="font-semibold">{{ number_format($formation->price, 2, ',', ' ') }} €</span>
                    </span>
                    <span class="inline-flex items-center gap-2 rounded-full bg-gray-50 text-gray-700 px-3 py-1 border border-gray-200">
                        <i class="fa-regular fa-circle-play"></i>
                        Vidéos vues : <span class="font-semibold">{{ $seenCount }}</span> / {{ $formation->videos->count() }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Lecteur principal (teaser / vidéo de la formation) --}}
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

            <div class="rounded-2xl overflow-hidden shadow-md border border-gray-200 mb-8">
                <div class="relative w-full" style="padding-top:56.25%;">
                    @if($isYoutube)
                        <iframe
                            src="{{ $embedUrl }}"
                            class="absolute inset-0 w-full h-full"
                            frameborder="0" allowfullscreen
                        ></iframe>
                    @else
                        <video controls class="absolute inset-0 w-full h-full bg-black">
                            <source src="{{ asset($formation->video_url) }}" type="video/mp4">
                            Votre navigateur ne supporte pas la vidéo.
                        </video>
                    @endif
                </div>
            </div>
        @else
            <div class="rounded-xl border border-amber-200 bg-amber-50 text-amber-800 px-4 py-3 mb-8">
                <i class="fa-solid fa-circle-info mr-2"></i>Aucune vidéo principale n’est disponible pour cette formation.
            </div>
        @endif

        {{-- Progression --}}
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                <i class="fa-solid fa-chart-line text-emerald-600 mr-1"></i>
                Progression de la formation
            </h3>
            <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                <div
                    class="bg-emerald-500 h-4"
                    style="width: {{ $progression }}%;"
                    aria-valuenow="{{ $progression }}" aria-valuemin="0" aria-valuemax="100"
                ></div>
            </div>
            @if($progression < 100)
                <p class="text-sm text-gray-500 mt-2">📈 Tu as complété <strong>{{ $progression }}%</strong> de cette formation. Continue comme ça !</p>
            @endif

            @if($progression === 100)
                <div class="mt-4 flex flex-wrap items-center gap-3">
                    <a href="{{ route('formations.certificat', $formation) }}"
                       class="inline-flex items-center gap-2 rounded-xl border border-indigo-200 bg-indigo-50 px-4 py-2 text-indigo-700 hover:bg-indigo-100">
                        <i class="fa-solid fa-award"></i> Télécharger mon certificat
                    </a>
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-2">
                        🎉 Félicitations ! Tu as complété toute la formation.
                    </div>
                </div>
            @endif
        </div>

        {{-- Contenu vidéo détaillé --}}
        <h3 class="text-xl font-bold text-gray-900 mb-4">
            <i class="fa-regular fa-circle-play text-emerald-600 mr-2"></i>
            Contenu vidéo de la formation
        </h3>

        @forelse($formation->videos as $video)
            @php
                $isYoutube = Str::contains($video->video_url, 'youtube.com') || Str::contains($video->video_url, 'youtu.be');
                $embedUrl = null;
                if ($isYoutube && Str::contains($video->video_url, 'watch?v=')) {
                    $embedUrl = Str::replace('watch?v=', 'embed/', $video->video_url);
                } elseif ($isYoutube && Str::contains($video->video_url, 'youtu.be/')) {
                    $videoId = Str::after($video->video_url, 'youtu.be/');
                    $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                }
                $seen = auth()->check() ? auth()->user()->videosVues->contains($video->id) : false;
            @endphp

            <div class="mb-6 rounded-2xl border {{ $seen ? 'border-emerald-200 ring-1 ring-emerald-100' : 'border-gray-200' }} bg-white shadow-sm">
                <div class="p-4 md:p-5">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <h4 class="text-lg font-semibold text-gray-900">
                            {{ $video->title }}
                        </h4>

                        {{-- Badge vue / action marquer vue --}}
                        @auth
                            @if($seen)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-sm font-medium text-emerald-700 border border-emerald-200">
                                    <i class="fa-solid fa-check"></i> Vue
                                </span>
                            @else
                                <form method="POST" action="{{ route('videos.vue', $video) }}">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-2 rounded-full border border-emerald-300 bg-white px-3 py-1.5 text-sm font-medium text-emerald-700 hover:bg-emerald-50">
                                        <i class="fa-regular fa-square-check"></i> Marquer comme vue
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>

                    {{-- Lecteur vidéo --}}
                    <div class="rounded-xl overflow-hidden border border-gray-200 bg-black">
                        <div class="relative w-full" style="padding-top:56.25%;">
                            @if($isYoutube)
                                <iframe
                                    src="{{ $embedUrl }}"
                                    class="absolute inset-0 w-full h-full"
                                    frameborder="0" allowfullscreen
                                ></iframe>
                            @else
                                <video controls class="absolute inset-0 w-full h-full">
                                    <source src="{{ asset($video->video_url) }}" type="video/mp4">
                                    Votre navigateur ne supporte pas la vidéo.
                                </video>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-xl border border-gray-200 bg-white p-6 text-gray-600">
                Aucune vidéo n’a encore été ajoutée à cette formation.
            </div>
        @endforelse

        {{-- Actions bas de page --}}
        <div class="mt-8 flex flex-wrap items-center gap-3">
            @if($formation->cover_image)
                <img src="{{ asset('storage/' . $formation->cover_image) }}"
                     alt="Image de couverture"
                     class="h-24 w-40 object-cover rounded-lg border border-gray-200 shadow-sm">
            @endif

            <a href="{{ route('formations.inscrits', $formation) }}"
               class="inline-flex items-center gap-2 rounded-xl border border-emerald-300 bg-emerald-50 px-4 py-2 text-emerald-700 hover:bg-emerald-100">
                <i class="fa-solid fa-users"></i> Voir les inscrits
            </a>

            {{-- Retour : utilise la route unifiée des « mes formations » --}}
            <a href="{{ route('mes.formations') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-4 py-2 text-gray-700 hover:bg-gray-50">
                <i class="fa-solid fa-arrow-left-long"></i> Retour à mes formations
            </a>

            {{-- Bouton "Ajouter une vidéo" réservé au créateur --}}
            @auth
                @if(auth()->user()->id === $formation->creator_id)
                    <a href="{{ route('videos.create', $formation->id) }}"
                       class="inline-flex items-center gap-2 rounded-xl border border-indigo-300 bg-indigo-50 px-4 py-2 text-indigo-700 hover:bg-indigo-100">
                        <i class="fa-solid fa-circle-plus"></i> Ajouter une vidéo
                    </a>
                @endif
            @endauth
        </div>
    </div>
@endsection
