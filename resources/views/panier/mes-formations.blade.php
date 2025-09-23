<x-layouts.dashboard>
    <div class="max-w-7xl mx-auto px-4 py-10 space-y-10">

        {{-- 🎓 HERO --}}
        <div class="relative overflow-hidden rounded-3xl shadow-2xl ring-1 ring-green-400/30
                    bg-gradient-to-r from-green-700 via-emerald-600 to-sky-600 text-white p-10 text-center">
            <div class="absolute -top-16 -left-20 w-72 h-72 bg-white/10 blur-3xl rounded-full"></div>
            <div class="absolute -bottom-16 -right-20 w-80 h-80 bg-white/10 blur-3xl rounded-full"></div>

            <h2 class="relative text-3xl md:text-4xl font-extrabold flex items-center justify-center gap-3">
                <i class="fa-solid fa-book-open"></i> Mes Formations
            </h2>
            <p class="relative mt-3 text-white/90 max-w-2xl mx-auto">
                Explorez vos cours, progressez à votre rythme et devenez un expert 💡
            </p>
        </div>

        {{-- 📚 LISTE DES FORMATIONS --}}
        @if($formations->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($formations as $formation)
                    @php
                        $cover = $formation->cover_image
                            ? (\Illuminate\Support\Str::startsWith($formation->cover_image, ['http://','https://'])
                                ? $formation->cover_image
                                : asset('storage/'.$formation->cover_image))
                            : 'https://via.placeholder.com/400x200';
                    @endphp

                    <a href="{{ route('formations.watch', $formation->id) }}"
                       class="group relative rounded-2xl overflow-hidden shadow-lg bg-white/90 backdrop-blur
                              border border-emerald-200/60 hover:shadow-2xl transition duration-300 flex flex-col">
                        {{-- Image --}}
                        <div class="relative overflow-hidden">
                            <img src="{{ $cover }}" alt="Image de la formation"
                                 class="w-full h-44 object-cover group-hover:scale-105 transition duration-500">
                            <span class="absolute top-3 left-3 inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold
                                         bg-white/90 text-emerald-700 shadow">
                                <i class="fa-solid fa-signal"></i> {{ ucfirst($formation->level) }}
                            </span>
                        </div>

                        {{-- Contenu --}}
                        <div class="flex-1 p-5 flex flex-col">
                            <h3 class="text-lg font-bold text-emerald-700 mb-2 group-hover:text-green-800 transition">
                                {{ $formation->title }}
                            </h3>

                            <p class="text-sm text-slate-600 flex-1">
                                <i class="fa-regular fa-clock text-emerald-500 mr-1"></i>
                                Durée : <span class="font-medium">{{ $formation->duration ?? '—' }}h</span>
                            </p>

                            {{-- Footer --}}
                            <div class="mt-4 flex items-center justify-between">
                                <p class="text-lg font-extrabold bg-gradient-to-r from-green-600 to-indigo-600 bg-clip-text text-transparent">
                                    <i class="fa-solid fa-tag mr-1"></i> {{ number_format($formation->price, 2, ',', ' ') }} €
                                </p>
                                <span class="text-xs px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                                    <i class="fa-solid fa-video mr-1"></i>
                                    {{ $formation->videos_count ?? $formation->videos()->count() }} vidéo(s)
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <i class="fa-solid fa-circle-exclamation text-4xl text-emerald-500 mb-4"></i>
                <p class="text-lg text-gray-600">Vous n’avez encore ajouté aucune formation à votre panier.</p>
            </div>
        @endif

    </div>
</x-layouts.dashboard>
