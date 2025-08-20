<x-layout title="Accueil" :showAuthButtons="false">
<!--showcase-->
<section id="first-image" class="bg-dark text-light p-3 p-lg-0 pt-lg-3 text-center text-sm-start">
    <div class="container pb-5 pt-2">
    <div class="d-sm-flex align-items-center justify-content-between">
      <div id="hope">
        <h1>Become a <span class="text-primary"> SoftWare Engineer </span></h1>
        <h2 class="lead">
          <h2>monde en constante évolution, où le savoir est <br> au cœur de la
          compétitivité,il devient crucial<br>de garantir à chaque citoyen un
          accès équitable.</h2>
</h2>
        <a id="hello" href="{{ route('courses.index') }}" class="btn btn-danger">Decouvrir les formations</a>
      </div>
    </div>
  </div>
  </div>
</section>


<!--newsletter-->
<section class="bg-primary text-light pt-3 pb-3">
<div class="container">
  <div class="d-md-flex justify-content-between align-items-center">
    <h3 class="mb-3 mb-md-0"><p>Sign up for Newsletter</p></h3>

    <div class="input-group news-input">
      <input
        type="text"
        class="form-control"
        placeholder="Enter E-mail"
      />
      <button class="btn btn-danger btn-lg" type="button">Button</button>
    </div>
  </div>
</div>
</section>

  <!--Boxes-->
<section class="p-5">
<div class="container">
  <div class="row text-center g-4">
    <div class="col-md">
      <div class="card bg-dark text-light">
        <div class="card-body text-center">
          <div class="h1 mb-3">
            <i class="bi bi-laptop"></i>
          </div>
          <h3 class="card-title mb-3">virtual</h3>
          <p class="card-text">
            il devient crucial de garantir à chaque citoyen un accès
            équitable
          </p>
          <a href="#" class="btn btn-danger">Read More</a>
        </div>
      </div>
    </div>
    <div class="col-md">
      <div class="card bg-secondary text-light">
        <div class="card-body text-center">
          <div class="h1 mb-3">
            <i class="bi bi-person-square"></i>
          </div>
          <h3 class="card-title mb-3">hybrid</h3>
          <p class="card-text">
            il devient crucial de garantir à chaque citoyen un accès
            équitable
          </p>
          <a href="#" class="btn btn-danger">Read More</a>
    </div>
    </div>
    </div>
    <div class="col-md">
        <div class="card bg-dark text-light">
        <div class="card-body text-center">
          <div class="h1 mb-3">
            <i class="bi bi-people"></i>
          </div>
          <h3 class="card-title mb-3">Person</h3>
          <p class="card-text">
            il devient crucial de garantir à chaque citoyen un accès
            équitable
          </p>
          <a href="#" class="btn btn-danger">Read More</a>
        </div>
      </div>
</section>

<!--learn Sections-->

<section id="learn" class="p-5">
<div class="container">
  <div class="row align-items-center justify-content-between">
    <div class="col-md">
      <img src="images/back.jpg" class="img-fluid">
    </div>
    <div class="col-md p-5">
      <h2>Learn the fundamentals</h2>
      <p class="lead">
        monde en constante évolution, où le savoir est au cœur de la
        compétitivité
      </p>
      <p>
        Dans ce contexte, il est essentiel de maîtriser les compétences
        de base qui permettront à chacun de s'adapter et de prospérer.
      </p>
      <a href="" class="btn btn-light mt-3">
        <i class="bi bi-chevron-right"></i> Read More
      </a>
    </div>
  </div>
</div>
</section>

<section id="learn" class="p-5 bg-primary text-light">
<div class="container">
  <div class="row align-items-center justify-content-between">
    <div class="col-md p-5">
      <h2>Learn the Laravel</h2>
      <p class="lead">
        monde en constante évolution, où le savoir est au cœur de la
        compétitivité
      </p>
      <p>
        Dans ce contexte, il est essentiel de maîtriser les compétences
        de base qui permettront à chacun de s'adapter et de prospérer.
      </p>
      <a href="" class="btn btn-dark mt-3">
        <i class="bi bi-chevron-right"></i> Read More
      </a>
    </div>
      <div class="col-md">
      <img src="images/laravel.jpg" class="img-fluid">
    </div>
  </div>
</div>
</section>

<!--Question accordion-->
<section id="question" class="p-5">
<div class="container">
  <h2 class="text-center mb-4">
    Frequently asked Questions
  </h2>
  <div class="accordion accordion-flush" id="questions">
    <!--item 1-->
<div class="accordion-item">
<h2 class="accordion-header">
<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#question-one">
  Where exactly are you located?
</button>
</h2>
<div id="question-one" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#questions">
<div class="accordion-body">
  monde en constante évolution, où le savoir est au cœur de la
  compétitivité
</div>
</div>
</div>
<!--item 2-->
<div class="accordion-item">
<h2 class="accordion-header" id="flush-headingTwo">
<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#question-two">
  what are the different courses you offer?
</button>
</h2>
<div id="question-two" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
<div class="accordion-body">
  monde en constante évolution, où le savoir est au cœur de la
  compétitivité</div>
</div>
</div>
<!--item 3-->
<div class="accordion-item">
<h2 class="accordion-header" id="flush-headingThree">
<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#question-three">
  How much time to complete the course?
</button>
</h2>
<div id="question-three" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
<div class="accordion-body">
  monde en constante évolution, où le savoir est au cœur de la
  compétitivité
</div>
</div>
</div>

<div class="accordion-item">
<h2 class="accordion-header" id="flush-headingFour">
<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#question-four">
  How do you sign up?
</button>
</h2>
<div id="question-four" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
<div class="accordion-body">
  monde en constante évolution, où le savoir est au cœur de la
  compétitivité
</div>
</div>
</div>

<div class="accordion-item">
<h2 class="accordion-header" id="flush-headingFive">
<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#question-five">
  Will you help us find a job?
</button>
</h2>
<div id="question-five" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
<div class="accordion-body">
  monde en constante évolution, où le savoir est au cœur de la
  compétitivité
</div>
</div>
</div>
</div>
</div>
</section>

<!-- Instructors -->
<section id="instructor" class="p-5 bg-primary">
<div class="container">
  <h2 class="text-center text-white">Our Instructors</h2>
  <p class="lead text-center text-white mb-5">
    our instructors all have 3+ years of working as a web developer in the industry
  </p>
  <div class="row g-4">
    <div class="col-md-6 col-lg-3">
      <div class="card bg-light">
        <div class="card-body text-center">
          <img src="{{ asset('images/image-4.png') }}" class="img-fluid rounded-circle mb-3">
          <h3 class="card-title mb-3">John Doe</h3>
          <p class="card-text">
            monde en constante évolution, où le savoir est au cœur de la
  compétitivité
          </p>
          <a href="#" class="i bi bi-twitter text-dark mx-1"></a>
          <a href="#" class="i bi bi-facebook text-dark mx-1"></a>
          <a href="#" class="i bi bi-linkedin text-dark mx-1"></a>
          <a href="#" class="i bi bi-Instagram text-dark mx-1"></a>

        </div>
      </div>
    </div>

              <div class="col-md-6 col-lg-3">
      <div class="card bg-light">
        <div class="card-body text-center">
          <img src="images/image-3.png" class="img-fluid rounded-circle mb-3">
          <h3 class="card-title mb-3">Paul Derevan</h3>
          <p class="card-text">
            monde en constante évolution, où le savoir est au cœur de la
  compétitivité
          </p>
          <a href="#" class="i bi bi-twitter text-dark mx-1"></a>
          <a href="#" class="i bi bi-facebook text-dark mx-1"></a>
          <a href="#" class="i bi bi-linkedin text-dark mx-1"></a>
          <a href="#" class="i bi bi-instagram text-dark mx-1"></a>

        </div>
      </div>
    </div>

              <div class="col-md-6 col-lg-3">
      <div class="card bg-light">
        <div class="card-body text-center">
          <img src="images/image-6.png" class="img-fluid rounded-circle mb-3">
          <h3 class="card-title mb-3">Anna Rider</h3>
          <p class="card-text">
            monde en constante évolution, où le savoir est au cœur de la
  compétitivité
          </p>
          <a href="#" class="i bi bi-twitter text-dark mx-1"></a>
          <a href="#" class="i bi bi-facebook text-dark mx-1"></a>
          <a href="#" class="i bi bi-linkedin text-dark mx-1"></a>
          <a href="#" class="i bi bi-instagram text-dark mx-1"></a>

        </div>
      </div>
    </div>

              <div class="col-md-6 col-lg-3">
      <div class="card bg-light">
        <div class="card-body text-center">
          <img src="images/image-5.png" class="img-fluid rounded-circle mb-3">
          <h3 class="card-title mb-3">Elidja Williams</h3>
          <p class="card-text">
            monde en constante évolution, où le savoir est au cœur de la
  compétitivité
          </p>
          <a href="#" class="i bi bi-twitter text-dark mx-1"></a>
          <a href="#" class="i bi bi-facebook text-dark mx-1"></a>
          <a href="#" class="i bi bi-linkedin text-dark mx-1"></a>
          <a href="#" class="i bi bi-instagram text-dark mx-1"></a>

        </div>
      </div>
    </div>


  </div>
</div>
</section>

<!--contact & map-->
<section class="p-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-md">
        <h2 class="text-center mb-4">Contact Info</h2>
        <ul class="list-group list-group-flush lead">
          <li class="list-group-item">
            <span class="fw-bold">Main location:</span> 50 Main St, Boston MA
          </li>
          <li class="list-group-item">
            <span class="fw-bold">Enrollment phone:</span> (237) 654789453
          </li>
          <li class="list-group-item">
            <span class="fw-bold">Student phone:</span> (237) 648257945
          </li>
          <li class="list-group-item">
            <span class="fw-bold">Enrollment E-mail:</span> hey@gmail.com
          </li>
        </ul>
      </div>
      <div id="map" class="col-md">
        <img src="{{ asset('images/map.png') }}" class="img-fluid">
      </div>
    </div> <!-- end row -->
  </div>
</div> <!-- end container -->
</section>
</x-layout>








