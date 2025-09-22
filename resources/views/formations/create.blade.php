@php use Illuminate\Support\Str; @endphp
@extends('layouts.dashboard')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">

    {{-- Titre + retour --}}
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100">
                <i class="fa-solid fa-graduation-cap text-emerald-600"></i>
            </span>
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900">
                    Ajouter une nouvelle formation
                </h1>
                <p class="text-sm text-gray-500">Renseigne les informations ci-dessous puis publie.</p>
            </div>
        </div>

        <a href="{{ route('formations.index') }}"
           class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
            <i class="fa-solid fa-arrow-left"></i> Retour
        </a>
    </div>

    {{-- Flash succès --}}
    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Erreurs de validation --}}
    @if($errors->any())
        <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800">
            <div class="font-semibold mb-1"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Erreurs à corriger</div>
            <ul class="list-disc pl-5 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Carte formulaire --}}
    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
        <form action="{{ route('formations.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
            @csrf

            {{-- Titre + Slug --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">
                        <i class="fa-solid fa-heading mr-2 text-indigo-600"></i>Titre
                    </label>
                    <input type="text" name="title" id="title" required
                           value="{{ old('title') }}"
                           class="mt-2 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700">
                        <i class="fa-solid fa-link mr-2 text-indigo-600"></i>Slug (identifiant URL)
                    </label>
                    <input type="text" name="slug" id="slug" required
                           value="{{ old('slug') }}"
                           placeholder="ex: laravel-pour-debutants"
                           class="mt-2 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="mt-1 text-xs text-gray-500">Il sera utilisé dans l’URL de la formation.</p>
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">
                    <i class="fa-regular fa-file-lines mr-2 text-indigo-600"></i>Description
                </label>
                <textarea name="description" id="description" rows="4"
                          class="mt-2 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
            </div>

            {{-- Niveau / Prix / Statut --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="level" class="block text-sm font-medium text-gray-700">
                        <i class="fa-solid fa-signal mr-2 text-indigo-600"></i>Niveau
                    </label>
                    <select name="level" id="level" required
                            class="mt-2 block w-full rounded-xl border-gray-300 bg-white focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="debutant"     @selected(old('level')==='debutant')>Débutant</option>
                        <option value="intermediaire"@selected(old('level')==='intermediaire')>Intermédiaire</option>
                        <option value="avance"       @selected(old('level')==='avance')>Avancé</option>
                    </select>
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">
                        <i class="fa-solid fa-tag mr-2 text-indigo-600"></i>Prix (€)
                    </label>
                    <input type="number" name="price" id="price" step="0.01" min="0" value="{{ old('price', 0) }}"
                           class="mt-2 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="is_active" class="block text-sm font-medium text-gray-700">
                        <i class="fa-solid fa-toggle-on mr-2 text-indigo-600"></i>Activer la formation
                    </label>
                    <select name="is_active" id="is_active"
                            class="mt-2 block w-full rounded-xl border-gray-300 bg-white focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="1" @selected(old('is_active', 1)==1)>Oui</option>
                        <option value="0" @selected(old('is_active', 1)==0)>Non</option>
                    </select>
                </div>
            </div>

            {{-- Lien YouTube (teaser) --}}
            <div>
                <label for="video_url" class="block text-sm font-medium text-gray-700">
                    <i class="fa-brands fa-youtube mr-2 text-red-600"></i>Lien YouTube
                </label>
                <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}"
                       placeholder="https://www.youtube.com/watch?v=..."
                       class="mt-2 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                <p class="mt-1 text-xs text-gray-500">Optionnel — utile comme teaser sur la page de présentation.</p>
            </div>

            {{-- Image de couverture + aperçu --}}
            <div>
                <label for="cover_image" class="block text-sm font-medium text-gray-700">
                    <i class="fa-regular fa-image mr-2 text-indigo-600"></i>Image de couverture
                </label>
                <div class="mt-2 flex items-start gap-4">
                    <input type="file" name="cover_image" id="cover_image"
                           accept="image/*"
                           class="block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <img id="coverPreview"
                         class="hidden h-20 w-32 rounded-lg object-cover ring-1 ring-gray-200"
                         alt="Aperçu couverture">
                </div>
                <p class="mt-1 text-xs text-gray-500">Formats recommandés : JPG/PNG, 1200×630px.</p>
            </div>

            {{-- Actions --}}
            <div class="pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/60 focus:ring-offset-2">
                    <i class="fa-solid fa-floppy-disk"></i> Créer la formation
                </button>
            </div>
        </form>
    </div>
</div>

{{-- JS : génération douce du slug + aperçu image --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const title = document.getElementById('title');
    const slug  = document.getElementById('slug');
    const file  = document.getElementById('cover_image');
    const prev  = document.getElementById('coverPreview');

    // Auto-slug (n’altère pas la logique backend)
    const toSlug = (s) => s
        .toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // retire accents
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');

    title?.addEventListener('input', () => {
        if (!slug.value || slug.dataset.touched !== '1') {
            slug.value = toSlug(title.value);
        }
    });
    slug?.addEventListener('input', () => slug.dataset.touched = '1');

    // Aperçu image
    file?.addEventListener('change', (e) => {
        const f = e.target.files?.[0];
        if (!f) { prev.classList.add('hidden'); prev.src=''; return; }
        const reader = new FileReader();
        reader.onload = (ev) => {
            prev.src = ev.target.result;
            prev.classList.remove('hidden');
        };
        reader.readAsDataURL(f);
    });
});
</script>
@endsection
