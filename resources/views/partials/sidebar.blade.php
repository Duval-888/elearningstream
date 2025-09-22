@php
    $user = auth()->user();
@endphp

<aside class="w-64 bg-emerald-700 text-white p-6 h-screen fixed top-0 left-0 overflow-y-auto">
    {{-- 👤 Profil utilisateur --}}
    <div class="flex items-center mb-6">
        <img src="{{ asset('images/profil.png') }}" alt="Photo de profil" class="rounded-full w-10 h-10 mr-3">
        <div>
            <strong>{{ $user->name ?? 'Utilisateur' }}</strong><br>
            <small class="text-emerald-100">{{ ucfirst($user->role ?? '') }}</small>
        </div>
    </div>

    <h5 class="text-sm font-semibold uppercase tracking-wide text-emerald-100 mb-4">
        📂 Menu {{ ucfirst($user->role ?? '') }}
    </h5>

    {{-- Apprenant --}}
    @if($user && $user->role === 'apprenant')
        <nav class="space-y-1">
            <a href="{{ route('dashboard.apprenant') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('dashboard.apprenant') ? 'bg-emerald-800 text-white' : 'text-white/90 hover:text-white hover:bg-emerald-600' }}">
                <i class="fa-solid fa-house"></i> Accueil
            </a>

            <a href="{{ route('panier') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('mes.formations') ? 'bg-emerald-800 text-white' : 'text-white/90 hover:text-white hover:bg-emerald-600' }}">
                <i class="fa-solid fa-cart-shopping"></i> Panier
            </a>

            <a href="{{ route('forums.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('forums.index') ? 'bg-emerald-800 text-white' : 'text-white/90 hover:text-white hover:bg-emerald-600' }}">
                <i class="fa-regular fa-comments"></i> Forums
            </a>
        </nav>

    {{-- Formateur --}}
@elseif($user && $user->role === 'formateur')
    <nav class="space-y-1">
        <a href="{{ route('dashboard.formateur') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('dashboard.formateur') ? 'bg-emerald-800 text-white' : 'text-white/90 hover:text-white hover:bg-emerald-600' }}">
            <i class="fa-solid fa-house"></i> Accueil
        </a>

        <a href="{{ route('formations.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('formations.*') ? 'bg-emerald-800 text-white' : 'text-white/90 hover:text-white hover:bg-emerald-600' }}">
            <i class="fa-solid fa-book-open"></i> Formations
        </a>

        {{-- 👤 Profil --}}
        <a href="{{ route('formateur.profile') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('formateur.profile') ? 'bg-emerald-800 text-white' : 'text-white/90 hover:text-white hover:bg-emerald-600' }}">
            <i class="fa-regular fa-user"></i> Profil
        </a>

        {{-- 📝 Quiz (corrigé) --}}
        <a href="{{ route('formateur.quizzes') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('formateur.quizzes*') ? 'bg-emerald-800 text-white' : 'text-white/90 hover:text-white hover:bg-emerald-600' }}">
            <i class="fa-solid fa-list-check"></i> Quiz
        </a>

        <a href="{{ route('streaming.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('streaming.index') ? 'bg-emerald-800 text-white' : 'text-white/90 hover:text-white hover:bg-emerald-600' }}">
            <i class="fa-solid fa-tower-broadcast"></i> Streaming
        </a>

        <a href="{{ route('notifications.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('notifications.index') ? 'bg-emerald-800 text-white' : 'text-white/90 hover:text-white hover:bg-emerald-600' }}">
            <i class="fa-regular fa-bell"></i> Notifications
        </a>
    </nav>


    {{-- Administrateur --}}
    @elseif($user && $user->role === 'admin')
        <nav class="space-y-1">
            <a href="{{ route('dashboard.admin') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-white/90 hover:text-white hover:bg-emerald-600">
                <i class="fa-solid fa-house"></i> Accueil
            </a>
            <a href="{{ route('admin.apprenants') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-white/90 hover:text-white hover:bg-emerald-600">
                <i class="fa-solid fa-user-graduate"></i> Apprenants
            </a>
            <a href="{{ route('admin.formateurs') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-white/90 hover:text-white hover:bg-emerald-600">
                <i class="fa-solid fa-chalkboard-user"></i> Formateurs
            </a>
            <a href="{{ route('courses.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-white/90 hover:text-white hover:bg-emerald-600">
                <i class="fa-solid fa-book"></i> Formations
            </a>
            <a href="{{ route('logout') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-red-200 hover:text-white hover:bg-red-600 mt-3">
                <i class="fa-solid fa-right-from-bring-out"></i> Déconnexion
            </a>
        </nav>
    @endif
</aside>
