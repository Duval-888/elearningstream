<x-layouts.dashboard>
    <div class="max-w-7xl mx-auto px-4 py-10">

        {{-- ===== HERO / WELCOME ===== --}}
        <div class="relative overflow-hidden rounded-3xl mb-8 ring-1 ring-green-400/30 shadow-xl
                    bg-gradient-to-br from-green-700 via-green-600 to-emerald-500">
            <div class="absolute -top-20 -right-24 w-80 h-80 rounded-full blur-3xl opacity-30
                        bg-gradient-to-tr from-sky-400 to-indigo-500"></div>
            <div class="absolute -bottom-16 -left-16 w-72 h-72 rounded-full blur-3xl opacity-30
                        bg-gradient-to-tr from-lime-400 to-green-500"></div>

            <div class="relative px-6 md:px-10 py-8 md:py-10 text-white">
                <div class="flex items-center justify-center gap-3 text-white/90 text-sm mb-3">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur">
                        <i class="fa-solid fa-bolt"></i> Tableau de bord Apprenant
                    </span>
                    <span class="hidden md:inline-block text-white/60">•</span>
                    <span class="hidden md:inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur">
                        <i class="fa-solid fa-shield-heart"></i> Motivé et prêt à apprendre
                    </span>
                </div>

                <h1 class="text-center text-2xl md:text-3xl font-extrabold tracking-tight">
                    Bonjour {{ auth()->user()->name }} 👋
                </h1>
                <p class="text-center text-white/90 mt-2">
                    Explorez vos cours, participez aux sessions en direct et récupérez vos certificats.
                </p>
            </div>
        </div>

        {{-- ===== SEARCH BAR ===== --}}
        <form action="{{ route('search.global') }}" method="GET" class="mb-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative group">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-green-600 group-focus-within:text-green-700"></i>
                    <input type="text" name="query"
                        class="w-full pl-10 pr-4 py-3 rounded-2xl border border-green-300/40 bg-white/80 backdrop-blur
                               focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition"
                        placeholder="Rechercher un cours, une session, un certificat…">
                </div>
                <div class="relative group">
                    <i class="fa-solid fa-filter absolute left-3 top-1/2 -translate-y-1/2 text-green-600 group-focus-within:text-green-700"></i>
                    <select name="type"
                        class="w-full pl-10 pr-4 py-3 rounded-2xl border border-green-300/40 bg-white/80 backdrop-blur
                               focus:border-green-500 focus:ring-4 focus:ring-green-500/20 transition">
                        <option value="">Tous les types</option>
                        <option value="cours">Cours</option>
                        <option value="session">Sessions live</option>
                        <option value="certificat">Certificats</option>
                    </select>
                </div>
                <button type="submit"
                    class="w-full rounded-2xl px-4 py-3 font-semibold text-white shadow-lg transition
                           bg-gradient-to-r from-green-700 via-green-600 to-indigo-600
                           hover:from-green-600 hover:via-green-500 hover:to-indigo-500
                           ring-1 ring-green-400/50 hover:ring-green-300/60">
                    <i class="fa-solid fa-magnifying-glass mr-2"></i> Rechercher
                </button>
            </div>
        </form>

        {{-- ===== TOP CARDS ===== --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- MES COURS SUIVIS --}}
            <div class="group rounded-3xl overflow-hidden ring-1 ring-green-300/30 bg-white/90 backdrop-blur shadow-xl">
                <div class="px-5 py-3 font-semibold text-white flex items-center gap-2
                            bg-gradient-to-r from-green-700 via-green-600 to-sky-600">
                    <i class="fa-solid fa-book-open-reader"></i> <span>Mes cours suivis</span>
                </div>
                <div class="p-5">
                    @forelse($enrollments as $enrollment)
                        <div class="mb-6 last:mb-0">
                            <h6 class="text-green-800 font-bold flex items-center gap-2">
                                <i class="fa-solid fa-graduation-cap text-indigo-500"></i>
                                {{ $enrollment->course->title }}
                            </h6>
                            <p class="text-sm text-slate-600 mt-1">{{ $enrollment->course->description }}</p>

                            {{-- Progress bar --}}
                            <div class="mt-3">
                                <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden ring-1 ring-slate-200">
                                    <div class="h-3 rounded-full bg-gradient-to-r from-green-600 via-emerald-500 to-sky-500
                                                shadow-inner"
                                         style="width: {{ $enrollment->progress ?? 0 }}%;"></div>
                                </div>
                                <p class="text-xs text-slate-500 mt-2">
                                    Progression :
                                    <span class="font-semibold text-green-700">{{ $enrollment->progress ?? 0 }}%</span>
                                </p>
                            </div>

                            <a href="{{ route('courses.show', $enrollment->course->id) }}"
                               class="inline-flex items-center gap-2 mt-3 px-3 py-2 rounded-xl text-green-700 hover:text-white
                                      bg-green-50 hover:bg-green-600 transition font-medium ring-1 ring-green-200 hover:ring-green-500">
                                <i class="fa-solid fa-arrow-right"></i> Continuer
                            </a>
                        </div>
                        <hr class="my-5 border-slate-200/70">
                    @empty
                        <p class="text-slate-500">Aucun cours suivi pour le moment.</p>
                    @endforelse
                </div>
            </div>

            {{-- SESSIONS EN DIRECT --}}
            <div class="group rounded-3xl overflow-hidden ring-1 ring-green-300/30 bg-white/90 backdrop-blur shadow-xl">
                <div class="px-5 py-3 font-semibold text-white flex items-center gap-2
                            bg-gradient-to-r from-emerald-700 via-green-600 to-indigo-600">
                    <i class="fa-solid fa-video"></i> <span>Sessions en direct</span>
                </div>
                <div class="p-5">
                    @forelse($liveSessions as $session)
                        <div class="mb-6 last:mb-0">
                            <h6 class="text-indigo-700 font-bold flex items-center gap-2">
                                <i class="fa-regular fa-calendar"></i>
                                {{ $session->title }}
                            </h6>
                            <p class="text-sm text-slate-600 mt-1">{{ $session->description }}</p>
                            <p class="text-xs text-slate-500 mt-2">
                                Prévue le :
                                <span class="font-semibold text-green-700">{{ $session->scheduled_at->format('d M Y à H:i') }}</span>
                            </p>
                            <a href="{{ $session->meeting_url }}" target="_blank"
                               class="inline-flex items-center gap-2 mt-3 px-3 py-2 rounded-xl text-white
                                      bg-gradient-to-r from-green-700 via-emerald-600 to-indigo-600
                                      hover:from-green-600 hover:via-emerald-500 hover:to-indigo-500
                                      shadow-lg transition ring-1 ring-green-400/50">
                                <i class="fa-solid fa-right-to-bracket"></i> Rejoindre
                            </a>
                        </div>
                        <hr class="my-5 border-slate-200/70">
                    @empty
                        <p class="text-slate-500">Aucune session en direct pour le moment.</p>
                    @endforelse
                </div>
            </div>

            {{-- MES CERTIFICATS --}}
            <div class="group rounded-3xl overflow-hidden ring-1 ring-green-300/30 bg-white/90 backdrop-blur shadow-xl">
                <div class="px-5 py-3 font-semibold text-white flex items-center gap-2
                            bg-gradient-to-r from-green-700 via-emerald-600 to-teal-600">
                    <i class="fa-solid fa-award"></i> <span>Mes certificats</span>
                </div>
                <div class="p-5">
                    @forelse($certificates as $cert)
                        <div class="mb-6 last:mb-0">
                            <h6 class="text-green-800 font-bold flex items-center gap-2">
                                <i class="fa-solid fa-certificate text-sky-500"></i>
                                {{ $cert->course->title }}
                            </h6>
                            <p class="text-sm">Score final :
                                <span class="font-semibold text-indigo-700">{{ $cert->final_score ?? 0 }}%</span>
                            </p>
                            <p class="text-xs text-slate-500 mt-1">
                                Délivré le : {{ $cert->issued_at ? $cert->issued_at->format('d M Y') : '' }}
                            </p>
                            <a href="{{ asset($cert->file_path) }}" download
                               class="inline-flex items-center gap-2 mt-3 px-3 py-2 rounded-xl text-green-800 hover:text-white
                                      bg-green-50 hover:bg-green-600 transition font-medium ring-1 ring-green-200 hover:ring-green-500">
                                <i class="fa-solid fa-download"></i> Télécharger
                            </a>
                        </div>
                        <hr class="my-5 border-slate-200/70">
                    @empty
                        <p class="text-slate-500">Pas encore de certificats obtenus.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ===== LISTE DES FORMATIONS SUIVIES ===== --}}
        @forelse($formations as $formation)
            <div class="relative my-7 rounded-3xl p-6 md:p-7 bg-white/95 backdrop-blur
                        ring-1 ring-green-300/40 shadow-2xl hover:shadow-green-700/10 transition">
                {{-- Ruban --}}
                <div class="absolute -top-3 left-6 inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold
                            bg-gradient-to-r from-green-600 to-emerald-500 text-white shadow">
                    <i class="fa-solid fa-leaf"></i> Formation
                </div>

                <h3 class="text-xl font-extrabold text-green-800 mb-2 flex items-center gap-2">
                    <i class="fa-solid fa-chalkboard-user text-indigo-500"></i>
                    {{ $formation->title }}
                </h3>
                <p class="text-sm text-slate-600">Niveau :
                    <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-semibold
                                 bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200 ml-1">
                        <i class="fa-solid fa-signal"></i> {{ $formation->level }}
                    </span>
                </p>
                <p class="text-sm text-slate-500 mt-2">Description : {{ $formation->description }}</p>

                <div class="flex flex-wrap gap-3 mt-5">
                    {{-- Bouton Voir --}}
                    <a href="{{ route('formations.show', $formation->slug) }}"
                       class="inline-flex items-center gap-2 rounded-2xl px-4 py-2.5 text-white text-sm font-semibold
                              bg-gradient-to-r from-green-700 via-green-600 to-indigo-600
                              hover:from-green-600 hover:via-green-500 hover:to-indigo-500
                              shadow-lg hover:shadow-xl transition ring-1 ring-green-400/50">
                        <i class="fa-solid fa-eye"></i> Voir
                    </a>

                    {{-- Bouton Retirer --}}
                    <form method="POST" action="{{ route('inscription.retirer', $formation->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Êtes-vous sûr de vouloir retirer cette formation ?')"
                                class="inline-flex items-center gap-2 rounded-2xl px-4 py-2.5 text-white text-sm font-semibold
                                       bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-500/90 hover:to-rose-600/90
                                       shadow-lg hover:shadow-xl transition ring-1 ring-rose-400/40">
                            <i class="fa-solid fa-xmark"></i> Retirer
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-slate-500 mt-10">Aucune formation suivie pour le moment.</p>
        @endforelse>

    </div>
</x-layouts.dashboard>
