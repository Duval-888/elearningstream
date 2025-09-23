@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    @if(session('success'))
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
        <div class="p-6 md:p-8 bg-gradient-to-r from-emerald-600 to-sky-500 text-white">
            <h1 class="text-2xl md:text-3xl font-bold">
                <i class="fa-solid fa-book-open mr-2"></i>{{ $course->title }}
            </h1>
            <p class="mt-1 text-white/90 text-sm">
                Catégorie : <span class="font-semibold">{{ $course->category }}</span>
            </p>
        </div>

        <div class="p-6 md:p-8 space-y-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Description</h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ $course->description ?: 'Aucune description fournie.' }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="rounded-xl border border-gray-200 p-4">
                    <div class="text-gray-500 text-sm">Instructeur</div>
                    <div class="mt-1 font-medium text-gray-900">
                        {{ optional($course->instructor)->name ?? '—' }}
                    </div>
                </div>
                <div class="rounded-xl border border-gray-200 p-4">
                    <div class="text-gray-500 text-sm">Slug</div>
                    <div class="mt-1 font-mono text-gray-900">{{ $course->slug }}</div>
                </div>
            </div>

            <div class="pt-4 flex items-center gap-3">
                <a href="{{ route('courses.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2">
                    <i class="fa-solid fa-angles-left text-sm"></i> Retour
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
