@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

  {{-- ✅ Message de bienvenue dynamique --}}
  <div class="flex items-center justify-center gap-3 mb-2 rounded-2xl bg-emerald-50 ring-1 ring-emerald-200 text-emerald-800 px-5 py-4 shadow-sm">
    <div class="h-9 w-9 grid place-items-center rounded-xl bg-emerald-600 text-white">
      <i class="fa-solid fa-user-shield"></i>
    </div>
    <p class="font-medium">
      Bonjour {{ auth()->user()->name }} 👋, bienvenue dans votre espace <strong>Administrateur</strong> !
    </p>
  </div>
  <p class="text-center text-slate-600 mb-6">
    Vous avez accès à toutes les fonctionnalités de gestion de la plateforme.
  </p>

  {{-- 🔍 Barre de recherche avec filtre --}}
  <form action="{{ route('search.global') }}" method="GET" class="mb-8">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
      <div class="md:col-span-6">
        <div class="relative">
          <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
          <input type="text" name="query" placeholder="Rechercher…"
                 class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-white ring-1 ring-emerald-200 focus:ring-2 focus:ring-emerald-400 outline-none placeholder:text-slate-400 shadow-sm">
        </div>
      </div>
      <div class="md:col-span-3">
        <select name="type"
                class="w-full px-3 py-2.5 rounded-xl bg-white ring-1 ring-emerald-200 focus:ring-2 focus:ring-emerald-400 outline-none shadow-sm">
          <option value="">Tous les types</option>
          <option value="utilisateur">Utilisateurs</option>
          <option value="cours">Cours</option>
          <option value="session">Sessions live</option>
          <option value="certificat">Certificats</option>
        </select>
      </div>
      <div class="md:col-span-3">
        <button class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white shadow transition"
                type="submit">
          <i class="fa-solid fa-search"></i> Rechercher
        </button>
      </div>
    </div>
  </form>

  {{-- 📊 Cartes KPI --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">
    <div class="rounded-2xl p-5 bg-white ring-1 ring-emerald-100 shadow-sm hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-500">Utilisateurs</p>
          <p class="mt-1 text-3xl font-semibold">{{ $stats['total_users'] }}</p>
        </div>
        <div class="h-12 w-12 grid place-items-center rounded-xl bg-emerald-100 text-emerald-700">
          <i class="fa-solid fa-users"></i>
        </div>
      </div>
      <a href="{{ route('admin.apprenants') }}" class="mt-4 inline-flex items-center gap-2 text-sm px-3 py-1.5 rounded-lg ring-1 ring-emerald-300 text-emerald-800 hover:bg-emerald-50">
        <i class="fa-solid fa-gear"></i> Gérer
      </a>
    </div>

    <div class="rounded-2xl p-5 bg-white ring-1 ring-emerald-100 shadow-sm hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-500">Cours publiés</p>
          <p class="mt-1 text-3xl font-semibold">7</p>
        </div>
        <div class="h-12 w-12 grid place-items-center rounded-xl bg-emerald-100 text-emerald-700">
          <i class="fa-solid fa-book-open"></i>
        </div>
      </div>
      <a href="{{ route('courses.index') }}" class="mt-4 inline-flex items-center gap-2 text-sm px-3 py-1.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
        <i class="fa-solid fa-eye"></i> Voir
      </a>
    </div>

    <div class="rounded-2xl p-5 bg-white ring-1 ring-emerald-100 shadow-sm hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-slate-500">Sessions live</p>
          <p class="mt-1 text-3xl font-semibold">{{ $stats['live_sessions'] }}</p>
        </div>
        <div class="h-12 w-12 grid place-items-center rounded-xl bg-emerald-100 text-emerald-700">
          <i class="fa-solid fa-video"></i>
        </div>
      </div>
      <a href="#sessions" class="mt-4 inline-flex items-center gap-2 text-sm px-3 py-1.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
        <i class="fa-solid fa-arrow-up-right-from-square"></i> Consulter
      </a>
    </div>
  </div>

  {{-- 🔁 Remplacement de "Gestion des utilisateurs" --}}
  <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- Raccourcis Admin --}}
    <div class="xl:col-span-2 rounded-2xl bg-white ring-1 ring-emerald-100 shadow-sm overflow-hidden">
      <div class="flex items-center justify-between px-5 py-4 border-b border-emerald-100">
        <div class="flex items-center gap-2">
          <i class="fa-solid fa-bolt text-emerald-700"></i>
          <h3 class="font-semibold text-slate-800">Raccourcis Admin</h3>
        </div>
      </div>

      <div class="p-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="{{ route('admin.apprenants') }}" class="group rounded-xl p-4 ring-1 ring-emerald-200 hover:bg-emerald-50 flex items-start gap-4 transition">
          <div class="h-10 w-10 grid place-items-center rounded-lg bg-emerald-100 text-emerald-700">
            <i class="fa-solid fa-user-graduate"></i>
          </div>
          <div>
            <p class="font-semibold text-slate-800">Apprenants</p>
            <p class="text-sm text-slate-500">Consulter et gérer les apprenants</p>
          </div>
        </a>

        <a href="{{ route('admin.formateurs') }}" class="group rounded-xl p-4 ring-1 ring-emerald-200 hover:bg-emerald-50 flex items-start gap-4 transition">
          <div class="h-10 w-10 grid place-items-center rounded-lg bg-emerald-100 text-emerald-700">
            <i class="fa-solid fa-chalkboard-user"></i>
          </div>
          <div>
            <p class="font-semibold text-slate-800">Formateurs</p>
            <p class="text-sm text-slate-500">Consulter et gérer les formateurs</p>
          </div>
        </a>

        <a href="{{ route('courses.index') }}" class="group rounded-xl p-4 ring-1 ring-emerald-200 hover:bg-emerald-50 flex items-start gap-4 transition">
          <div class="h-10 w-10 grid place-items-center rounded-lg bg-emerald-100 text-emerald-700">
            <i class="fa-solid fa-book-open"></i>
          </div>
          <div>
            <p class="font-semibold text-slate-800">Formations</p>
            <p class="text-sm text-slate-500">Voir toutes les formations</p>
          </div>
        </a>

        <a href="#export" class="group rounded-xl p-4 ring-1 ring-emerald-200 hover:bg-emerald-50 flex items-start gap-4 transition">
          <div class="h-10 w-10 grid place-items-center rounded-lg bg-emerald-100 text-emerald-700">
            <i class="fa-solid fa-file-arrow-down"></i>
          </div>
          <div>
            <p class="font-semibold text-slate-800">Export</p>
            <p class="text-sm text-slate-500">Exporter des données (CSV/Excel)</p>
          </div>
        </a>

        <a href="#messages" class="group rounded-xl p-4 ring-1 ring-emerald-200 hover:bg-emerald-50 flex items-start gap-4 transition">
          <div class="h-10 w-10 grid place-items-center rounded-lg bg-emerald-100 text-emerald-700">
            <i class="fa-solid fa-envelope"></i>
          </div>
          <div>
            <p class="font-semibold text-slate-800">Messages</p>
            <p class="text-sm text-slate-500">Notifier les utilisateurs</p>
          </div>
        </a>

        <a href="#settings" class="group rounded-xl p-4 ring-1 ring-emerald-200 hover:bg-emerald-50 flex items-start gap-4 transition">
          <div class="h-10 w-10 grid place-items-center rounded-lg bg-emerald-100 text-emerald-700">
            <i class="fa-solid fa-gear"></i>
          </div>
          <div>
            <p class="font-semibold text-slate-800">Paramètres</p>
            <p class="text-sm text-slate-500">Configurer la plateforme</p>
          </div>
        </a>
      </div>
    </div>

    {{-- Carte d’infos / Astuce --}}
    <div class="space-y-6">
      <div class="rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-700 text-white shadow-md">
        <div class="p-5 flex items-start gap-4">
          <div class="h-11 w-11 grid place-items-center rounded-xl bg-white/15">
            <i class="fa-solid fa-circle-info"></i>
          </div>
          <div>
            <h3 class="font-semibold">Astuce</h3>
            <p class="text-white/90 mt-1 text-sm">
              Utilisez la barre de recherche globale pour retrouver rapidement un cours, une session live
              ou un utilisateur. Appuyez sur <span class="font-semibold">/</span> pour y accéder plus vite.
            </p>
          </div>
        </div>
      </div>

      <div class="rounded-2xl bg-white ring-1 ring-emerald-100 shadow-sm">
        <div class="px-5 py-4 border-b border-emerald-100 flex items-center gap-2">
          <i class="fa-solid fa-chart-line text-emerald-700"></i>
          <h3 class="font-semibold text-slate-800">Aperçu rapide</h3>
        </div>
        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="rounded-xl p-4 ring-1 ring-emerald-200">
            <p class="text-sm text-slate-500">Cours publiés</p>
            <p class="mt-1 text-2xl font-semibold text-emerald-800">7</p>
          </div>
          <div class="rounded-xl p-4 ring-1 ring-emerald-200">
            <p class="text-sm text-slate-500">Sessions live</p>
            <p class="mt-1 text-2xl font-semibold text-emerald-800">{{ $stats['live_sessions'] }}</p>
          </div>
        </div>
        <div class="px-5 pb-5">
          <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white">
            <i class="fa-solid fa-arrow-right"></i> Voir les détails
          </a>
        </div>
      </div>
    </div>

  </div> {{-- /grid remplacement --}}

</div>
@endsection
