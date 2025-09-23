@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">

    {{-- En-tête --}}
    <div class="mb-6 flex items-start gap-3">
        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100">
            <i class="fa-solid fa-film text-emerald-600 text-xl"></i>
        </span>
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900">
                Ajouter une vidéo
            </h1>
            <p class="text-sm text-gray-500">
                Formation : <span class="font-semibold text-indigo-600">{{ $formation->title }}</span>
            </p>
        </div>
    </div>

    {{-- Erreurs de validation --}}
    @if ($errors->any())
        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 p-4 text-rose-800">
            <div class="mb-1 font-semibold">
                <i class="fa-solid fa-triangle-exclamation"></i> Veuillez corriger les champs suivants :
            </div>
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Carte formulaire --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('videos.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="hidden" name="formation_id" value="{{ $formation->id }}">

            {{-- Titre --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fa-solid fa-heading text-indigo-600 mr-1"></i> Titre de la vidéo
                </label>
                <input type="text" id="title" name="title" required
                       class="block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                       placeholder="Ex. Introduction au module 1">
            </div>

            {{-- 📁 Fichier vidéo (tous formats courants) --}}
            <div>
                <label for="video" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fa-solid fa-file-video text-emerald-600 mr-1"></i>
                    Fichier vidéo (MP4, MKV, WebM, MOV, AVI, OGG, M4V)
                </label>
                {{-- ✅ Étape 2 : acceptation de tous les formats vidéo --}}
                <input
                    type="file"
                    id="video"
                    name="video"
                    accept="video/*"
                    class="block w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 file:mr-4 file:rounded-lg file:border-0 file:bg-emerald-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-emerald-700"
                >
                <p class="mt-2 text-xs text-gray-500">
                    Optionnel si vous fournissez un lien YouTube. Taille max selon configuration serveur.
                </p>
            </div>

            {{-- 🔗 Lien YouTube --}}
            <div>
                <label for="youtube_url" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fa-brands fa-youtube text-red-600 mr-1"></i> Lien YouTube (optionnel)
                </label>
                <input type="url" id="youtube_url" name="youtube_url"
                       class="block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                       placeholder="https://www.youtube.com/watch?v=...">
                <p class="mt-2 text-xs text-gray-500">Fournissez soit un fichier vidéo, soit un lien YouTube.</p>
            </div>

            {{-- Ordre --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="ordre" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-solid fa-list-ol text-indigo-600 mr-1"></i> Ordre (facultatif)
                    </label>
                    <input type="number" id="ordre" name="ordre"
                           class="block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                           placeholder="Ex. 1">
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/60 focus:ring-offset-2">
                    <i class="fa-solid fa-circle-plus"></i> Ajouter la vidéo
                </button>

                <a href="{{ route('formations.videos', $formation) }}"
                   class="inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    <i class="fa-solid fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
