@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-6 flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">
                <i class="fa-solid fa-clipboard-question text-emerald-600 mr-2"></i> Gestion des Quiz
            </h1>
            <p class="text-gray-500">Créez des quiz pour évaluer vos apprenants et suivre leurs progrès.</p>
        </div>

        {{-- CTA (disconnected pour l’instant) --}}
        <button type="button"
                class="inline-flex items-center gap-2 rounded-xl border border-emerald-300 bg-emerald-50 px-4 py-2 text-emerald-700 hover:bg-emerald-100">
            <i class="fa-solid fa-circle-plus"></i> Créer un quiz
        </button>
    </div>

    {{-- État vide (par défaut) --}}
    @php
        $quizzes = $quizzes ?? collect(); // évite "Undefined variable"
    @endphp

    @if($quizzes->isEmpty())
        <div class="rounded-2xl bg-white border border-dashed border-emerald-300 p-8 text-center">
            <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50 border border-emerald-200 mb-4">
                <i class="fa-solid fa-clipboard-question text-emerald-600 text-2xl"></i>
            </div>
            <h2 class="text-xl font-semibold text-gray-800">Aucun quiz pour le moment</h2>
            <p class="text-gray-500 mt-1">Clique sur <span class="font-semibold">“Créer un quiz”</span> pour démarrer.</p>
        </div>
    @else
        {{-- Exemple d’affichage (si $quizzes fourni un jour) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($quizzes as $quiz)
                <div class="rounded-2xl bg-white border border-gray-200 shadow-sm p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $quiz->title }}</h3>
                            <p class="text-sm text-gray-500">
                                Formation : <span class="font-medium">{{ $quiz->formation->title ?? '—' }}</span>
                            </p>
                        </div>
                        <span class="text-xs rounded-full bg-indigo-50 text-indigo-700 px-2 py-1 border border-indigo-200">
                            {{ $quiz->questions_count ?? 0 }} questions
                        </span>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="#"
                           class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-gray-700 hover:bg-gray-50">
                            <i class="fa-solid fa-pen-to-square"></i> Modifier
                        </a>
                        <a href="#"
                           class="inline-flex items-center gap-2 rounded-lg border border-emerald-300 bg-emerald-50 px-3 py-1.5 text-emerald-700 hover:bg-emerald-100">
                            <i class="fa-regular fa-eye"></i> Aperçu
                        </a>
                        <button class="inline-flex items-center gap-2 rounded-lg border border-red-300 bg-red-50 px-3 py-1.5 text-red-700 hover:bg-red-100"
                                onclick="return confirm('Supprimer ce quiz ?')">
                            <i class="fa-solid fa-trash-can"></i> Supprimer
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
