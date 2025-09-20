<x-layouts.app>
    @php
        $levels = [
            'debutant' => 'Débutant',
            'intermediaire' => 'Intermédiaire',
            'avance' => 'Avancé'
        ];
    @endphp

    <h2 class="text-3xl font-bold mb-8 text-center text-indigo-400">
        🎓 Explorez nos formations
    </h2>

    @if($formations->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($formations as $formation)
                <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    <img src="{{ $formation->cover_image ?? '/images/default.jpg' }}" alt="{{ $formation->title }}" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h5 class="text-lg font-semibold mb-2">{{ $formation->title }}</h5>
                        <p class="text-sm text-gray-300 mb-1">
                            Niveau : {{ $levels[$formation->level] ?? $formation->level }}
                        </p>
                        <p class="text-yellow-400 text-sm mb-1">★ {{ $formation->rating ?? '4.5' }}</p>
                        <p class="font-bold text-white">FCFA {{ number_format($formation->price, 0, ',', ' ') }}</p>

                        @if($formation->is_popular ?? false)
                            <span class="inline-block mt-2 px-2 py-1 text-xs bg-yellow-400 text-gray-900 rounded">Populaire</span>
                        @endif

                        <form action="{{ route('panier.add') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="formation_id" value="{{ $formation->id }}">
                            <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded">
                                Suivre le cours
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10 flex justify-center">
            {{ $formations->links() }}
        </div>
    @else
        <div class="text-center text-gray-400 mt-10">
            Aucune formation disponible pour le moment.
        </div>
    @endif
</x-layouts.app>
