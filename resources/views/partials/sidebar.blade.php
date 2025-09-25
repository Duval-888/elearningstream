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
    @php
        $linkBase = 'flex items-center gap-3 px-3 py-2 rounded-lg transition';
        $linkIdle = 'text-white/80 hover:text-white hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-white/20';
        $linkActive = 'text-white bg-emerald-600 shadow-sm';
    @endphp

    <nav class="space-y-1">
        {{-- Accueil --}}
        <a href="{{ route('dashboard.admin') }}"
           class="{{ $linkBase }} {{ request()->routeIs('dashboard.admin') ? $linkActive : $linkIdle }}">
            <i class="fa-solid fa-house"></i>
            <span>Accueil</span>
        </a>

        {{-- Apprenants --}}
        <a href="{{ route('admin.apprenants') }}"
           class="{{ $linkBase }} {{ request()->routeIs('admin.apprenants*') ? $linkActive : $linkIdle }}">
            <i class="fa-solid fa-user-graduate"></i>
            <span>Apprenants</span>
        </a>

        {{-- Formateurs --}}
        <a href="{{ route('admin.formateurs') }}"
           class="{{ $linkBase }} {{ request()->routeIs('admin.formateurs*') ? $linkActive : $linkIdle }}">
            <i class="fa-solid fa-chalkboard-user"></i>
            <span>Formateurs</span>
        </a>

        {{-- ⭐ Profil (nouveau) --}}
        <a href="{{ route('admin.profil') }}"
           class="{{ $linkBase }} {{ request()->routeIs('admin.profil') ? $linkActive : $linkIdle }}">
            <i class="fa-solid fa-user-shield"></i>
            <span>Profil</span>
        </a>

        {{-- Formations --}}
        <a href="{{ route('courses.index') }}"
           class="{{ $linkBase }} {{ request()->routeIs('courses.*') ? $linkActive : $linkIdle }}">
            <i class="fa-solid fa-book"></i>
            <span>Formations</span>
        </a>

        {{-- Déconnexion --}}
        <a href="{{ route('logout') }}"
           class="mt-3 {{ $linkBase }} text-red-200 hover:text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-white/20">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Déconnexion</span>
        </a>
    </nav>
@endif


</aside>
