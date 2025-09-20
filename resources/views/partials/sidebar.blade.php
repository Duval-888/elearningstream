@php
    $user = auth()->user();
@endphp

<aside class="w-64 bg-gray-800 text-white p-6 h-screen fixed top-0 left-0 overflow-y-auto">
    {{-- 👤 Profil utilisateur --}}
    <div class="flex items-center mb-6">
        <img src="{{ asset('images/profil.png') }}" alt="Photo de profil" class="rounded-full w-10 h-10 mr-3">
        <div>
            <strong>{{ $user->name }}</strong><br>
            <small class="text-gray-300">{{ ucfirst($user->role) }}</small>
        </div>
    </div>

    <h5 class="text-lg font-semibold mb-4">📂 Menu {{ ucfirst($user->role) }}</h5>

    {{-- Apprenant --}}
    @if($user->role === 'apprenant')
      <nav class="space-y-2">
    <a href="{{ route('dashboard.apprenant') }}"
       class="block px-2 py-1 rounded 
              {{ request()->routeIs('dashboard.apprenant') ? 'bg-gray-900 text-indigo-400' : 'hover:bg-gray-700 hover:text-indigo-400' }}">
        🏠 Accueil
    </a>

<a href="{{ route('panier') }}"
   class="block px-4 py-2 rounded 
          {{ request()->routeIs('mes.formations') ? 'bg-gray-700 text-indigo-400' : 'bg-gray-800 text-white hover:bg-gray-700 hover:text-indigo-400' }}">
    🛒 Panier
</a>



    <a href="{{ route('forums.index') }}"
       class="block px-2 py-1 rounded 
              {{ request()->routeIs('forums.index') ? 'bg-gray-900 text-indigo-400' : 'hover:bg-gray-700 hover:text-indigo-400' }}">
        💬 Forums
    </a>
</nav>


    {{-- Formateur --}}
    @elseif($user->role === 'formateur')
        <nav class="space-y-2">
            <a href="{{ route('dashboard.formateur') }}" class="block hover:text-indigo-400">🏠 Accueil</a>
            <a href="{{ route('formations.index') }}" class="block hover:text-indigo-400">📚 Formations</a>
            <a href="{{ route('streaming.index') }}" class="block hover:text-indigo-400">📺 Streaming</a>
            <a href="{{ route('notifications.index') }}" class="block hover:text-indigo-400">🔔 Notifications</a>
        </nav>

    {{-- Administrateur --}}
    @elseif($user->role === 'admin')
        <nav class="space-y-2">
            <a href="{{ route('dashboard.admin') }}" class="block hover:text-indigo-400">🏠 Accueil</a>
            <a href="{{ route('admin.apprenants') }}" class="block hover:text-indigo-400">🎓 Apprenants</a>
            <a href="{{ route('admin.formateurs') }}" class="block hover:text-indigo-400">🧑‍🏫 Formateurs</a>
            <a href="{{ route('courses.index') }}" class="block hover:text-indigo-400">📘 Formations</a>
            <a href="{{ route('logout') }}" class="block text-red-500 mt-4 hover:text-red-400">🚪 Déconnexion</a>
        </nav>
    @endif
</aside>
