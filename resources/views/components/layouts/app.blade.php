<div class="d-flex">
    {{-- Sidebar --}}
    <aside class="bg-dark text-white p-3" style="width: 250px;">
        <h4>{{ $title ?? 'Menu' }}</h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link text-white">🏠 Accueil</a></li>
            <li class="nav-item"><a href="{{ route('formations.index') }}" class="nav-link text-white">📚 Formations</a></li>
            <li class="nav-item"><a href="{{ route('courses.index') }}" class="nav-link text-white">🎓 Cours</a></li>
            <li class="nav-item"><a href="{{ route('profile') }}" class="nav-link text-white">👤 Profil</a></li>
        </ul>
    </aside>

    {{-- Contenu principal --}}
    <main class="flex-grow-1 p-4">
        {{ $slot }}
    </main>
</div>

