{{-- resources/views/dashboard.blade.php --}}
<x-layouts.dashboard>
    @php
        // Sécurise les variables pour éviter "Undefined variable"
        /** @var \Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator $formations */
        $formations = $formations ?? collect();
        $levels = $levels ?? [
            'debutant'      => 'Débutant',
            'intermediaire' => 'Intermédiaire',
            'avance'        => 'Avancé',
        ];

        // Sait-on paginer ?
        $hasPagination = method_exists($formations, 'links');
    @endphp

    <div class="max-w-7xl mx-auto px-4 py-10">
        <h2 class="text-3xl md:text-4xl font-extrabold text-center mb-8">
            <span class="bg-gradient-to-r from-green-600 to-indigo-600 bg-clip-text text-transparent">
                🎓 Explorez nos formations
            </span>
        </h2>

        @if($formations->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($formations as $formation)
                    @php
                        // Image de couverture robuste (URL absolue ou fichier storage)
                        $ci = $formation->cover_image ?? null;
                        $cover = $ci
                            ? (\Illuminate\Support\Str::startsWith($ci, ['http://','https://'])
                                ? $ci
                                : asset('storage/'.$ci))
                            : asset('images/default.jpg');

                        $niveau = $levels[$formation->level] ?? $formation->level;
                        $rating = $formation->rating ?? 4.5;
                        $price  = number_format((float)($formation->price ?? 0), 0, ',', ' ');
                    @endphp

                    <div class="group bg-white rounded-2xl border border-emerald-100 overflow-hidden shadow-md hover:shadow-xl transition">
                        <div class="relative overflow-hidden">
                            <img src="{{ $cover }}" alt="{{ $formation->title }}" class="w-full h-40 object-cover group-hover:scale-105 transition duration-500">
                            @if($formation->is_popular ?? false)
                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-400 text-gray-900 shadow">
                                    Populaire
                                </span>
                            @endif
                        </div>

                        <div class="p-4">
                            <h5 class="text-lg font-bold text-emerald-800 mb-1 line-clamp-2">
                                {{ $formation->title }}
                            </h5>

                            <p class="text-sm text-slate-600">
                                <i class="fa-solid fa-signal text-emerald-500 mr-1"></i>
                                Niveau : <span class="font-medium">{{ $niveau }}</span>
                            </p>

                            <p class="text-sm text-amber-500 mt-1">
                                <i class="fa-solid fa-star mr-1"></i> {{ $rating }}
                            </p>

                            <p class="mt-2 text-lg font-extrabold bg-gradient-to-r from-green-600 to-indigo-600 bg-clip-text text-transparent">
                                FCFA {{ $price }}
                            </p>

                            <form action="{{ route('panier.add') }}" method="POST" class="mt-4">
                                @csrf
                                <input type="hidden" name="formation_id" value="{{ $formation->id }}">
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-white
                                               bg-indigo-600 hover:bg-indigo-700 shadow-md hover:shadow-lg transition font-semibold">
                                    <i class="fa-solid fa-plus"></i> Suivre le cours
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($hasPagination)
                <div class="mt-10 flex justify-center">
                    {{ $formations->links() }}
                </div>
            @endif
        @else
            <div class="text-center text-gray-500 mt-12">
                Aucune formation disponible pour le moment.
            </div>
        @endif
    </div>
</x-layouts.dashboard>
