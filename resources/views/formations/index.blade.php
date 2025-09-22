@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Header + CTA --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100">
                    <i class="fa-solid fa-books text-emerald-600"></i>
                </span>
                Mes formations
            </h1>
            <p class="mt-1 text-sm text-gray-500">Crée, modifie et organise tes contenus en un clin d’œil.</p>
        </div>

        <div class="flex items-center gap-3">
            <span class="hidden sm:inline-flex items-center gap-2 rounded-lg bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-600 ring-1 ring-gray-200">
                <i class="fa-solid fa-layer-group"></i>
                {{ $formations->count() }} formation(s)
            </span>

            <a href="{{ route('formations.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/60 focus:ring-offset-2">
                <i class="fa-solid fa-plus"></i> Nouvelle formation
            </a>
        </div>
    </div>

    {{-- Flash succès --}}
    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Liste / Tableau --}}
    @if($formations->isEmpty())
        <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-14 text-center">
            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-50">
                <i class="fa-regular fa-folder-open text-gray-400"></i>
            </div>
            <h3 class="text-base font-semibold text-gray-800">Aucune formation</h3>
            <p class="mt-1 text-sm text-gray-500">Crée ta première formation pour commencer.</p>
            <a href="{{ route('formations.create') }}"
               class="mt-4 inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                <i class="fa-solid fa-plus"></i> Ajouter une formation
            </a>
        </div>
    @else
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr class="text-gray-700">
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Titre</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Niveau</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Prix (€)</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($formations as $formation)
                            <tr class="hover:bg-gray-50/60">
                                {{-- Titre + desc courte --}}
                                <td class="px-6 py-4 align-top">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-1 hidden sm:flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50">
                                            <i class="fa-solid fa-graduation-cap text-indigo-600"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $formation->title }}</div>
                                            @if(!empty($formation->description))
                                                <div class="mt-0.5 text-sm text-gray-500 line-clamp-2 max-w-[48ch]">
                                                    {{ $formation->description }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Niveau --}}
                                <td class="px-6 py-4 align-top">
                                    <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 ring-1 ring-blue-200">
                                        <i class="fa-solid fa-signal"></i> {{ ucfirst($formation->level) }}
                                    </span>
                                </td>

                                {{-- Prix --}}
                                <td class="px-6 py-4 align-top">
                                    <div class="font-semibold text-gray-900">
                                        {{ number_format($formation->price, 2) }} €
                                    </div>
                                </td>

                                {{-- Statut --}}
                                <td class="px-6 py-4 align-top">
                                    @if($formation->is_active)
                                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">
                                            <i class="fa-solid fa-circle"></i> Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-700 ring-1 ring-gray-200">
                                            <i class="fa-regular fa-circle"></i> Inactive
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        {{-- Modifier --}}
                                        <a href="{{ route('formations.edit', $formation) }}"
                                           class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">
                                            <i class="fa-solid fa-pen"></i> Modifier
                                        </a>

                                        {{-- Voir (slug respecté) --}}
                                        <a href="{{ route('formations.show', $formation->slug) }}"
                                           class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-3 py-2 text-xs font-semibold text-white hover:bg-indigo-700">
                                            <i class="fa-solid fa-eye"></i> Voir le cours
                                        </a>

                                        {{-- Supprimer --}}
                                        <form action="{{ route('formations.destroy', $formation) }}"
                                              method="POST"
                                              onsubmit="return confirm('Confirmer la suppression ?')"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-2 rounded-lg bg-rose-600 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-700">
                                                <i class="fa-solid fa-trash"></i> Supprimer
                                            </button>
                                        </form>

                                        {{-- Gérer les vidéos --}}
                                        <a href="{{ route('formations.videos', $formation) }}"
                                           class="inline-flex items-center gap-2 rounded-lg border border-amber-300 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-800 hover:bg-amber-100">
                                            <i class="fa-solid fa-film"></i> Gérer les vidéos
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Aperçus vidéo (en dehors du tableau) --}}
        @php
            $withVideos = $formations->filter(fn($f) => !empty($f->video_url));
        @endphp

        @if($withVideos->isNotEmpty())
            <div class="mt-10">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-clapperboard text-amber-500"></i>
                    Aperçu vidéo des formations
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($withVideos as $formation)
                        @php
                            $embedUrl = Str::replace('watch?v=', 'embed/', $formation->video_url);
                        @endphp
                        <div class="rounded-2xl overflow-hidden border border-gray-200 bg-white shadow-sm">
                            <div class="aspect-video">
                                <iframe
                                    src="{{ $embedUrl }}"
                                    class="h-full w-full"
                                    frameborder="0"
                                    allowfullscreen
                                    loading="lazy"></iframe>
                            </div>
                            <div class="px-4 py-3">
                                <div class="font-semibold text-gray-900">{{ $formation->title }} 🎬</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endif
</div>
@endsection
