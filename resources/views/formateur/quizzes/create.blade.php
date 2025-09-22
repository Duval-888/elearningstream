@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">
            <i class="fa-solid fa-plus text-emerald-600 mr-2"></i>
            Nouveau quiz
        </h1>
        <p class="text-gray-500">Définis un titre et une description. Les questions viendront ensuite.</p>
    </div>

    <form method="POST" action="{{ route('formateur.quizzes.store') }}"
          class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 grid gap-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
            <input type="text" name="title" required
                   class="w-full rounded-xl border-gray-300 focus:ring-emerald-500 focus:border-emerald-500"
                   placeholder="Ex: Quiz Laravel – Fondamentaux">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description (optionnel)</label>
            <textarea name="description" rows="4"
                      class="w-full rounded-xl border-gray-300 focus:ring-emerald-500 focus:border-emerald-500"
                      placeholder="Ce quiz couvre…"></textarea>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">
                <i class="fa-regular fa-floppy-disk"></i> Enregistrer
            </button>
            <a href="{{ route('formateur.quizzes') }}"
               class="inline-flex items-center gap-2 rounded-xl border px-4 py-2 text-gray-700 hover:bg-gray-50">
               Annuler
            </a>
        </div>
    </form>
</div>
@endsection
