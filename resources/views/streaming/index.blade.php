@extends('layouts.dashboard')

@section('content')
@php
    // On accepte $liveSessions ou $sessions si le contrôleur en envoie, sinon vide
    $items = ($liveSessions ?? $sessions ?? collect());
@endphp

<div class="max-w-7xl mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div class="flex items-start gap-3">
            <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100">
                <i class="fa-solid fa-video text-emerald-600 text-xl"></i>
            </span>
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900">Streaming en direct</h1>
                <p class="text-sm text-gray-500">Crée, démarre ou rejoins tes sessions live.</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            {{-- Lien vers l’index des sessions live (existe déjà dans tes routes) --}}
            <a href="{{ route('live-sessions.index') }}"
               class="inline-flex items-center gap-2 rounded-xl border px-4 py-2 text-gray-700 hover:bg-gray-50">
                <i class="fa-regular fa-calendar"></i> Mes sessions
            </a>
            {{-- Lien vers la création d’une session (existe déjà) --}}
            <a href="{{ route('live-sessions.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">
                <i class="fa-solid fa-calendar-plus"></i> Créer une session
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        {{-- Colonne gauche : “Mes sessions” --}}
        <aside class="lg:col-span-1">
            <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="mb-3 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Mes sessions</h2>
                    <a href="{{ route('live-sessions.index') }}" class="text-xs text-indigo-600 hover:text-indigo-700">
                        Voir tout
                    </a>
                </div>

                @if($items->count())
                    <ul class="space-y-2">
                        @foreach($items as $s)
                            <li class="rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/50 transition">
                                <a href="{{ route('live-sessions.show', $s->id) }}" class="block p-3">
                                    <div class="flex items-start gap-2">
                                        <i class="fa-solid fa-video mt-0.5 text-emerald-600"></i>
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-medium text-gray-900">
                                                {{ $s->title ?? 'Session sans titre' }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ \Illuminate\Support\Str::limit($s->description ?? '—', 60) }}
                                            </p>
                                            @if(!empty($s->scheduled_at))
                                                <p class="mt-1 text-xs text-gray-400">
                                                    <i class="fa-regular fa-clock mr-1"></i>
                                                    {{ \Carbon\Carbon::parse($s->scheduled_at)->format('d/m/Y H:i') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    @if(method_exists($items, 'links'))
                        <div class="mt-3">{{ $items->links() }}</div>
                    @endif
                @else
                    <div class="rounded-xl border-2 border-dashed border-gray-200 p-6 text-center">
                        <p class="text-sm text-gray-600">Aucune session pour le moment.</p>
                        <a href="{{ route('live-sessions.create') }}"
                           class="mt-3 inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-3 py-2 text-white text-sm hover:bg-emerald-700">
                            <i class="fa-solid fa-plus"></i> Programmer une session
                        </a>
                    </div>
                @endif
            </div>
        </aside>

        {{-- Panneau principal : style “Zoom” --}}
        <main class="lg:col-span-3 space-y-6">
            {{-- Carte “Salle de streaming” --}}
            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900">
                        <i class="fa-solid fa-chalkboard-user mr-2 text-indigo-600"></i>
                        Salle de streaming
                    </h3>
                    <span class="inline-flex items-center gap-2 text-xs rounded-full bg-gray-100 px-3 py-1 text-gray-600">
                        <span class="inline-block h-2 w-2 rounded-full bg-gray-400"></span>
                        Hors ligne
                    </span>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Bloc rejoindre par ID --}}
                    <div class="rounded-xl border border-gray-100 p-5">
                        <h4 class="font-semibold text-gray-900 mb-2">
                            <i class="fa-solid fa-right-to-bracket mr-2 text-emerald-600"></i>
                            Rejoindre une session
                        </h4>
                        <p class="text-sm text-gray-500 mb-4">
                            Entre l’ID de la session pour la rejoindre immédiatement.
                        </p>
                        <form onsubmit="event.preventDefault(); const v=document.getElementById('join-id').value.trim(); if(v){ window.location.href='/live-sessions/'+encodeURIComponent(v)+'/join'; }">
                            <div class="flex gap-2">
                                <input id="join-id" type="text" placeholder="ID de session"
                                       class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                                <button class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-3 py-2 text-white hover:bg-emerald-700">
                                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                    Rejoindre
                                </button>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Exemple d’URL générée : <code>/live-sessions/{id}/join</code></p>
                        </form>
                    </div>

                    {{-- Bloc créer / démarrer --}}
                    <div class="rounded-xl border border-gray-100 p-5">
                        <h4 class="font-semibold text-gray-900 mb-2">
                            <i class="fa-solid fa-bolt mr-2 text-sky-600"></i>
                            Démarrer rapidement
                        </h4>
                        <p class="text-sm text-gray-500 mb-4">
                            Programme une nouvelle session ou ouvre une session existante.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('live-sessions.create') }}"
                               class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-3 py-2 text-white hover:bg-sky-700">
                                <i class="fa-solid fa-calendar-plus"></i>
                                Programmer
                            </a>
                            <a href="{{ route('live-sessions.index') }}"
                               class="inline-flex items-center gap-2 rounded-lg border px-3 py-2 text-gray-700 hover:bg-gray-50">
                                <i class="fa-regular fa-folder-open"></i>
                                Ouvrir une session
                            </a>
                        </div>
                    </div>
                </div>

                {{-- “Prévisualisation” caméra (factice) --}}
                <div class="px-6 pb-6">
                    <div class="rounded-xl bg-black aspect-video relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <i class="fa-solid fa-video-slash text-white/60 text-4xl"></i>
                                <p class="mt-2 text-white/70 text-sm">Caméra non initialisée (démo)</p>
                            </div>
                        </div>

                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent p-3">
                            <div class="flex items-center justify-center gap-3">
                                <button class="h-10 w-10 rounded-full bg-white/10 hover:bg-white/20 text-white">
                                    <i class="fa-solid fa-microphone-lines"></i>
                                </button>
                                <button class="h-10 w-10 rounded-full bg-white/10 hover:bg-white/20 text-white">
                                    <i class="fa-solid fa-video"></i>
                                </button>
                                <button class="h-10 w-10 rounded-full bg-white/10 hover:bg-white/20 text-white">
                                    <i class="fa-solid fa-gear"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 text-center">
                        Astuce : démarre une vraie session depuis <b>Programmer</b>, puis utilise les pages
                        <code class="bg-gray-100 px-1 rounded">/live-sessions/{id}/start</code> ou
                        <code class="bg-gray-100 px-1 rounded">/live-sessions/{id}/room</code> si elles existent côté back.
                    </p>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
