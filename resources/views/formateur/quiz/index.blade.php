@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    {{-- Flash messages --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 text-rose-800 px-4 py-3">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i>{{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-amber-200 bg-amber-50 text-amber-800 px-4 py-3">
            <i class="fa-regular fa-circle-xmark mr-2"></i>Veuillez corriger les erreurs du formulaire.
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                <i class="fa-solid fa-clipboard-question mr-2 text-emerald-600"></i>
                Mes quiz
            </h1>
            <p class="text-sm text-gray-500 mt-1">Créez, modifiez et organisez vos évaluations.</p>
        </div>

        <a href="{{ route('formateur.quizzes.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm">
            <i class="fa-solid fa-plus"></i>
            Nouveau quiz
        </a>
    </div>

    {{-- Toolbar (recherche / filtres) --}}
    <form method="GET" action="{{ url()->current() }}" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <label class="text-xs font-medium text-gray-600 mb-1 block">Recherche</label>
                <input type="text" name="q" value="{{ request('q') }}"
                       class="w-full rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500"
                       placeholder="Rechercher un quiz…">
            </div>
            <div>
                <label class="text-xs font-medium text-gray-600 mb-1 block">Statut</label>
                <select name="status"
                        class="w-full rounded-lg border-gray-300 bg-white focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Tous</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publié</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-sky-600 px-4 py-2 text-white hover:bg-sky-700">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Filtrer
                </button>
            </div>
        </div>
    </form>

    {{-- Grid des quiz --}}
    @if($quizzes->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($quizzes as $quiz)
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-100 p-5 flex flex-col">
                    <div class="flex items-start justify-between">
                        <h3 class="font-semibold text-gray-900 line-clamp-2">{{ $quiz->title }}</h3>
                        <span class="ml-3 inline-flex items-center gap-1 text-[11px] px-2 py-1 rounded-full
                                     {{ $quiz->is_published ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                            <i class="fa-solid fa-bullhorn"></i>
                            {{ $quiz->is_published ? 'Publié' : 'Brouillon' }}
                        </span>
                    </div>

                    @if(!empty($quiz->description))
                        <p class="text-sm text-gray-600 mt-2 line-clamp-3">{{ $quiz->description }}</p>
                    @endif

                    <div class="mt-4 flex items-center gap-3 text-xs text-gray-500">
                        <span class="inline-flex items-center gap-1">
                            <i class="fa-regular fa-circle-question"></i>
                            {{ $quiz->questions_count ?? 0 }} question(s)
                        </span>
                        <span class="inline-flex items-center gap-1">
                            <i class="fa-regular fa-clock"></i>
                            {{ optional($quiz->updated_at)->diffForHumans() }}
                        </span>
                    </div>

                    <div class="mt-5 flex items-center gap-2">
                        <a href="{{ route('formateur.quizzes.edit', $quiz) }}"
                           class="px-3 py-2 rounded-lg bg-sky-600 hover:bg-sky-700 text-white text-sm">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Éditer
                        </a>

                        <form action="{{ route('formateur.quizzes.destroy', $quiz) }}"
                              method="POST"
                              onsubmit="return confirm('Supprimer ce quiz ?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm">
                                <i class="fa-solid fa-trash-can mr-1"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $quizzes->links() }}
        </div>
    @else
        <div class="rounded-xl border border-gray-200 bg-white p-10 text-center">
            <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 mb-3">
                <i class="fa-solid fa-clipboard-question"></i>
            </div>
            <p class="text-gray-700 font-medium">Aucun quiz pour l’instant.</p>
            <p class="text-sm text-gray-500">Créez votre premier quiz pour commencer.</p>
            <a href="{{ route('formateur.quizzes.create') }}"
               class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white">
                <i class="fa-solid fa-plus"></i> Nouveau quiz
            </a>
        </div>
    @endif
</div>
@endsection
