<x-layout title="Accueil" :showAuthButtons="false">

  {{-- Palette & helpers (optionnel, 100% Bootstrap-friendly) --}}
  <style>
    :root{
      --brand-green:#10b981;      /* vert */
      --brand-green-600:#059669;
      --brand-green-50:#ecfdf5;
      --brand-blue:#2563eb;       /* bleu */
      --brand-blue-700:#1d4ed8;
    }
    .hero-gradient{
      background: linear-gradient(135deg, var(--brand-green) 0%, var(--brand-blue) 100%);
    }
    .bg-soft-green{ background: var(--brand-green-50); }
    .btn-brand{
      background-color: var(--brand-green);
      border-color: var(--brand-green);
      color:#fff;
    }
    .btn-brand:hover{
      background-color: var(--brand-green-600);
      border-color: var(--brand-green-600);
      color:#fff;
    }
    .card-elev{
      border: 1px solid #e6f5ef;
      border-radius: 1rem;
      box-shadow: 0 4px 14px rgba(16,185,129,.08);
      transition: transform .2s ease, box-shadow .2s ease;
    }
    .card-elev:hover{
      transform: translateY(-3px);
      box-shadow: 0 10px 24px rgba(37,99,235,.15);
      border-color: rgba(37,99,235,.35);
    }
  </style>

  <!-- Showcase / Hero (vert->bleu) -->
  <section id="first-image" class="hero-gradient text-white py-5">
    <div class="container py-4">
      <div class="row align-items-center">
        <div class="col-lg-7">
          <h1 class="display-5 fw-bold mb-3">
            Devenez <span class="text-warning">Software Engineer</span>
          </h1>
          <p class="lead mb-4">
            Dans un monde en constante évolution où le savoir est au cœur de la compétitivité, 
            il est crucial de garantir à chacun un accès équitable à la formation.
          </p>
          <a id="hello" href="{{ route('courses.index') }}" class="btn btn-brand btn-lg">
            <i class="bi bi-journal-code me-2"></i> Découvrir les formations
          </a>
        </div>
        <div class="col-lg-5 text-center mt-4 mt-lg-0">
          <img src="{{ asset('images/back.jpg') }}" alt="Hero" class="img-fluid rounded shadow">
        </div>
      </div>
    </div>
  </section>

  <!-- Newsletter (bleu) -->
  <section class="bg-primary text-light py-4">
    <div class="container">
      <div class="d-md-flex justify-content-between align-items-center">
        <h3 class="mb-3 mb-md-0">Inscrivez-vous à notre newsletter</h3>
        <div class="input-group" style="max-width:520px;">
          <input type="email" class="form-control" placeholder="Votre e-mail">
          <button class="btn btn-brand" type="button">
            S’abonner
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- Boxes (cartes noires & grises, actions bleues/vertes) -->
  <section class="py-5">
    <div class="container">
      <div class="row text-center g-4">
        <div class="col-md">
          <div class="card bg-dark text-light card-elev h-100">
            <div class="card-body">
              <div class="h1 mb-3"><i class="bi bi-laptop"></i></div>
              <h3 class="card-title mb-3 text-white">Virtuel</h3>
              <p class="card-text">Garantir à chaque citoyen un accès équitable à la connaissance.</p>
              <a href="#" class="btn btn-primary">En savoir plus</a>
            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="card bg-secondary text-light card-elev h-100">
            <div class="card-body">
              <div class="h1 mb-3"><i class="bi bi-person-square"></i></div>
              <h3 class="card-title mb-3 text-white">Hybride</h3>
              <p class="card-text">Des parcours mêlant présentiel et distanciel pour progresser vite.</p>
              <a href="#" class="btn btn-brand">En savoir plus</a>
            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="card bg-dark text-light card-elev h-100">
            <div class="card-body">
              <div class="h1 mb-3"><i class="bi bi-people"></i></div>
              <h3 class="card-title mb-3 text-white">Présentiel</h3>
              <p class="card-text">Apprenez en groupe avec un mentor et des projets concrets.</p>
              <a href="#" class="btn btn-primary">En savoir plus</a>
            </div>
          </div>
        </div>
      </div>      
    </div>
  </section>

  <!-- Learn fundamentals (fond neutre) -->
  <section id="learn" class="py-5">
    <div class="container">
      <div class="row align-items-center justify-content-between">
        <div class="col-md-5">
          <img src="{{ asset('images/back.jpg') }}" class="img-fluid rounded shadow" alt="Fondamentaux">
        </div>
        <div class="col-md-6">
          <h2 class="fw-bold">Apprenez les fondamentaux</h2>
          <p class="lead">Maîtrisez les bases pour vous adapter et prospérer durablement.</p>
          <p>Des parcours structurés, des projets guidés et des retours concrets pour progresser étape par étape.</p>
          <a href="#" class="btn btn-primary mt-2">
            <i class="bi bi-chevron-right"></i> Lire plus
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Learn Laravel (fond vert très clair) -->
  <section id="learn-laravel" class="py-5 bg-soft-green">
    <div class="container">
      <div class="row align-items-center justify-content-between">
        <div class="col-md-6 order-2 order-md-1">
          <h2 class="fw-bold">Apprenez Laravel</h2>
          <p class="lead">Le framework PHP moderne pour des apps robustes et rapides.</p>
          <p>Routing, Eloquent, Blade, tests — tout pour construire des produits de niveau pro.</p>
          <a href="#" class="btn btn-brand mt-2">
            <i class="bi bi-chevron-right"></i> Lire plus
          </a>
        </div>
        <div class="col-md-5 order-1 order-md-2">
          <img src="{{ asset('images/laravel.jpg') }}" class="img-fluid rounded shadow" alt="Laravel">
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ (accordion Bootstrap) -->
  <section id="question" class="py-5">
    <div class="container">
      <h2 class="text-center mb-4">Questions fréquentes</h2>
      <div class="accordion accordion-flush" id="questions">
        <!-- item 1 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="q1h">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q1">
              Où êtes-vous situés ?
            </button>
          </h2>
          <div id="q1" class="accordion-collapse collapse" data-bs-parent="#questions">
            <div class="accordion-body">
              Nous opérons en ligne, avec des partenaires en présentiel selon les villes.
            </div>
          </div>
        </div>
        <!-- item 2 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="q2h">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q2">
              Quels types de cours proposez-vous ?
            </button>
          </h2>
          <div id="q2" class="accordion-collapse collapse" data-bs-parent="#questions">
            <div class="accordion-body">
              Développement, data, cloud, cybersécurité, design et bien plus.
            </div>
          </div>
        </div>
        <!-- item 3 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="q3h">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q3">
              Combien de temps pour terminer un parcours ?
            </button>
          </h2>
          <div id="q3" class="accordion-collapse collapse" data-bs-parent="#questions">
            <div class="accordion-body">
              Selon votre rythme : de 6 semaines intensives à 6 mois en part-time.
            </div>
          </div>
        </div>
        <!-- item 4 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="q4h">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q4">
              Comment s’inscrire ?
            </button>
          </h2>
          <div id="q4" class="accordion-collapse collapse" data-bs-parent="#questions">
            <div class="accordion-body">
              Créez un compte, choisissez une formation, et commencez immédiatement.
            </div>
          </div>
        </div>
        <!-- item 5 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="q5h">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q5">
              Aidez-vous à trouver un emploi ?
            </button>
          </h2>
          <div id="q5" class="accordion-collapse collapse" data-bs-parent="#questions">
            <div class="accordion-body">
              Oui : ateliers CV, mock interviews, réseau alumni et partenaires.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Instructors (bleu) -->
  <section id="instructor" class="py-5 bg-primary text-white">
    <div class="container">
      <h2 class="text-center">Nos formateurs</h2>
      <p class="lead text-center mb-5">Des pros avec 3+ ans d’expérience en industrie.</p>

      <div class="row g-4">
        <div class="col-md-6 col-lg-3">
          <div class="card bg-light h-100 card-elev">
            <div class="card-body text-center">
              <img src="{{ asset('images/image-4.png') }}" class="img-fluid rounded-circle mb-3" alt="">
              <h3 class="card-title mb-2">John Doe</h3>
              <p class="card-text small text-muted">Expert Frontend & UI.</p>
              <div>
                <a href="#" class="bi bi-twitter text-dark mx-1"></a>
                <a href="#" class="bi bi-facebook text-dark mx-1"></a>
                <a href="#" class="bi bi-linkedin text-dark mx-1"></a>
                <a href="#" class="bi bi-instagram text-dark mx-1"></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-3">
          <div class="card bg-light h-100 card-elev">
            <div class="card-body text-center">
              <img src="{{ asset('images/image-3.png') }}" class="img-fluid rounded-circle mb-3" alt="">
              <h3 class="card-title mb-2">Paul Derevan</h3>
              <p class="card-text small text-muted">Backend & APIs.</p>
              <div>
                <a href="#" class="bi bi-twitter text-dark mx-1"></a>
                <a href="#" class="bi bi-facebook text-dark mx-1"></a>
                <a href="#" class="bi bi-linkedin text-dark mx-1"></a>
                <a href="#" class="bi bi-instagram text-dark mx-1"></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-3">
          <div class="card bg-light h-100 card-elev">
            <div class="card-body text-center">
              <img src="{{ asset('images/image-6.png') }}" class="img-fluid rounded-circle mb-3" alt="">
              <h3 class="card-title mb-2">Anna Rider</h3>
              <p class="card-text small text-muted">Data & Machine Learning.</p>
              <div>
                <a href="#" class="bi bi-twitter text-dark mx-1"></a>
                <a href="#" class="bi bi-facebook text-dark mx-1"></a>
                <a href="#" class="bi bi-linkedin text-dark mx-1"></a>
                <a href="#" class="bi bi-instagram text-dark mx-1"></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-3">
          <div class="card bg-light h-100 card-elev">
            <div class="card-body text-center">
              <img src="{{ asset('images/image-5.png') }}" class="img-fluid rounded-circle mb-3" alt="">
              <h3 class="card-title mb-2">Elidja Williams</h3>
              <p class="card-text small text-muted">Cloud & DevOps.</p>
              <div>
                <a href="#" class="bi bi-twitter text-dark mx-1"></a>
                <a href="#" class="bi bi-facebook text-dark mx-1"></a>
                <a href="#" class="bi bi-linkedin text-dark mx-1"></a>
                <a href="#" class="bi bi-instagram text-dark mx-1"></a>
              </div>
            </div>
          </div>
        </div>

      </div> <!-- row -->
    </div>
  </section>

  <!-- Contact & map (neutre) -->
  <section class="py-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-5">
          <h2 class="mb-4">Contact</h2>
          <ul class="list-group list-group-flush lead">
            <li class="list-group-item"><span class="fw-bold">Adresse :</span> 50 Main St, Boston MA</li>
            <li class="list-group-item"><span class="fw-bold">Inscriptions :</span> (237) 654789453</li>
            <li class="list-group-item"><span class="fw-bold">Étudiants :</span> (237) 648257945</li>
            <li class="list-group-item"><span class="fw-bold">E-mail :</span> hey@gmail.com</li>
          </ul>
        </div>
        <div class="col-md-7">
          <img src="{{ asset('images/map.png') }}" class="img-fluid rounded shadow" alt="Carte">
        </div>
      </div>
    </div>
  </section>

  <!-- Footer social (sobre) -->
  <section class="py-4 bg-light">
    <div class="container text-center">
      <div class="d-flex justify-content-center gap-4 mb-2">
        <a href="#"><i class="bi bi-facebook fs-4 text-primary"></i></a>
        <a href="#"><i class="bi bi-linkedin fs-4 text-primary"></i></a>
        <a href="#"><i class="bi bi-twitter-x fs-4 text-dark"></i></a>
        <a href="#"><i class="bi bi-youtube fs-4 text-danger"></i></a>
        <a href="#"><i class="bi bi-instagram fs-4" style="color:#d62976"></i></a>
        <a href="#"><i class="bi bi-tiktok fs-4 text-dark"></i></a>
      </div>
      <small class="text-muted">© 2025 YourSite Inc. Tous droits réservés.</small>
    </div>
  </section>

</x-layout>
