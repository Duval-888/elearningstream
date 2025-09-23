{{-- resources/views/formateur/quiz/create.blade.php (ou create_for_video.blade.php) --}}
@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">

        {{-- En-tête avec contexte vidéo --}}
        <div class="p-6 md:p-8 bg-gradient-to-r from-emerald-600 to-sky-500 text-white">
            <h1 class="text-2xl md:text-3xl font-bold">
                <i class="fa-solid fa-plus mr-2"></i> Nouveau quiz pour cette vidéo
            </h1>
            <p class="mt-2 text-sm text-white/90">
                <i class="fa-solid fa-film mr-1"></i> {{ $video->title }}
            </p>
        </div>

        {{-- Flash succès / erreurs globales --}}
        @if(session('success'))
            <div class="mx-6 mt-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mx-6 mt-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                Veuillez corriger les erreurs ci-dessous.
            </div>
        @endif

        <form action="{{ route('videos.quizzes.store', $video) }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf

            {{-- Rappel de la cible --}}
            <div class="rounded-xl bg-gray-50 p-4 text-sm text-gray-700">
                <div class="font-medium mb-1">
                    <i class="fa-solid fa-clapperboard mr-2 text-indigo-600"></i>Vidéo ciblée :
                </div>
                <div class="truncate">{{ $video->video_url }}</div>
                @if(isset($video->ordre))
                    <div class="mt-1 text-xs text-gray-500">Ordre : {{ $video->ordre }}</div>
                @endif
            </div>

            {{-- Titre --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    required
                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                    placeholder="Ex. Quiz — Chapitre 1 : introduction"
                >
                @error('title')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea
                    name="description"
                    rows="4"
                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                    placeholder="Petite description du quiz (facultatif)…"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Publication immédiate --}}
            <div class="flex items-center gap-2">
                <input
                    type="checkbox"
                    name="is_published"
                    id="is_published"
                    value="1"
                    class="rounded text-emerald-600"
                    {{ old('is_published') ? 'checked' : '' }}
                >
                <label for="is_published" class="text-sm text-gray-700">Publier maintenant</label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('formations.videos', $video->formation_id) }}"
                   class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700">
                    Annuler
                </a>
                <button class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>Créer le quiz
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
