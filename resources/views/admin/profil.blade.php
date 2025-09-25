@extends('layouts.dashboard')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

  {{-- Header --}}
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div class="h-11 w-11 grid place-items-center rounded-xl bg-emerald-600 text-white">
        <i class="fa-solid fa-user-shield"></i>
      </div>
      <div>
        <h1 class="text-2xl font-semibold text-emerald-900">Profil Administrateur</h1>
        <p class="text-slate-600 text-sm">Gérez vos informations de compte</p>
      </div>
    </div>
    <a href="{{ route('admin.edit', auth()->id()) }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white">
      <i class="fa-solid fa-pen-to-square"></i> Modifier mon profil
    </a>
  </div>

  {{-- Carte principale --}}
  <div class="rounded-2xl bg-white ring-1 ring-emerald-100 shadow-sm overflow-hidden">
    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
      {{-- Avatar / Rôle --}}
      <div class="md:col-span-1">
        <div class="flex flex-col items-center text-center">
          <div class="h-24 w-24 grid place-items-center rounded-full bg-emerald-100 text-emerald-700 text-3xl">
            <i class="fa-solid fa-user"></i>
          </div>
          <h2 class="mt-3 text-lg font-semibold text-slate-800">{{ $user->name }}</h2>
          <span class="mt-1 inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
            <i class="fa-solid fa-shield-halved"></i> {{ ucfirst($user->role) }}
          </span>
        </div>
      </div>

      {{-- Infos --}}
      <div class="md:col-span-2">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="rounded-xl p-4 ring-1 ring-emerald-200">
            <p class="text-xs text-slate-500">Nom complet</p>
            <p class="mt-1 font-semibold text-slate-800">{{ $user->name }}</p>
          </div>
          <div class="rounded-xl p-4 ring-1 ring-emerald-200">
            <p class="text-xs text-slate-500">Email</p>
            <p class="mt-1 font-semibold text-slate-800">{{ $user->email }}</p>
          </div>
          <div class="rounded-xl p-4 ring-1 ring-emerald-200">
            <p class="text-xs text-slate-500">Créé le</p>
            <p class="mt-1 font-semibold text-slate-800">{{ $user->created_at?->format('d/m/Y H:i') }}</p>
          </div>
          <div class="rounded-xl p-4 ring-1 ring-emerald-200">
            <p class="text-xs text-slate-500">Dernière mise à jour</p>
            <p class="mt-1 font-semibold text-slate-800">{{ $user->updated_at?->format('d/m/Y H:i') }}</p>
          </div>
        </div>

        {{-- Mini stats perso (facultatif) --}}
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="rounded-xl p-4 bg-gradient-to-br from-emerald-600 to-emerald-700 text-white">
            <div class="flex items-center gap-3">
              <i class="fa-solid fa-book-open"></i>
              <div>
                <p class="text-sm text-white/80">Mes cours créés</p>
                <p class="text-2xl font-semibold">{{ $myCourses ?? 0 }}</p>
              </div>
            </div>
          </div>
          <div class="rounded-xl p-4 bg-white ring-1 ring-emerald-200">
            <div class="flex items-center gap-3 text-emerald-800">
              <i class="fa-solid fa-award"></i>
              <div class="text-slate-800">
                <p class="text-sm text-slate-500">Certificats (perso)</p>
                <p class="text-2xl font-semibold">{{ $myCertifs ?? 0 }}</p>
              </div>
            </div>
          </div>
        </div>

        {{-- Actions --}}
        <div class="mt-6 flex flex-wrap gap-3">
          <a href="{{ route('admin.edit', auth()->id()) }}"
             class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white">
            <i class="fa-solid fa-user-pen"></i> Modifier mes infos
          </a>
          @if(Route::has('password.request'))
          <a href="{{ route('password.request') }}"
             class="inline-flex items-center gap-2 px-4 py-2 rounded-xl ring-1 ring-emerald-300 text-emerald-800 hover:bg-emerald-50">
            <i class="fa-solid fa-key"></i> Changer le mot de passe
          </a>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
