<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Web Chat App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    .chat{
      background-color: #877d7dff;
      color: white;
    }
    .img-one{
    width: 350px;
    margin-left: 60px;
    border-radius: 30px;
    padding: 30px;
    background-color: #d13a3aff;
  }
  .img-two{
    width: 450px;
    filter: none;
    -webkit-filter: none;
  }
  .groupe-img{
    width: 700px;
    height: 300px;
    margin-right: 20px;
    display: flex;
    align-items: center;
    position: relative;
  }
  .view-one{
    position: absolute;
    right: -100px;
  }
  .icons{
    width: 30px;
    height: 30px;
  }
  .shadow-sm{
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
  }
  .shadow-sm:hover{
    transform: translatey(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
  }
  
  </style>

</head>
<body>

<!-- Navbar avec Auth -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">📱 Apprentissage</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        @guest
          <li class="nav-item">
            <a href="{{ route('show.connexion') }}" class="btn btn-outline-danger me-2">Connexion</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('show.inscription') }}" class="btn btn-danger">Inscription</a>
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
<section class="chat py-5 m-4 text-center">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h2>Web Chat Communication App</h2>
        <p class="lead">Lorem ipsum dolor sit amet, consectetur. Proin cursus vitae nunc elementum parturient.</p>
        <a href="#" class="btn btn-danger rounded">Get Started Now</a>
      </div>
      <div class="img-one col-md-6">
        <img src="images/union.jpg" class="img-fluid rounded">
      </div>
    </div>
  </div>
</section>
<!-- Features Section -->
<section class="py-5">
  <div class="container text-center">
    <h2 class="mb-5 fw-bold fs-2">Features</h2>
    <div class="row g-4">
      <div class="col-md-3"><h5><img class="icons" src="images/optimization.svg"> Optimization</h5><p>Texte descriptif ici.</p></div>
      <div class="col-md-3"><h5><img class="icons" src="images/structure.svg"> Structure</h5><p>Texte descriptif ici.</p></div>
      <div class="col-md-3"><h5><img class="icons" src="images/rocket.svg"> Productivity</h5><p>Texte descriptif ici.</p></div>
      <div class="col-md-3"><h5><img class="icons" src="images/flow.svg"> Workflow</h5><p>Texte descriptif ici.</p></div>
    </div>
  </div>
</section>

<!--image and text Section-->
<section class="py-5 bg-light">
  <div class="container">
    <div class="groupe-img row">
      <div class="col-md-6">
        <img class="img-fluid rounded" src="images/js.jpg" >
      </div>
      <div class="view-one col-md-6">
        <h4>Augmentation de la productivité</h4>
        <p>Lorem opsum dolor sit amet, consecteur adi[cing elit. Vivamus uma lorem</p>
      </div>
    </div>
  </div>
</section>

<!-- Image and Text Section 2 -->
<section class="py-5">
  <div class="container">
    <div class="row align-items-center flex-md-row-reverse">
      <div class="img-two col-md-6">
        <img src="images/comp.jpg" class="img-fluid rounded" alt="Image 2">
      </div>
      <div class="col-md-6">
        <h4>Optimize work processes</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus urna lorem.</p>
      </div>
    </div>
  </div>
</section>
<!--hello-->
<section class="py-5 bg-light">
  <div class="container">
    <h3 class="mb-4">Other topics to explore</h3>
    <div class="row g-3">
      <div class="col-6 col-md-4">
        <div class="p-3 bg-white shadow-sm rounded">
          <strong>Arts and Humanities</strong><br>
          <small>338 courses</small>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="p-3 bg-white shadow-sm rounded">
          <strong>Business</strong><br>
          <small>1095 courses</small>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="p-3 bg-white shadow-sm rounded">
          <strong>Computer Science</strong><br>
          <small>668 courses</small>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="p-3 bg-white shadow-sm rounded">
          <strong>Data Science</strong><br>
          <small>425 courses</small>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="p-3 bg-white shadow-sm rounded">
          <strong>Information Technology</strong><br>
          <small>145 courses</small>
        </div>
</div>
      <div class="col-6 col-md-4">
        <div class="p-3 bg-white shadow-sm rounded">
          <strong>Health</strong><br>
          <small>471 courses</small>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="p-3 bg-white shadow-sm rounded">
          <strong>Math and Logic</strong><br>
          <small>70 courses</small>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="p-3 bg-white shadow-sm rounded">
          <strong>Personal Development</strong><br>
          <small>137 courses</small>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="p-3 bg-white shadow-sm rounded">
          <strong>Physical Science and Engineering</strong><br>
          <small>413 courses</small>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="container my-5">
  <h4 class="mb-4">Explore Skills</h4>
  <div class="row">
    <!-- Technical Skills -->
    <div class="col-md-4 mb-4">
      <h5><strong>Technical Skills</strong></h5>
      <ul class="list-unstyled">
        <li>ChatGPT</li>
        <li>Coding</li>
        <li>Computer Science</li>
        <li>Cybersecurity</li>
        <li>DevOps</li>
        <li>Ethical Hacking</li>
        <li>Generative AI</li>
        <li>Java Programming</li>
        <li>Python</li>
        <li>Web Development</li>
      </ul>
    </div>

<!-- Analytical Skills -->
    <div class="col-md-4 mb-4">
      <h5><strong>Analytical Skills</strong></h5>
      <ul class="list-unstyled">
        <li>Artificial Intelligence</li>
        <li>Big Data</li>
        <li>Business Analysis</li>
        <li>Data Analytics</li>
        <li>Data Science</li>
        <li>Financial Modeling</li>
        <li>Machine Learning</li>
        <li>Microsoft Excel</li>
        <li>Microsoft Power BI</li>
        <li>SQL</li>
      </ul>
    </div>

    <!-- Business Skills -->
    <div class="col-md-4 mb-4">
      <h5><strong>Business Skills</strong></h5>
      <ul class="list-unstyled">
        <li>Accounting</li>
        <li>Digital Marketing</li>
        <li>E-commerce</li>
        <li>Finance</li>
        <li>Google</li>
        <li>Graphic Design</li>
        <li>IBM</li>
        <li>Marketing</li>
        <li>Project Management</li>
        <li>Social Media Marketing</li>
      </ul>
    </div>
  </div>
</div>

<div class="container my-5 text-center">
  <h5 class="mb-4">Learn Anywhere</h5>
  <div class="d-flex justify-content-center gap-3 mb-4">
    <img src="appstore.png" alt="App Store" style="height: 50px;">
    <img src="googleplay.png" alt="Google Play" style="height: 50px;">
  </div>

  <div class="mb-4">
    <img src="certified.png" alt="Certified B Corp" style="height: 70px;">
  </div>

  <div class="d-flex justify-content-center gap-4 mb-3">
    <a href="#"><i class="bi bi-facebook fs-4"></i></a>
    <a href="#"><i class="bi bi-linkedin fs-4"></i></a>
    <a href="#"><i class="bi bi-twitter fs-4"></i></a>
    <a href="#"><i class="bi bi-youtube fs-4"></i></a>
    <a href="#"><i class="bi bi-instagram fs-4"></i></a>
    <a href="#"><i class="bi bi-tiktok fs-4"></i></a>
  </div>

  <small class="text-muted">© 2025 YourSite Inc. All rights reserved.</small>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
