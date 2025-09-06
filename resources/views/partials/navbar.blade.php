<nav class="navbar navbar-expand-lg bg-dark navbar-dark py-2 fixed-top">
  <div class="container">
    <a href="#" class="navbar-brand fw-bold fs-3">
      <span class="text-danger">LE</span><span class="text-light">RN</span><span class="text-primary">EN</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu"
      aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navmenu">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a href="#learn" class="nav-link text-danger">What you'll learn</a>
        </li>
        <li class="nav-item">
          <a href="#questions" class="nav-link text-danger">Questions</a>
        </li>
        <li class="nav-item">
          <a href="#instructor" class="nav-link text-danger">Instructors</a>
        </li>
      </ul>

      @if ($showAuthButtons)
        @guest
          <div class="d-flex align-items-center gap-2">
            <a href="{{ route('show.connexion') }}" class="btn btn-outline-light">Connexion</a>
            <a href="{{ route('show.inscription') }}" class="btn btn-warning text-dark fw-semibold">Inscription</a>
          </div>
        @endguest

        @auth
          <form method="POST" action="{{ route('deconnexion') }}" class="d-flex align-items-center gap-2">
            @csrf
            <button type="submit" class="btn btn-danger">Se déconnecter</button>
          </form>
        @endauth
      @endif
    </div>
  </div>
</nav>
