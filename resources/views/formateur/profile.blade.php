@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-300 bg-emerald-50 px-4 py-3 text-emerald-700">
            <i class="fa-regular fa-circle-check mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">
            <i class="fa-regular fa-user text-emerald-600 mr-2"></i>
            Mon profil
        </h1>
        <p class="text-gray-500">Gère ton identité formateur.</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
        <div class="p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="h-16 w-16 rounded-full bg-emerald-100 border border-emerald-200 flex items-center justify-center">
                    <i class="fa-regular fa-user text-emerald-700 text-2xl"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900">
                        {{ $user->name ?? 'Formateur' }}
                    </div>
                    <div class="text-gray-500 text-sm">
                        {{ $user->email ?? 'email@exemple.com' }}
                    </div>
                </div>
            </div>

           <form method="POST" action="{{ route('formateur.profile.update') }}" class="grid grid-cols-1 gap-5">
    @csrf
    @method('PUT') {{-- <== important : la route attend PUT --}}

    {{-- erreurs de validation (optionnel mais pratique) --}}
    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
        <input
            type="text"
            name="name"
            value="{{ old('name', $user->name ?? '') }}"
            class="w-full rounded-xl border-gray-300 focus:ring-emerald-500 focus:border-emerald-500"
            placeholder="Votre nom"
            required
        >
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
        <textarea
            name="bio"
            rows="4"
            class="w-full rounded-xl border-gray-300 focus:ring-emerald-500 focus:border-emerald-500"
            placeholder="Quelques mots sur vous…"
        >{{ old('bio', $user->bio ?? '') }}</textarea>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">
            <i class="fa-regular fa-floppy-disk"></i> Enregistrer
        </button>
        <a href="{{ route('dashboard.formateur') }}"
           class="inline-flex items-center gap-2 rounded-xl border px-4 py-2 text-gray-700 hover:bg-gray-50">
            <i class="fa-solid fa-angles-left text-sm"></i> Retour
        </a>
    </div>
</form>


        </div>
    </div>
</div>
@endsection
