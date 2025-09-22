@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-300 bg-emerald-50 px-4 py-3 text-emerald-700">
            <i class="fa-regular fa-circle-check mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="flex items-start justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">
                <i class="fa-solid fa-list-check text-emerald-600 mr-2"></i>
                Mes quizzes
            </h1>
            <p class="text-gray-500">Crée et organise tes évaluations.</p>
        </div>
        <a href="{{ route('formateur.quizzes.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">
            <i class="fa-solid fa-plus"></i> Nouveau quiz
        </a>
    </div>

    @php $quizzes = $quizzes ?? []; @endphp

    @if(empty($quizzes))
        <div class="rounded-2xl border border-dashed border-emerald-300 bg-white p-10 text-center">
            <div class="mx-auto mb-4 inline-flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50 border border-emerald-200">
                <i class="fa-solid fa-list-check text-emerald-600 text-2xl"></i>
            </div>
            <h2 class="text-xl font-semibold text-gray-800">Aucun quiz pour le moment</h2>
            <p class="text-gray-500 mt-1">Crée ton premier quiz pour évaluer tes apprenants.</p>
            <a href="{{ route('formateur.quizzes.create') }}"
               class="mt-4 inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">
                <i class="fa-solid fa-plus"></i> Créer un quiz
            </a>
        </div>
    @else
        {{-- Exemple de liste si tu fournis un tableau --}}
        <div class="grid md:grid-cols-2 gap-4">
            @foreach($quizzes as $q)
                <div class="rounded-2xl border bg-white p-5">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900">{{ $q['title'] ?? 'Quiz' }}</h3>
                        <span class="text-sm text-gray-500">{{ $q['questions'] ?? 0 }} question(s)</span>
                    </div>
                    <p class="text-gray-600 mt-2 line-clamp-2">{{ $q['description'] ?? '' }}</p>
                    <div class="mt-4 flex items-center gap-2">
                        <button class="rounded-xl border px-3 py-1.5 text-gray-700 hover:bg-gray-50">
                            <i class="fa-regular fa-pen-to-square mr-1"></i> Modifier
                        </button>
                        <button class="rounded-xl border px-3 py-1.5 text-red-700 border-red-300 hover:bg-red-50">
                            <i class="fa-regular fa-trash-can mr-1"></i> Supprimer
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
