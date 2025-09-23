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
       <!-- ✅ Sidebar fixe -->
<!-- ✅ Sidebar fixe -->
<aside class="w-64 bg-green-700 text-white p-6 h-screen fixed top-0 left-0 overflow-y-auto">
    @php $user = auth()->user(); @endphp

    @if($user)
        <div class="flex items-center mb-8">
            <img src="{{ asset('images/profil.png') }}" alt="Profil" class="rounded-full w-12 h-12 mr-3 border-2 border-white shadow">
            <div>
                <strong class="text-lg">{{ $user->name }}</strong><br>
                <small class="text-green-100">{{ ucfirst($user->role) }}</small>
            </div>
        </div>

        <h5 class="text-sm font-semibold uppercase tracking-wide text-green-100 mb-4">
            <i class="fa-solid fa-folder-open mr-2"></i> Menu {{ ucfirst($user->role) }}
        </h5>
    @else
        <div class="mb-6 text-sm text-green-100">
            Utilisateur non connecté
        </div>
        <h5 class="text-sm font-semibold uppercase tracking-wide text-green-100 mb-4">
            <i class="fa-solid fa-folder-open mr-2"></i> Menu invité
        </h5>
    @endif

    <nav class="space-y-2 mt-4">
        <a href="{{ route('dashboard.apprenant') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg transition 
                  {{ request()->routeIs('dashboard.apprenant') 
                        ? 'bg-green-900 text-white shadow' 
                        : 'hover:bg-white hover:text-green-700' }}">
            <i class="fa-solid fa-house"></i> <span>Accueil</span>
        </a>

        <a href="{{ route('mes.formations') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg transition 
                  {{ request()->routeIs('mes.formations') 
                        ? 'bg-green-900 text-white shadow' 
                        : 'hover:bg-white hover:text-green-700' }}">
            <i class="fa-solid fa-book-open"></i> <span>Mes formations</span>
        </a>

        <a href="{{ route('forums.index') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg transition 
                  {{ request()->routeIs('forums.index') 
                        ? 'bg-green-900 text-white shadow' 
                        : 'hover:bg-white hover:text-green-700' }}">
            <i class="fa-regular fa-comments"></i> <span>Forums</span>
        </a>

        {{-- ✅ Profil --}}
        <a href="{{ route('apprenant.profile') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg transition 
                  {{ request()->routeIs('apprenant.profile') 
                        ? 'bg-green-900 text-white shadow' 
                        : 'hover:bg-white hover:text-green-700' }}">
            <i class="fa-solid fa-user"></i> <span>Profil</span>
        </a>

        {{-- ✅ Quiz --}}
        <a href="{{ route('apprenant.quiz') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg transition 
                  {{ request()->routeIs('apprenant.quiz') 
                        ? 'bg-green-900 text-white shadow' 
                        : 'hover:bg-white hover:text-green-700' }}">
            <i class="fa-solid fa-list-check"></i> <span>Quiz</span>
        </a>

        {{-- ✅ Certificats --}}
        <a href="{{ route('apprenant.certificats') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg transition 
                  {{ request()->routeIs('apprenant.certificats') 
                        ? 'bg-green-900 text-white shadow' 
                        : 'hover:bg-white hover:text-green-700' }}">
            <i class="fa-solid fa-certificate"></i> <span>Certificats</span>
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
