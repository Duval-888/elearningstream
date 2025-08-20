<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Web Chat App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar avec Auth -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">📱 WorkflowMS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        @guest
          <li class="nav-item">
            <a href="{{ route('show.connexion') }}" class="btn btn-outline-dark me-2">Connexion</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('show.inscription') }}" class="btn btn-gradient">Inscription</a>
          </li>
        @endguest

        @auth
          <li class="nav-item">
            <form method="POST" action="{{ route('deconnexion') }}">
              @csrf
              <button type="submit" class="btn btn-danger">Se déconnecter</button>
            </form>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="py-5 bg-light text-center">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h2>Web Chat Communication App</h2>
        <p class="lead">Lorem ipsum dolor sit amet, consectetur. Proin cursus vitae nunc elementum parturient.</p>
        <a href="#" class="btn btn-primary">Get Started Now</a>
      </div>
      <div class="col-md-6">
        <img src="https://via.placeholder.com/400x250" class="img-fluid rounded" alt="App Image">
      </div>
    </div>
  </div>
</section>
<!-- Features Section -->
<section class="py-5">
  <div class="container text-center">
    <h3 class="mb-5">Features</h3>
    <div class="row g-4">
      <div class="col-md-3"><h5>🔧 Optimization</h5><p>Texte descriptif ici.</p></div>
      <div class="col-md-3"><h5>📐 Structure</h5><p>Texte descriptif ici.</p></div>
      <div class="col-md-3"><h5>⚡ Productivity</h5><p>Texte descriptif ici.</p></div>
      <div class="col-md-3"><h5>📊 Workflow</h5><p>Texte descriptif ici.</p></div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
