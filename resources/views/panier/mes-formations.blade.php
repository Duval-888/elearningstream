<x-layouts.dashboard>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">📘 Mes formations</h2>

        @if($formations->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($formations as $formation)
                    @php
                        $cover = $formation->cover_image
                            ? (\Illuminate\Support\Str::startsWith($formation->cover_image, ['http://','https://'])
                                ? $formation->cover_image
                                : asset('storage/'.$formation->cover_image))
                            : 'https://via.placeholder.com/400x200';
                    @endphp

                    <a href="{{ route('formations.watch', $formation->id) }}"
                       class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 block">
                        <img src="{{ $cover }}" alt="Image de la formation" class="w-full h-40 object-cover">

                        <div class="p-4 flex flex-col h-full">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $formation->title }}</h3>

                            <p class="text-sm text-gray-600 mb-2">
                                📊 <span class="font-medium">Niveau :</span> {{ ucfirst($formation->level) }}<br>
                                ⏱️ <span class="font-medium">Durée :</span> {{ $formation->duration ?? '—' }}h
                            </p>

                            <div class="flex items-center justify-between mt-auto">
                                <p class="text-green-600 font-bold text-lg">
                                    💰 {{ number_format($formation->price, 2, ',', ' ') }} €
                                </p>
                                <span class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-700">
                                    {{ $formation->videos_count ?? $formation->videos()->count() }} vidéo(s)
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center text-gray-500 mt-10">
                Vous n’avez encore ajouté aucune formation à votre panier.
            </div>
        @endif
    </div>
</x-layouts.dashboard>
