@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">

    {{-- En-tête --}}
    <div class="mb-6 flex items-start gap-3">
        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-100">
            <i class="fa-solid fa-pen-to-square text-indigo-600 text-xl"></i>
        </span>
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900">
                Modifier la formation
            </h1>
            <p class="text-sm text-gray-500">
                <i class="fa-solid fa-book-open text-emerald-600 mr-1"></i>
                {{ $formation->title }}
            </p>
        </div>
    </div>

    {{-- Flash success --}}
    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
        </div>
    @endif

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
        <form action="{{ route('formations.update', $formation) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Titre --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fa-solid fa-heading text-indigo-600 mr-1"></i> Titre
                </label>
                <input
                    type="text" id="title" name="title" required
                    value="{{ old('title', $formation->title) }}"
                    class="block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Ex. Laravel pour débutants"
                >
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fa-solid fa-align-left text-emerald-600 mr-1"></i> Description
                </label>
                <textarea
                    id="description" name="description" rows="4"
                    class="block w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                    placeholder="Quelques lignes sur le contenu de la formation…"
                >{{ old('description', $formation->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                {{-- Niveau --}}
                <div>
                    <label for="level" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-solid fa-signal text-indigo-600 mr-1"></i> Niveau
                    </label>
                    <select id="level" name="level"
                            class="block w-full rounded-xl border-gray-300 bg-white focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="debutant"     {{ old('level', $formation->level) === 'debutant' ? 'selected' : '' }}>Débutant</option>
                        <option value="intermediaire" {{ old('level', $formation->level) === 'intermediaire' ? 'selected' : '' }}>Intermédiaire</option>
                        <option value="avance"        {{ old('level', $formation->level) === 'avance' ? 'selected' : '' }}>Avancé</option>
                    </select>
                </div>

                {{-- Prix --}}
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-solid fa-tag text-emerald-600 mr-1"></i> Prix (€)
                    </label>
                    <input
                        type="number" step="0.01" id="price" name="price"
                        value="{{ old('price', $formation->price) }}"
                        class="block w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="0.00"
                    >
                </div>

                {{-- Statut --}}
                <div>
                    <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-solid fa-toggle-on text-indigo-600 mr-1"></i> Statut
                    </label>
                    <select id="is_active" name="is_active"
                            class="block w-full rounded-xl border-gray-300 bg-white focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="1" {{ old('is_active', $formation->is_active) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !old('is_active', $formation->is_active) ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/60 focus:ring-offset-2">
                    <i class="fa-solid fa-floppy-disk"></i> Enregistrer
                </button>

                <a href="{{ route('formations.show', $formation) }}"
                   class="inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    <i class="fa-solid fa-eye"></i> Voir la formation
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
