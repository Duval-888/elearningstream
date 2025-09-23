<x-layouts.dashboard>
    <div class="max-w-7xl mx-auto px-2 md:px-0 space-y-8">

        {{-- HEADER CERTIFICATS --}}
        <div class="relative overflow-hidden rounded-3xl p-8 ring-1 ring-green-400/30 shadow-2xl
                    bg-gradient-to-br from-green-700 via-emerald-600 to-teal-600 text-white">
            <div class="absolute -top-16 -right-20 w-96 h-96 bg-white/15 blur-3xl rounded-full"></div>
            <h1 class="relative text-2xl md:text-3xl font-extrabold flex items-center gap-3">
                <i class="fa-solid fa-award"></i> Mes Certificats
            </h1>
            <p class="relative text-white/90 mt-2">Téléchargez vos attestations et partagez vos réussites.</p>
        </div>

        {{-- GRILLE DE CERTIFICATS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Exemple (remplace par ta boucle sur $certificates) --}}
            @for($i=1; $i<=6; $i++)
                <div class="group relative rounded-3xl overflow-hidden bg-white/95 backdrop-blur border border-emerald-200/60 shadow-xl">
                    <div class="px-5 py-3 bg-gradient-to-r from-emerald-600 to-green-600 text-white font-semibold flex items-center justify-between">
                        <span><i class="fa-solid fa-certificate mr-2"></i> Certificat #{{ $i }}</span>
                        <span class="text-white/90 text-sm"><i class="fa-regular fa-calendar mr-1"></i> 12 Sep 2025</span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-emerald-700">Développement Web Avancé</h3>
                        <p class="text-slate-600 text-sm mt-1">Score final : <span class="font-semibold text-indigo-700">92%</span></p>

                        <div class="mt-4 flex items-center justify-between">
                            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold
                                         bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                                <i class="fa-solid fa-user-graduate"></i> {{ auth()->user()->name }}
                            </span>

                            <a href="#" class="inline-flex items-center gap-2 rounded-xl px-3 py-2 text-white
                                               bg-gradient-to-r from-emerald-600 to-indigo-600 hover:from-emerald-500 hover:to-indigo-500
                                               shadow-md transition">
                                <i class="fa-solid fa-download"></i> Télécharger
                            </a>
                        </div>
                    </div>

                    {{-- Badge ruban --}}
                    <div class="absolute -top-4 left-5 inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold
                                bg-white shadow backdrop-blur text-emerald-700 ring-1 ring-emerald-200">
                        <i class="fa-solid fa-trophy"></i> Réussi
                    </div>
                </div>
            @endfor
        </div>

        {{-- TIMELINE / HISTORIQUE --}}
        <div class="rounded-3xl bg-white/95 backdrop-blur border border-emerald-200/60 shadow-xl p-6">
            <h3 class="text-lg font-bold text-emerald-700 flex items-center gap-2">
                <i class="fa-solid fa-timeline"></i> Historique des obtentions
            </h3>
            <ol class="mt-4 relative border-s-l border-emerald-200">
                @for($i=1;$i<=4;$i++)
                    <li class="mb-6 ms-6">
                        <span class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full
                                      bg-gradient-to-r from-emerald-600 to-indigo-600 text-white shadow ring-2 ring-white">
                            <i class="fa-solid fa-medal text-[10px]"></i>
                        </span>
                        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold text-emerald-800">Certificat #{{ $i }}</p>
                                <span class="text-sm text-slate-600"><i class="fa-regular fa-calendar mr-1"></i> 2025-09-0{{ $i }}</span>
                            </div>
                            <p class="text-sm text-slate-600 mt-1">Développement Web Avancé — Score 9{{ $i }}%</p>
                        </div>
                    </li>
                @endfor
            </ol>
        </div>

    </div>
</x-layouts.dashboard>
