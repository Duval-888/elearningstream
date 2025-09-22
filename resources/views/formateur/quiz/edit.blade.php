@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 space-y-8">
    {{-- header --}}
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
        <div class="p-6 md:p-8 bg-gradient-to-r from-sky-600 to-emerald-500 text-white">
            <h1 class="text-2xl md:text-3xl font-bold"><i class="fa-solid fa-pen-to-square mr-2"></i>Éditer : {{ $quiz->title }}</h1>
            <p class="text-white/90">ID #{{ $quiz->id }}</p>
        </div>

        <form action="{{ route('formateur.quizzes.update', $quiz) }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                    <input type="text" name="title" value="{{ old('title', $quiz->title) }}" required
                           class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div class="flex items-center gap-2 mt-7 md:mt-0">
                    <input type="checkbox" name="is_published" id="is_published" value="1"
                           @checked($quiz->is_published)
                           class="rounded text-emerald-600">
                    <label for="is_published" class="text-sm text-gray-700">Publié</label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4"
                          class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">{{ old('description', $quiz->description) }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('formateur.quiz') }}" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700">Retour</a>
                <button class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>Enregistrer
                </button>
            </div>
        </form>
    </div>

    {{-- Questions --}}
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-regular fa-circle-question text-emerald-600"></i>
                <h2 class="font-semibold text-gray-900">Questions ({{ $quiz->questions->count() }})</h2>
            </div>
        </div>

        <div class="p-6 space-y-6">
            {{-- liste des questions --}}
            @forelse($quiz->questions as $q)
                <div class="rounded-xl border border-gray-200 p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Ordre : {{ $q->ordre }} • Points : {{ $q->points }}</p>
                            <p class="font-medium text-gray-900 mt-1">{{ $q->prompt }}</p>
                            <p class="text-xs text-gray-500 mt-1">Type : {{ strtoupper($q->type) }}</p>
                            @if(in_array($q->type, ['single','multiple']) && $q->options)
                                <ul class="mt-2 text-sm list-disc ml-5 text-gray-700">
                                    @foreach($q->options as $opt)
                                        <li>{{ $opt }}</li>
                                    @endforeach
                                </ul>
                                <p class="text-xs text-emerald-700 mt-1">Bonne réponse : {{ $q->correct_answer }}</p>
                            @elseif($q->type === 'text')
                                <p class="text-xs text-emerald-700 mt-1">Réponse attendue : {{ $q->correct_answer ?? '—' }}</p>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            {{-- bouton modifier (accordéon inline) --}}
                            <button type="button"
                                    onclick="document.getElementById('edit-{{ $q->id }}').classList.toggle('hidden')"
                                    class="px-3 py-1.5 rounded-lg bg-sky-600 hover:bg-sky-700 text-white text-sm">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('formateur.questions.destroy', $q) }}" method="POST" onsubmit="return confirm('Supprimer cette question ?')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Édition inline --}}
                    <div id="edit-{{ $q->id }}" class="hidden mt-4">
                        <form action="{{ route('formateur.questions.update', $q) }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @csrf @method('PUT')
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Énoncé</label>
                                <input name="prompt" value="{{ $q->prompt }}" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                <select name="type" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="single" @selected($q->type==='single')>Choix unique</option>
                                    <option value="multiple" @selected($q->type==='multiple')>Choix multiples</option>
                                    <option value="text" @selected($q->type==='text')>Réponse libre</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Points</label>
                                <input type="number" name="points" value="{{ $q->points }}" min="1" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ordre</label>
                                <input type="number" name="ordre" value="{{ $q->ordre }}" min="1" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Options (sépare par “|”)</label>
                                <input name="options" value="{{ $q->options ? implode('|',$q->options) : '' }}" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="ex: Rouge|Vert|Bleu">
                                <p class="text-xs text-gray-500 mt-1">Laisse vide pour une réponse libre.</p>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Bonne réponse</label>
                                <input name="correct_answer" value="{{ $q->correct_answer }}" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div class="md:col-span-3 flex items-center justify-end">
                                <button class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white">
                                    <i class="fa-solid fa-floppy-disk mr-1"></i> Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rounded-xl border border-dashed border-gray-300 p-8 text-center text-gray-600">
                    Aucune question pour l’instant.
                </div>
            @endforelse
        </div>

        {{-- Ajouter une question --}}
        <div class="px-6 pb-8">
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                <h3 class="font-semibold text-emerald-900 mb-3"><i class="fa-solid fa-plus mr-2"></i>Ajouter une question</h3>
                <form action="{{ route('formateur.questions.store', $quiz) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Énoncé</label>
                        <input name="prompt" required class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select name="type" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="single">Choix unique</option>
                            <option value="multiple">Choix multiples</option>
                            <option value="text">Réponse libre</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Points</label>
                        <input type="number" name="points" value="1" min="1" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Options (sépare par “|”)</label>
                        <input name="options" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="ex: Rouge|Vert|Bleu">
                        <p class="text-xs text-gray-500 mt-1">Remplis pour QCM. Laisse vide pour réponse libre.</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bonne réponse</label>
                        <input name="correct_answer" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div class="md:col-span-2 flex items-center justify-end">
                        <button class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white">
                            <i class="fa-solid fa-plus mr-1"></i> Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
