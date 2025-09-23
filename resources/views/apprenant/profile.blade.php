<x-layouts.dashboard>
    <div class="max-w-6xl mx-auto px-2 md:px-0 space-y-8">

        {{-- HERO PROFILE --}}
        <section class="relative overflow-hidden rounded-3xl ring-1 ring-green-400/30 shadow-2xl
                        bg-gradient-to-br from-green-700 via-emerald-600 to-sky-600 text-white">
            <div class="absolute -top-10 -right-12 w-72 h-72 bg-white/15 blur-3xl rounded-full"></div>
            <div class="absolute -bottom-12 -left-10 w-64 h-64 bg-lime-400/20 blur-3xl rounded-full"></div>

            <div class="relative p-8 md:p-10 flex flex-col md:flex-row md:items-center gap-6">
                <div class="relative">
                    <img src="{{ asset('images/profil.png') }}" class="w-28 h-28 md:w-32 md:h-32 rounded-2xl ring-4 ring-white/20 shadow-xl object-cover" alt="Avatar">
                    <span class="absolute -bottom-2 -right-2 inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur">
                        <i class="fa-solid fa-crown"></i> Apprenant
                    </span>
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl md:text-3xl font-extrabold">{{ auth()->user()->name }}</h1>
                    <p class="text-white/90 mt-1">Bienvenue dans votre profil ✨</p>

                    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-3">
                        <div class="rounded-2xl bg-white/10 backdrop-blur px-4 py-3 ring-1 ring-white/20">
                            <p class="text-sm text-white/80">Cours suivis</p>
                            <p class="text-2xl font-extrabold">12</p>
                        </div>
                        <div class="rounded-2xl bg-white/10 backdrop-blur px-4 py-3 ring-1 ring-white/20">
                            <p class="text-sm text-white/80">Certificats</p>
                            <p class="text-2xl font-extrabold">03</p>
                        </div>
                        <div class="rounded-2xl bg-white/10 backdrop-blur px-4 py-3 ring-1 ring-white/20">
                            <p class="text-sm text-white/80">Quiz réussis</p>
                            <p class="text-2xl font-extrabold">28</p>
                        </div>
                        <div class="rounded-2xl bg-white/10 backdrop-blur px-4 py-3 ring-1 ring-white/20">
                            <p class="text-sm text-white/80">Taux moyen</p>
                            <p class="text-2xl font-extrabold">86%</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <a href="{{ route('apprenant.profile') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/15 hover:bg-white/25 transition ring-1 ring-white/30">
                        <i class="fa-solid fa-pen-to-square"></i> Modifier le profil
                    </a>
                    <a href="{{ route('apprenant.certificats') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-emerald-700 font-semibold hover:bg-emerald-50 transition">
                        <i class="fa-solid fa-award"></i> Voir mes certificats
                    </a>
                </div>
            </div>
        </section>

        {{-- INFOS & PREFERENCES --}}
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white/90 backdrop-blur rounded-3xl border border-emerald-200/60 shadow-xl p-6">
                <h2 class="text-xl font-bold text-emerald-700 flex items-center gap-2">
                    <i class="fa-solid fa-id-card-clip"></i> Informations personnelles
                </h2>
                <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-slate-500">Nom complet</label>
                        <div class="mt-1 flex items-center gap-2 bg-slate-50 border border-emerald-100 rounded-xl px-3 py-2">
                            <i class="fa-solid fa-user text-emerald-600"></i>
                            <span class="font-medium">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-slate-500">Email</label>
                        <div class="mt-1 flex items-center gap-2 bg-slate-50 border border-emerald-100 rounded-xl px-3 py-2">
                            <i class="fa-solid fa-envelope text-emerald-600"></i>
                            <span class="font-medium">{{ auth()->user()->email ?? '—' }}</span>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-slate-500">Rôle</label>
                        <div class="mt-1 flex items-center gap-2 bg-slate-50 border border-emerald-100 rounded-xl px-3 py-2">
                            <i class="fa-solid fa-user-graduate text-emerald-600"></i>
                            <span class="font-medium">Apprenant</span>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-slate-500">Téléphone</label>
                        <div class="mt-1 flex items-center gap-2 bg-slate-50 border border-emerald-100 rounded-xl px-3 py-2">
                            <i class="fa-solid fa-phone text-emerald-600"></i>
                            <span class="font-medium">—</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-emerald-700 flex items-center gap-2">
                        <i class="fa-solid fa-shield-heart"></i> Préférences
                    </h3>
                    <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-3">
                        <span class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                            <i class="fa-solid fa-bell"></i> Notifications activées
                        </span>
                        <span class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                            <i class="fa-solid fa-moon"></i> Thème clair
                        </span>
                        <span class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                            <i class="fa-solid fa-language"></i> Français
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white/90 backdrop-blur rounded-3xl border border-emerald-200/60 shadow-xl p-6">
                <h2 class="text-xl font-bold text-emerald-700 flex items-center gap-2">
                    <i class="fa-solid fa-bolt"></i> Résumé rapide
                </h2>
                <ul class="mt-4 space-y-3">
                    <li class="flex items-center justify-between">
                        <span class="text-slate-600">Progression globale</span>
                        <span class="font-bold text-emerald-700">72%</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-slate-600">Cours en cours</span>
                        <span class="font-bold">4</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-slate-600">Dernière activité</span>
                        <span class="font-bold">il y a 2j</span>
                    </li>
                </ul>
                <a href="{{ route('mes.formations') }}"
                   class="mt-6 inline-flex items-center gap-2 w-full justify-center rounded-2xl px-4 py-2.5 text-white
                          bg-gradient-to-r from-emerald-600 via-green-600 to-indigo-600 hover:from-emerald-500 hover:to-indigo-500
                          shadow-lg transition">
                    <i class="fa-solid fa-arrow-trend-up"></i> Continuer mes cours
                </a>
            </div>
        </section>

    </div>
</x-layouts.dashboard>
