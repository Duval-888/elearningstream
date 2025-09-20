<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Apprenant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- ✅ Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ✅ Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="flex min-h-screen">
        <!-- ✅ Sidebar fixe -->
        <aside class="w-64 bg-gray-800 text-white p-6 h-screen fixed top-0 left-0 overflow-y-auto">
            @php $user = auth()->user(); @endphp

          @php $user = auth()->user(); @endphp

@if($user)
    <div class="flex items-center mb-6">
        <img src="{{ asset('images/profil.png') }}" alt="Profil" class="rounded-full w-10 h-10 mr-3">
        <div>
            <strong>{{ $user->name }}</strong><br>
            <small class="text-gray-300">{{ ucfirst($user->role) }}</small>
        </div>
    </div>

    <h5 class="text-lg font-semibold mb-4">📂 Menu {{ ucfirst($user->role) }}</h5>
@else
    <div class="mb-6 text-sm text-gray-300">
        Utilisateur non connecté
    </div>
@endif


            @php $user = auth()->user(); @endphp

@if($user)
    <h5 class="text-lg font-semibold mb-4">📂 Menu {{ ucfirst($user->role) }}</h5>
@else
    <h5 class="text-lg font-semibold mb-4">📂 Menu invité</h5>
@endif


           <nav class="space-y-4 mt-4">
    <a href="{{ route('dashboard.apprenant') }}"
       class="block px-4 py-2 rounded 
              {{ request()->routeIs('dashboard.apprenant') ? 'bg-gray-700 text-indigo-400' : 'bg-gray-800 text-white hover:bg-gray-700 hover:text-indigo-400' }}">
        🏠 Accueil
    </a>

    <a href="{{ route('mes.formations') }}"
       class="block px-4 py-2 rounded 
              {{ request()->routeIs('mes.formations') ? 'bg-gray-700 text-indigo-400' : 'bg-gray-800 text-white hover:bg-gray-700 hover:text-indigo-400' }}">
        📘 Mes formations
    </a>

    <a href="{{ route('forums.index') }}"
       class="block px-4 py-2 rounded 
              {{ request()->routeIs('forums.index') ? 'bg-gray-700 text-indigo-400' : 'bg-gray-800 text-white hover:bg-gray-700 hover:text-indigo-400' }}">
        💬 Forums
    </a>
</nav>


        </aside>

        <!-- ✅ Zone de contenu dynamique -->
        <main class="ml-64 flex-1 p-8">
            {{ $slot }}
        </main>
    </div>

</body>
</html>
