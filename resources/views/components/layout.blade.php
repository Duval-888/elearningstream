@props(['title' => 'Titre par défaut', 'hideNavbar' => false, 'hideFooter' => false, 'showAuthButtons' => false])
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Accueil')</title>

  @vite('resources/css/app.css')
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
    crossorigin="anonymous"
  />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
  />
  <style>
    *{
        font-family: 'sans-serif' arial;
        box-sizing: border-box;
    }
  body::before{
    display: block;
    content: "";
    height: 60px;
  }

.nav-link {
    color: yellow !important;
    font-weight: bold;
    display: block !important;
  }
  #hope {
    margin-bottom: 15px;
    padding-bottom: 17px;
  }
  #hello{
    padding: 10px;
    margin-top: 15px;
    font-weight: bold;
    font-size: 17px;
  }
  #first-image{
    width: 100%;
    background-image: url('{{ asset('images/group-pro.jpg') }}');
    background-size: cover;
    background-position: 10% center;
    background-repeat: no-repeat;
  }
  /* Modal pop-in animation */
  .modal.fade .modal-dialog{
    transform: scale(0.96);
    transition: transform 800ms ease, opacity 800ms ease;
  }
  .modal.show .modal-dialog{
    transform: scale(1);
  }
  .modal-content{
    border-radius: 14px;
    background: #ffffff;
    color: #111827;
    border: 1px solid rgba(0,0,0,0.08);
    box-shadow: 0 8px 24px rgba(0,0,0,0.18);
  }
  .modal-body{
    overflow: visible;
  }
  /* Pretty gradient buttons */
  .btn-gradient{
    background: linear-gradient(135deg, #ffb703, #fb8500);
    border: none;
    color: #111;
    font-weight: 600;
    letter-spacing: .3px;
    box-shadow: 0 8px 20px rgba(251,133,0,.35);
  }
  .btn-gradient:hover{
    filter: brightness(1.05);
    transform: translateY(-1px);
  }
  .btn-pretty{
    background: linear-gradient(135deg, #10b981, #16a34a);
    border: none;
    color: #fff;
    font-weight: 600;
    letter-spacing: .2px;
    box-shadow: 0 8px 20px rgba(16,185,129,.35);
  }
  .btn-pretty:hover{
    filter: brightness(1.05);
    transform: translateY(-1px);
  }
/* Darker modal fields */
  .modal-header .btn-close{ filter: none; }
  .modal-content .form-label, .modal-content .col-form-label{ color: #374151; font-size: .9rem; }
  .modal-content .form-control{
    background: #ffffff;
    border: 1px solid rgba(0,0,0,0.12);
    color: #111827;
    font-size: .95rem;
    padding: .45rem .6rem;
    border-radius: 12px;
    transition: box-shadow 160ms ease, border-color 160ms ease, transform 160ms ease;
  }
  .modal-content .form-control::placeholder{ color: #6b7280; }
  .modal-content .form-control:focus{
    box-shadow: 0 0 0 .15rem rgba(16,185,129,.18), 0 8px 18px rgba(16,185,129,.12);
    border-color: #10b981;
    transform: translateY(-1px);
  }
  /* Instructor image responsiveness */
  #instructor .card-body img.rounded-circle{
    width: 140px;
    height: 140px;
    object-fit: cover;
    display: block;
    margin-left: auto;
    margin-right: auto;
  }
  @media (max-width: 992px){
    #instructor .card-body img.rounded-circle{
      width: 120px;
      height: 120px;
    }
  }
  @media (max-width: 576px){
    #instructor .card-body img.rounded-circle{
      width: 90px;
      height: 90px;
    }
  }
/* Compact modal sizing to avoid scrollbars */
  .modal-dialog{ max-width: 480px; }
  .modal-header, .modal-body, .modal-footer{ padding: 12px 16px; }
  .modal-title{ font-size: 1rem; }
  .modal-body .lead{ font-size: .95rem; }
  .modal-body .mb-3{ margin-bottom: .75rem !important; }
  .modal-footer .btn{ font-size: .95rem; padding: .5rem .9rem; }
  </style>
</head>
<body>
@if (!$hideNavbar)
  @include('partials.navbar', ['showAuthButtons' => $showAuthButtons])
@endif

  {{-- Contenu principal --}}
  <main>
    
    {{ $slot }}
  </main>
@if (!$hideFooter)
  @include('partials.footer')
@endif

  
  <script
  defer
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
  crossorigin="anonymous"
></script>
</body>
</html>
