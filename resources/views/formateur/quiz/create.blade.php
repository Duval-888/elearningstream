@extends('layouts.dashboard')

@section('content')
@php
    $hasCourses = isset($courses) && $courses->count() > 0;
@endphp

<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
        <div class="p-6 md:p-8 bg-gradient-to-r from-emerald-600 to-sky-500 text-white">
            <h1 class="text-2xl md:text-3xl font-bold">
                <i class="fa-solid fa-plus mr-2"></i>Nouveau quiz
            </h1>
        </div>

        {{-- Affichage rapide des erreurs globales --}}
        @if ($errors->any())
            <div class="mx-6 mt-6 rounded-lg border border-rose-200 bg-rose-50 text-rose-800 px-4 py-3 text-sm">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                Veuillez corriger les erreurs du formulaire ci-dessous.
            </div>
        @endif

        <form action="{{ route('formateur.quizzes.store') }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf

            {{-- Titre --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    required
                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                    placeholder="Ex. Quiz Laravel – Bases"
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
                    placeholder="Courte description du quiz (facultatif)…"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- 🎯 Cours associé --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cours associé</label>

                @if($hasCourses)
                    <select
                        name="course_id"
                        required
                        class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                    >
                        <option value="" disabled {{ old('course_id') ? '' : 'selected' }}>— Choisir un cours —</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ (string)old('course_id') === (string)$course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        Ce quiz sera rattaché à ce cours (visible dans sa page et son écosystème).
                    </p>
                @else
                    <div class="rounded-lg border border-amber-200 bg-amber-50 text-amber-800 px-4 py-3 text-sm">
                        <i class="fa-solid fa-circle-info mr-2"></i>
                        Aucun cours trouvé. Crée d’abord un cours, puis reviens ici pour l’attacher au quiz.
                    </div>
                    <a href="{{ route('courses.create') }}"
                       class="mt-3 inline-flex items-center gap-2 rounded-lg bg-sky-600 hover:bg-sky-700 text-white px-3 py-2 text-sm">
                        <i class="fa-solid fa-plus"></i> Créer un cours
                    </a>
                @endif
            </div>

            {{-- Publication --}}
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" id="is_published" value="1"
                       class="rounded text-emerald-600" {{ old('is_published') ? 'checked' : '' }}>
                <label for="is_published" class="text-sm text-gray-700">Publier maintenant</label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('formateur.quizzes') }}"
                   class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700">
                    Annuler
                </a>
                <button
                    class="px-4 py-2 rounded-lg text-white {{ $hasCourses ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-emerald-600/50 cursor-not-allowed' }}"
                    {{ $hasCourses ? '' : 'disabled' }}
                    title="{{ $hasCourses ? '' : 'Créez d’abord un cours pour pouvoir créer un quiz' }}"
                >
                    <i class="fa-solid fa-floppy-disk mr-2"></i>Créer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
