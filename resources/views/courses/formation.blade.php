<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Web Chat App</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons (pour les icônes .bi déjà présentes en bas de page) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root{
      --brand-green: #10b981;   /* emerald-500 */
      --brand-green-600: #059669;
      --brand-green-50: #ecfdf5;
      --brand-blue:  #2563eb;   /* blue-600 */
      --brand-blue-700: #1d4ed8;
      --ink-800: #1f2937;
      --ink-600: #4b5563;
    }

    body{ color: var(--ink-800); }

    /* NAVBAR */
    .navbar-brand{
      font-weight: 700;
      color: var(--brand-green) !important;
      letter-spacing: .2px;
    }
    .navbar-light .navbar-nav .nav-link{
      color: var(--ink-800);
    }

    /* HERO */
    .chat{
      background: linear-gradient(135deg, var(--brand-green) 0%, var(--brand-blue) 100%);
      color: #fff;
      border-radius: 1.25rem;
    }
    .chat h2{ font-weight: 700; }
    .chat .btn-primary{
      background-color: var(--brand-blue);
      border-color: var(--brand-blue);
    }
    .chat .btn-primary:hover{
      background-color: var(--brand-blue-700);
      border-color: var(--brand-blue-700);
    }

    /* Boutons d’auth de la navbar */
    .btn-outline-primary{
      color: var(--brand-blue);
      border-color: var(--brand-blue);
    }
    .btn-outline-primary:hover{
      color: #fff;
      background-color: var(--brand-blue);
      border-color: var(--brand-blue);
    }
    .btn-success{
      background-color: var(--brand-green);
      border-color: var(--brand-green);
    }
    .btn-success:hover{
      background-color: var(--brand-green-600);
      border-color: var(--brand-green-600);
    }

    /* Cartes "features" / "topics" */
    .card-lite{
      background: #fff;
      border: 1px solid #e5f5ef;
      border-radius: 1rem;
      padding: 1rem;
      transition: all .25s ease;
      box-shadow: 0 2px 8px rgba(16,185,129,.06);
    }
    .card-lite:hover{
      transform: translateY(-4px);
      box-shadow: 0 8px 20px rgba(37,99,235,.15);
      border-color: rgba(37,99,235,.35);
    }

    /* Petites images et icônes */
    .icons{
      width: 28px; height: 28px; margin-right:.35rem;
      filter: hue-rotate(140deg) saturate(1.2); /* légère teinte vers vert/bleu */
    }

    /* Sections alternées */
    .section-muted{ background: var(--brand-green-50); }

    /* Images décoratives */
    .groupe-img{ min-height: 300px; position: relative; }
    .view-one{ position: absolute; right: -40px; top: 50%; transform: translateY(-50%); }

    /* Shadows */
    .shadow-soft{
      box-shadow: 0 4px 10px rgba(0,0,0,.06);
    }
  </style>
</head>
<body>

<!-- Navbar avec Auth -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand" href="#"><i class="bi bi-chat-dots-fill me-1"></i> Apprentissage</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-lg-center gap-2">
        @guest
          <li class="nav-item">
            <a href="{{ route('show.connexion') }}" class="btn btn-outline-primary me-2">
              <i class="bi bi-box-arrow-in-right me-1"></i> Connexion
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('show.inscription') }}" class="btn btn-success">
              <i class="bi bi-person-plus me-1"></i> Inscription
            </a>
          </li>
        @endguest

        @auth
          <li class="nav-item">
            <form method="POST" action="{{ route('deconnexion') }}">
              @csrf
              <button type="submit" class="btn btn-success">
                <i class="bi bi-box-arrow-right me-1"></i> Se déconnecter
              </button>
            </form>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<!-- Flash messages -->
<div class="container mt-3">
  @if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show shadow-soft" role="alert">
      {{ session('warning') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
  @endif
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-soft" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
  @endif
</div>

<!-- Hero Section -->
<section class="chat py-5 m-4 text-center text-md-start">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-md-6">
        <h2 class="mb-3">Commencez et faites avancer votre carrière</h2>
        <p class="lead mb-4">
          Identifiez votre secteur d'activité, et démarez votre apprentissage 
        </p>
        <a href="{{ route('start') }}" class="btn btn-primary btn-lg">
          <i class="bi bi-rocket-takeoff-fill me-1"></i> Get Started Now
        </a>
      </div>
      <div class="col-md-6 text-center">
        <img
          src="{{ asset('images/home-girl.jpg') }}"
          class="img-fluid rounded shadow-soft"
          alt="Illustration formation"
          loading="lazy"
        >
      </div>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="py-5">
  <div class="container text-center">
    <h2 class="mb-5 fw-bold fs-2">Features</h2>
    <div class="row g-4">
      <div class="col-md-3">
        <div class="card-lite h-100">
          <h5 class="mb-1"><img class="icons" src="images/optimization.svg" alt="">Optimization</h5>
          <p class="mb-0 text-muted">Demarez votre apprentissage</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-lite h-100">
          <h5 class="mb-1"><img class="icons" src="images/structure.svg" alt="">Structure</h5>
          <p class="mb-0 text-muted">Gagnez de la connaissance</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-lite h-100">
          <h5 class="mb-1"><img class="icons" src="images/rocket.svg" alt="">Productivity</h5>
          <p class="mb-0 text-muted">Augmentez la productivité</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-lite h-100">
          <h5 class="mb-1"><img class="icons" src="images/flow.svg" alt="">Workflow</h5>
          <p class="mb-0 text-muted">devenez un expert en gestion de projet</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Image + Text Section -->
<section class="py-5 section-muted">
  <div class="container">
    <div class="groupe-img row align-items-center">
      <div class="col-md-6">
        <img class="img-fluid rounded shadow-soft" src="images/js.jpg" alt="JS">
      </div>
      <div class="view-one col-md-6">
        <h4 class="mb-2">Java Script</h4>
        <p class="text-muted mb-0">Apprenez le javascript utilisé dans le developpement des applications web</p>
      </div>
    </div>
  </div>
</section>

<!-- Image + Text Section 2 -->
<section class="py-5">
  <div class="container">
    <div class="row align-items-center flex-md-row-reverse">
      <div class="img-two col-md-6">
        <img src="images/comp.jpg" class="img-fluid rounded shadow-soft" alt="Image 2">
      </div>
      <div class="col-md-6">
        <h4 class="mb-2">Langages de programmation</h4>
        <p class="text-muted mb-0">Devenez developpeur fullstack, aprenez ds differents langages et leurs framework</p>
      </div>
    </div>
  </div>
</section>

<!-- Topics -->
<section class="py-5 section-muted">
  <div class="container">
    <h3 class="mb-4">Other topics to explore</h3>
    <div class="row g-3">
      <div class="col-6 col-md-4"><div class="card-lite"><strong>Arts and Humanities</strong><br><small class="text-muted">338 courses</small></div></div>
      <div class="col-6 col-md-4"><div class="card-lite"><strong>Business</strong><br><small class="text-muted">1095 courses</small></div></div>
      <div class="col-6 col-md-4"><div class="card-lite"><strong>Computer Science</strong><br><small class="text-muted">668 courses</small></div></div>
      <div class="col-6 col-md-4"><div class="card-lite"><strong>Data Science</strong><br><small class="text-muted">425 courses</small></div></div>
      <div class="col-6 col-md-4"><div class="card-lite"><strong>Information Technology</strong><br><small class="text-muted">145 courses</small></div></div>
      <div class="col-6 col-md-4"><div class="card-lite"><strong>Health</strong><br><small class="text-muted">471 courses</small></div></div>
      <div class="col-6 col-md-4"><div class="card-lite"><strong>Math and Logic</strong><br><small class="text-muted">70 courses</small></div></div>
      <div class="col-6 col-md-4"><div class="card-lite"><strong>Personal Development</strong><br><small class="text-muted">137 courses</small></div></div>
      <div class="col-6 col-md-4"><div class="card-lite"><strong>Physical Science and Engineering</strong><br><small class="text-muted">413 courses</small></div></div>
    </div>
  </div>
</section>

<!-- Explore Skills -->
<div class="container my-5">
  <h4 class="mb-4">Explore Skills</h4>
  <div class="row">
    <div class="col-md-4 mb-4">
      <h5><strong>Technical Skills</strong></h5>
      <ul class="list-unstyled text-muted mb-0">
        <li>ChatGPT</li><li>Coding</li><li>Computer Science</li><li>Cybersecurity</li><li>DevOps</li>
        <li>Ethical Hacking</li><li>Generative AI</li><li>Java Programming</li><li>Python</li><li>Web Development</li>
      </ul>
    </div>
    <div class="col-md-4 mb-4">
      <h5><strong>Analytical Skills</strong></h5>
      <ul class="list-unstyled text-muted mb-0">
        <li>Artificial Intelligence</li><li>Big Data</li><li>Business Analysis</li><li>Data Analytics</li><li>Data Science</li>
        <li>Financial Modeling</li><li>Machine Learning</li><li>Microsoft Excel</li><li>Microsoft Power BI</li><li>SQL</li>
      </ul>
    </div>
    <div class="col-md-4 mb-4">
      <h5><strong>Business Skills</strong></h5>
      <ul class="list-unstyled text-muted mb-0">
        <li>Accounting</li><li>Digital Marketing</li><li>E-commerce</li><li>Finance</li><li>Google</li>
        <li>Graphic Design</li><li>IBM</li><li>Marketing</li><li>Project Management</li><li>Social Media Marketing</li>
      </ul>
    </div>
  </div>
</div>

<!-- Footer / Store badges -->
<div class="container my-5 text-center">
  <h5 class="mb-4">Learn Anywhere</h5>
  
  <div class="d-flex justify-content-center gap-4 mb-3">
    <a href="#"><i class="bi bi-facebook fs-4 text-primary"></i></a>
    <a href="#"><i class="bi bi-linkedin fs-4 text-primary"></i></a>
    <a href="#"><i class="bi bi-twitter-x fs-4 text-dark"></i></a>
    <a href="#"><i class="bi bi-youtube fs-4 text-danger"></i></a>
    <a href="#"><i class="bi bi-instagram fs-4" style="color:#d62976"></i></a>
    <a href="#"><i class="bi bi-tiktok fs-4 text-dark"></i></a>
  </div>

  <small class="text-muted">© 2025 YourSite Inc. All rights reserved.</small>
</div>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
