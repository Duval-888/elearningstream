@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex items-start justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">
                <i class="fa-regular fa-bell text-emerald-600 mr-2"></i>
                Mes notifications
            </h1>
            <p class="text-gray-500">Toutes vos alertes, messages et mises à jour récentes.</p>
        </div>

        {{-- Actions globales (non bloquantes) --}}
        <div class="flex items-center gap-2">
            {{-- Lien “Marquer tout comme lu” — laisse tel quel si tu n’as pas encore de route côté back --}}
            <button type="button"
                    class="inline-flex items-center gap-2 rounded-xl border border-emerald-300 bg-emerald-50 px-3 py-2 text-emerald-700 hover:bg-emerald-100">
                <i class="fa-regular fa-circle-check"></i>
                Marquer tout comme lu
            </button>
        </div>
    </div>

    {{-- Filtres (liens GET inoffensifs) --}}
    <div class="mb-5 flex flex-wrap items-center gap-2 text-sm">
        @php $filter = request('filter'); @endphp
        <a href="{{ route('notifications.index') }}"
           class="px-3 py-1.5 rounded-full border {{ !$filter ? 'bg-emerald-600 border-emerald-600 text-white' : 'border-gray-300 text-gray-700 hover:bg-gray-50' }}">
            Toutes
        </a>
        <a href="{{ route('notifications.index', ['filter' => 'unread']) }}"
           class="px-3 py-1.5 rounded-full border {{ $filter === 'unread' ? 'bg-emerald-600 border-emerald-600 text-white' : 'border-gray-300 text-gray-700 hover:bg-gray-50' }}">
            Non lues
        </a>
        <a href="{{ route('notifications.index', ['filter' => 'course']) }}"
           class="px-3 py-1.5 rounded-full border {{ $filter === 'course' ? 'bg-emerald-600 border-emerald-600 text-white' : 'border-gray-300 text-gray-700 hover:bg-gray-50' }}">
            Cours
        </a>
        <a href="{{ route('notifications.index', ['filter' => 'comment']) }}"
           class="px-3 py-1.5 rounded-full border {{ $filter === 'comment' ? 'bg-emerald-600 border-emerald-600 text-white' : 'border-gray-300 text-gray-700 hover:bg-gray-50' }}">
            Commentaires
        </a>
        <a href="{{ route('notifications.index', ['filter' => 'system']) }}"
           class="px-3 py-1.5 rounded-full border {{ $filter === 'system' ? 'bg-emerald-600 border-emerald-600 text-white' : 'border-gray-300 text-gray-700 hover:bg-gray-50' }}">
            Système
        </a>
    </div>

    {{-- Liste --}}
    @php
        /** @var \Illuminate\Support\Collection|array $notifications */
        $items = $notifications ?? collect();
    @endphp

    @if($items instanceof \Illuminate\Support\Collection ? $items->isEmpty() : empty($items))
        {{-- Empty state élégant --}}
        <div class="rounded-2xl bg-white border border-dashed border-emerald-300 p-10 text-center">
            <div class="mx-auto mb-4 inline-flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50 border border-emerald-200">
                <i class="fa-regular fa-bell text-emerald-600 text-2xl"></i>
            </div>
            <h2 class="text-xl font-semibold text-gray-800">Aucune notification</h2>
            <p class="text-gray-500 mt-1">Vous serez notifié ici lorsqu’il y aura du nouveau.</p>
        </div>
    @else
        <ul class="space-y-3">
            @foreach($items as $n)
                @php
                    $type    = $n->type ?? data_get($n, 'data.type', 'system');
                    $isRead  = (bool) ($n->read_at ?? $n->is_read ?? false);
                    $url     = $n->url ?? data_get($n, 'data.url');
                    $title   = $n->title ?? data_get($n, 'data.title', 'Notification');
                    $message = $n->message ?? data_get($n, 'data.message', '');
                    $time    = optional($n->created_at)->diffForHumans() ?? '';

                    $map = [
                        'course'   => ['icon' => 'fa-solid fa-book-open',      'chip' => 'bg-indigo-50 text-indigo-700 border-indigo-200'],
                        'comment'  => ['icon' => 'fa-regular fa-comment-dots', 'chip' => 'bg-amber-50 text-amber-700 border-amber-200'],
                        'system'   => ['icon' => 'fa-regular fa-bell',         'chip' => 'bg-gray-50 text-gray-700 border-gray-200'],
                        'live'     => ['icon' => 'fa-solid fa-tower-broadcast','chip' => 'bg-rose-50 text-rose-700 border-rose-200'],
                    ];
                    $icon = $map[$type]['icon'] ?? 'fa-regular fa-bell';
                    $chip = $map[$type]['chip'] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                @endphp

                <li class="rounded-2xl border p-4 md:p-5 {{ $isRead ? 'bg-white border-gray-200' : 'bg-emerald-50 border-emerald-200' }}">
                    <div class="flex items-start gap-4">
                        <div class="mt-1">
                            <div class="h-10 w-10 rounded-full bg-white border flex items-center justify-center {{ $isRead ? 'border-gray-200' : 'border-emerald-300' }}">
                                <i class="{{ $icon }} {{ $isRead ? 'text-gray-500' : 'text-emerald-600' }}"></i>
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="font-semibold text-gray-900">{{ $title }}</h3>
                                <span class="text-xs border rounded-full px-2 py-0.5 {{ $chip }}">
                                    {{ ucfirst($type) }}
                                </span>

                                @unless($isRead)
                                    <span class="ml-1 text-xs rounded-full bg-emerald-600 text-white px-2 py-0.5">
                                        Nouveau
                                    </span>
                                @endunless
                            </div>

                            @if($message)
                                <p class="text-sm text-gray-600 mt-1">{{ $message }}</p>
                            @endif

                            <div class="mt-3 flex items-center gap-3 text-sm">
                                <span class="text-gray-400">
                                    <i class="fa-regular fa-clock mr-1"></i>{{ $time }}
                                </span>

                                @if($url)
                                    <a href="{{ $url }}"
                                       class="inline-flex items-center gap-1 text-emerald-700 hover:text-emerald-800">
                                        Voir <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Actions locales (visuelles uniquement) --}}
                        <div class="flex flex-col items-end gap-2">
                            <button type="button"
                                    class="inline-flex items-center gap-1 text-xs rounded-lg border px-2 py-1 {{ $isRead ? 'text-gray-600 border-gray-300 hover:bg-gray-50' : 'text-emerald-700 border-emerald-300 hover:bg-emerald-100' }}">
                                <i class="fa-regular fa-circle-check"></i>
                                {{ $isRead ? 'Lu' : 'Marquer lu' }}
                            </button>
                            <button type="button"
                                    class="inline-flex items-center gap-1 text-xs rounded-lg border px-2 py-1 text-red-700 border-red-300 hover:bg-red-50">
                                <i class="fa-regular fa-trash-can"></i> Supprimer
                            </button>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
