<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - E-learning</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <nav class="bg-dark text-white p-3 vh-100" style="width: 250px;">
            <h4 class="mb-4">E-learning</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="{{ route('dashboard.apprenant') }}" class="nav-link text-white">Apprenant</a></li>
                <li class="nav-item mb-2"><a href="{{ route('dashboard.formateur') }}" class="nav-link text-white">Formateur</a></li>
                <li class="nav-item mb-2"><a href="{{ route('dashboard.admin') }}" class="nav-link text-white">Administrateur</a></li>
                <li class="nav-item mb-2"><a href="{{ route('dashboard.formation') }}" class="nav-link text-white">Formation</a></li>
                <li class="nav-item mb-2"><a href="{{ route('dashboard.sessionlive') }}" class="nav-link text-white">Session Live</a></li>
            </ul>
        </nav>
        <main class="flex-grow-1 p-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
