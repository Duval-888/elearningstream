<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>@yield('title', 'Dashboard - E-learning')</title>

    {{-- Tailwind CDN (simple et rapide) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome (icônes) --}}
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- (si tu utilises Vite pour tes assets, on le laisse) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

<div class="min-h-screen flex">
    {{-- Sidebar fixe / statique --}}
    <aside class="w-64 bg-green-700 text-white fixed inset-y-0 left-0 shadow-lg">
        @include('partials.sidebar')
    </aside>

    {{-- Contenu principal (avec marge à gauche = largeur du sidebar) --}}
    <main class="flex-1 ml-64">
        {{-- (optionnel) barre supérieure --}}
        <header class="sticky top-0 bg-white border-b border-gray-200 px-6 py-3 z-10">
            <h1 class="text-lg font-semibold">@yield('title')</h1>
        </header>

        <div class="px-6 py-6">
            @yield('content')
        </div>
    </main>
</div>

</body>
</html>
