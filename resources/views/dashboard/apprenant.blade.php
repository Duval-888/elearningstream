<x-layouts.dashboard>
    <div class="max-w-7xl mx-auto px-4 py-8">

        {{-- ✅ Message de bienvenue dynamique --}}
        <div class="bg-green-100 text-green-800 text-center font-semibold py-3 rounded mb-6">
            Bonjour {{ auth()->user()->name }} 👋, bienvenue dans votre espace <strong>Apprenant</strong> !
        </div>
        <p class="text-gray-600 text-center mb-8">
            Explorez vos cours, participez aux sessions en direct et téléchargez vos certificats.
        </p>

        {{-- 🔍 Barre de recherche avec filtre --}}
        <form action="{{ route('search.global') }}" method="GET" class="mb-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="query" class="border border-gray-300 rounded px-4 py-2 w-full" placeholder="Rechercher...">
                <select name="type" class="border border-gray-300 rounded px-4 py-2 w-full">
                    <option value="">Tous les types</option>
                    <option value="cours">Cours</option>
                    <option value="session">Sessions live</option>
                    <option value="certificat">Certificats</option>
                </select>
                <button type="submit" class="bg-indigo-600 text-white rounded px-4 py-2 w-full hover:bg-indigo-700">
                    🔍 Rechercher
                </button>
            </div>
        </form>

        {{-- 🎓 Blocs horizontaux --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- 📚 Mes cours suivis --}}
            <div class="bg-white shadow rounded overflow-hidden">
                <div class="bg-indigo-600 text-white px-4 py-2 font-semibold">📚 Mes cours suivis</div>
                <div class="p-4">
                    @forelse($enrollments as $enrollment)
                        <h6 class="text-indigo-600 font-bold">{{ $enrollment->course->title }}</h6>
                        <p class="text-sm text-gray-500 mb-2">{{ $enrollment->course->description }}</p>
                        <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $enrollment->progress ?? 0 }}%;"></div>
                        </div>
                        <p class="text-xs text-gray-500 mb-2">Progression : {{ $enrollment->progress ?? 0 }}%</p>
                        <a href="{{ route('courses.show', $enrollment->course->id) }}" class="text-indigo-600 text-sm underline">Continuer</a>
                        <hr class="my-4">
                    @empty
                        <p class="text-gray-500">Aucun cours suivi pour le moment.</p>
                    @endforelse
                </div>
            </div>

            {{-- 🎥 Sessions en direct --}}
            <div class="bg-white shadow rounded overflow-hidden">
                <div class="bg-red-600 text-white px-4 py-2 font-semibold">🎥 Sessions en direct</div>
                <div class="p-4">
                    @forelse($liveSessions as $session)
                        <h6 class="text-red-600 font-bold">{{ $session->title }}</h6>
                        <p class="text-sm text-gray-500 mb-2">{{ $session->description }}</p>
                        <p class="text-xs text-gray-500 mb-2">Prévue le : {{ $session->scheduled_at->format('d M Y à H:i') }}</p>
                        <a href="{{ $session->meeting_url }}" target="_blank" class="text-red-600 text-sm underline">Rejoindre</a>
                        <hr class="my-4">
                    @empty
                        <p class="text-gray-500">Aucune session en direct pour le moment.</p>
                    @endforelse
                </div>
            </div>

            {{-- 📜 Mes certificats --}}
            <div class="bg-white shadow rounded overflow-hidden">
                <div class="bg-green-600 text-white px-4 py-2 font-semibold">📜 Mes certificats</div>
                <div class="p-4">
                    @forelse($certificates as $cert)
                        <h6 class="text-green-600 font-bold">{{ $cert->course->title }}</h6>
                        <p class="text-sm">Score final : {{ $cert->final_score ?? 0 }}%</p>
                        <p class="text-xs text-gray-500 mb-2">Délivré le : {{ $cert->issued_at ? $cert->issued_at->format('d M Y') : '' }}</p>
                        <a href="{{ asset($cert->file_path) }}" download class="text-green-600 text-sm underline">📥 Télécharger</a>
                        <hr class="my-4">
                    @empty
                        <p class="text-gray-500">Pas encore de certificats obtenus.</p>
                    @endforelse
                </div>
            </div>
        </div>

       @forelse($formations as $formation)
    <div class="bg-white shadow-md rounded p-6 mb-4">
        <h3 class="text-xl font-semibold text-indigo-700 mb-2">{{ $formation->title }}</h3>
        <p class="text-sm text-gray-600 mb-2">Niveau : {{ $formation->level }}</p>
        <p class="text-sm text-gray-500 mb-4">Description : {{ $formation->description }}</p>

        <div class="flex space-x-4">
            <!-- Bouton Voir -->
            <a href="{{ route('formations.show', $formation->slug) }}"
               class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded text-sm">
                🔍 Voir
            </a>

            <!-- Bouton Retirer -->
            <form method="POST" action="{{ route('inscription.retirer', $formation->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Êtes-vous sûr de vouloir retirer cette formation ?')"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm">
                    ❌ Retirer
                </button>
            </form>
        </div>
    </div>
@empty
    <p class="text-gray-500">Aucune formation suivie pour le moment.</p>
@endforelse


</div>

    </div>
</x-layouts.dashboard>
