<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - E-learning</title>

    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Vite assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Sidebar styling --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            padding: 1rem;
            border-right: 1px solid #dee2e6;
            transition: transform 0.3s ease;
            z-index: 1001;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .sidebar h4 {
            font-weight: bold;
            margin-bottom: 1.5rem;
        }

        .sidebar a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            display: block;
            padding: 0.5rem 0;
            transition: color 0.2s ease;
        }

        .sidebar a:hover {
            color: #0d6efd;
        }

        .main-content {
            flex-grow: 1;
            padding: 2rem;
            background-color: #fff;
            z-index: 1;
        }

        .toggle-btn {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1002;
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            cursor: pointer;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 1000;
            display: none;
        }

        .overlay.active {
            display: block;
        }
    </style>
</head>
<body>
    {{-- ☰ Bouton pour afficher/masquer la sidebar --}}
    <button id="toggleSidebar" class="toggle-btn">☰ Menu</button>

    {{-- Overlay sombre derrière la sidebar --}}
    <div id="overlay" class="overlay"></div>

    <div class="wrapper">
        {{-- ✅ Sidebar intelligente --}}
        <div id="sidebar" class="sidebar">
            @include('partials.sidebar')
        </div>

        {{-- ✅ Contenu principal --}}
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    {{-- ✅ Script pour gérer l’ouverture/fermeture de la sidebar et overlay --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('hidden');
                overlay.classList.toggle('active');
            });

            overlay.addEventListener('click', function () {
                sidebar.classList.add('hidden');
                overlay.classList.remove('active');
            });
        });
    </script>
</body>
</html>
