@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Créer un cours</h1>

    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 text-rose-800 px-4 py-3">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i> Corrige les erreurs ci-dessous.
        </div>
    @endif

    <form method="POST" action="{{ route('courses.store') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500" required>
            @error('title') <p class="text-sm text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="4"
                      class="w-full rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">{{ old('description') }}</textarea>
            @error('description') <p class="text-sm text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
            <select name="category"
                    class="w-full rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500" required>
                <option value="" disabled {{ old('category') ? '' : 'selected' }}>— Choisir —</option>
                <option value="programmation" {{ old('category')==='programmation' ? 'selected' : '' }}>Programmation</option>
                <option value="design"        {{ old('category')==='design' ? 'selected' : '' }}>Design</option>
                <option value="marketing"     {{ old('category')==='marketing' ? 'selected' : '' }}>Marketing</option>
                <option value="business"      {{ old('category')==='business' ? 'selected' : '' }}>Business</option>
                <option value="autre"         {{ old('category')==='autre' ? 'selected' : '' }}>Autre</option>
            </select>
            @error('category') <p class="text-sm text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('courses.index') }}" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700">
                Annuler
            </a>
            <button class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white">
                <i class="fa-regular fa-floppy-disk mr-2"></i>Créer le cours
            </button>
        </div>
    </form>
</div>
@endsection
