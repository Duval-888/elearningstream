@php
    $user = auth()->user();
@endphp

<div class="sidebar">
    {{-- 👤 Profil utilisateur --}}
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/profil.png') }}" alt="Photo de profil" class="rounded-circle me-2" width="40" height="40">
        <div>
            <strong>{{ $user->name }}</strong><br>
            <small class="text-muted">{{ ucfirst($user->role) }}</small>
        </div>
    </div>

    <h5 class="mb-4">📂 Menu {{ ucfirst($user->role) }}</h5>

    {{-- Apprenant --}}
    @if($user->role === 'apprenant')
        <a href="{{ route('dashboard.apprenant') }}" class="d-block mb-2">🏠 Accueil</a>
        <a href="{{ route('courses.index') }}" class="d-block mb-2">📘 Mes cours</a>
        <a href="{{ route('forums.index') }}" class="d-block mb-2">💬 Forums</a>

    {{-- Formateur --}}
    @elseif($user->role === 'formateur')
        <a href="{{ route('dashboard.formateur') }}" class="d-block mb-2">🏠 Accueil</a>
        <a href="{{ route('formations.index') }}" class="d-block mb-2">📚 Formations</a>
        <a href="{{ route('streaming.index') }}" class="d-block mb-2">📺 Streaming</a>
        <a href="{{ route('notifications.index') }}" class="d-block mb-2">🔔 Notifications</a>

    {{-- Administrateur --}}
    @elseif($user->role === 'admin')
        <a href="{{ route('dashboard.admin') }}" class="d-block mb-2">🏠 Accueil</a>
        <a href="{{ route('admin.apprenants') }}" class="d-block mb-2">🎓 Apprenants</a>
        <a href="{{ route('admin.formateurs') }}" class="d-block mb-2">🧑‍🏫 Formateurs</a>
        <a href="{{ route('courses.index') }}" class="d-block mb-2">📘 Formations</a>
        <a href="{{ route('logout') }}" class="d-block text-danger mt-4">🚪 Déconnexion</a>
    @endif
</div>
