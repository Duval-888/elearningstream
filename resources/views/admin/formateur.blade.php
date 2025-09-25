@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

  {{-- Header --}}
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-2">
      <i class="fa-solid fa-chalkboard-user text-emerald-700"></i>
      <h1 class="text-2xl font-semibold text-emerald-900">Formateurs</h1>
    </div>

    {{-- Dé-commente si tu as une route de création --}}
    {{--
    <a href="{{ route('admin.formateurs.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white">
      <i class="fa-solid fa-user-plus"></i> Nouveau formateur
    </a>
    --}}
  </div>

  {{-- Barre de recherche locale (optionnelle) --}}
  <form action="{{ route('admin.formateurs') }}" method="GET" class="mb-5">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
      <div class="md:col-span-9">
        <div class="relative">
          <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
          <input name="q" value="{{ request('q') }}" placeholder="Rechercher un formateur…"
                 class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-white ring-1 ring-emerald-200 focus:ring-2 focus:ring-emerald-400 outline-none">
        </div>
      </div>
      <div class="md:col-span-3">
        <button class="w-full px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white">Rechercher</button>
      </div>
    </div>
  </form>

  {{-- Tableau --}}
  <div class="overflow-hidden rounded-2xl bg-white ring-1 ring-emerald-100 shadow-sm">
    <div class="overflow-x-auto">
      <table class="min-w-full text-left">
        <thead class="bg-emerald-50 text-slate-600 text-sm">
          <tr>
            <th class="px-5 py-3">Nom</th>
            <th class="px-5 py-3">Email</th>
            <th class="px-5 py-3">Rôle</th>
            <th class="px-5 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-emerald-100">
          @forelse($users as $user)
          <tr class="hover:bg-emerald-50/50">
            <td class="px-5 py-3 font-medium">{{ $user->name }}</td>
            <td class="px-5 py-3">{{ $user->email }}</td>
            <td class="px-5 py-3 capitalize">{{ $user->role }}</td>
            <td class="px-5 py-3">
              <div class="flex justify-end gap-2">
                <a href="{{ route('admin.edit', $user->id) }}"
                   class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm">
                  <i class="fa-solid fa-pen-to-square"></i> Modifier
                </a>
                <form action="{{ route('admin.delete', $user->id) }}" method="POST" class="inline-block">
                  @csrf @method('DELETE')
                  <button type="submit"
                          class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg ring-1 ring-emerald-300 text-emerald-800 hover:bg-emerald-50 text-sm">
                    <i class="fa-solid fa-trash-can"></i> Supprimer
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="px-5 py-6 text-center text-slate-500">Aucun formateur trouvé.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if(method_exists($users,'links'))
      <div class="px-5 py-4">{{ $users->withQueryString()->links() }}</div>
    @endif
  </div>
</div>
@endsection
