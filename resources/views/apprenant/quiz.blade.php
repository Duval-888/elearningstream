<x-layouts.dashboard>
    <div class="max-w-7xl mx-auto px-2 md:px-0 space-y-8">

        {{-- HEADER QUIZ --}}
        <div class="relative overflow-hidden rounded-3xl p-8 ring-1 ring-green-400/30 shadow-2xl
                    bg-gradient-to-br from-emerald-700 via-green-600 to-indigo-600 text-white">
            <div class="absolute -top-16 -right-16 w-80 h-80 bg-white/20 blur-3xl rounded-full"></div>
            <h1 class="relative text-2xl md:text-3xl font-extrabold flex items-center gap-3">
                <i class="fa-solid fa-list-check"></i> Mes Quiz
            </h1>
            <p class="relative text-white/90 mt-2">Entraînez-vous et progressez avec vos évaluations.</p>
        </div>

        {{-- FILTRES --}}
        <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-emerald-600"></i>
                <input class="w-full pl-10 pr-4 py-3 rounded-2xl border border-emerald-200/60 bg-white/90 backdrop-blur
                              focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition"
                       placeholder="Rechercher un quiz...">
            </div>
            <select class="rounded-2xl border border-emerald-200/60 bg-white/90 backdrop-blur px-4 py-3 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition">
                <option>Tous les statuts</option>
                <option>Disponible</option>
                <option>Terminé</option>
                <option>Échoué</option>
            </select>
            <select class="rounded-2xl border border-emerald-200/60 bg-white/90 backdrop-blur px-4 py-3 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition">
                <option>Tous les niveaux</option>
                <option>Débutant</option>
                <option>Intermédiaire</option>
                <option>Avancé</option>
            </select>
            <button type="button"
                class="rounded-2xl px-4 py-3 font-semibold text-white shadow-lg transition
                       bg-gradient-to-r from-emerald-600 via-green-600 to-indigo-600
                       hover:from-emerald-500 hover:to-indigo-500">
                <i class="fa-solid fa-filter mr-2"></i> Filtrer
            </button>
        </form>

        {{-- TABLEAU DES QUIZ --}}
        <div class="bg-white/95 backdrop-blur rounded-3xl border border-emerald-200/60 shadow-2xl overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-emerald-600 to-green-600 text-white font-semibold flex items-center gap-2">
                <i class="fa-solid fa-clipboard-check"></i> Liste des quiz
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-500 border-b">
                            <th class="px-6 py-3">Quiz</th>
                            <th class="px-6 py-3">Cours</th>
                            <th class="px-6 py-3">Niveau</th>
                            <th class="px-6 py-3">Statut</th>
                            <th class="px-6 py-3">Score</th>
                            <th class="px-6 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        {{-- Exemple d’item (remplace avec ta boucle si besoin) --}}
                        @for($i=1;$i<=5;$i++)
                            <tr class="hover:bg-emerald-50/50">
                                <td class="px-6 py-4 font-semibold text-slate-800">Quiz #{{ $i }}</td>
                                <td class="px-6 py-4 text-slate-600">Développement Web</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-semibold
                                                 bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                                        <i class="fa-solid fa-signal"></i> Intermédiaire
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-semibold
                                                 bg-sky-50 text-sky-700 ring-1 ring-sky-200">
                                        <i class="fa-regular fa-clock"></i> Disponible
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-semibold">—</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="#" class="inline-flex items-center gap-2 rounded-xl px-3 py-2 text-white
                                                       bg-gradient-to-r from-emerald-600 to-indigo-600 hover:from-emerald-500 hover:to-indigo-500
                                                       shadow-md transition">
                                        <i class="fa-solid fa-play"></i> Commencer
                                    </a>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ASTUCES --}}
        <div class="rounded-3xl bg-white/90 backdrop-blur border border-emerald-200/60 shadow-xl p-6">
            <h3 class="text-lg font-bold text-emerald-700 flex items-center gap-2">
                <i class="fa-solid fa-lightbulb"></i> Astuce pour réussir
            </h3>
            <p class="text-slate-600 mt-2">
                Faites d’abord les quiz d’échauffement, révisez vos erreurs, puis revenez plus tard pour améliorer votre score.
            </p>
        </div>

    </div>
</x-layouts.dashboard>
