<x-layout :title="'Connexion'" :hideNavbar="true" :hideFooter="true">
  <div class="d-flex justify-content-center align-items-center vh-100 bg-dark">
    <div class="bg-white p-5 rounded shadow" style="width: 100%; max-width: 400px;">
      <div class="text-center mb-4">
        <h2>Connexion</h2>
      </div>

      <div class="d-flex justify-content-center mb-3">
        <a href="#" class="btn btn-primary me-2"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="btn btn-dark me-2"><i class="fab fa-github"></i></a>
        <a href="#" class="btn btn-danger"><i class="fab fa-google"></i></a>
      </div>

      <hr class="my-3">

     <form action="{{ route('connexion') }}" method="POST">
  @csrf

  <div class="mb-3">
    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
  </div>

  <div class="mb-3">
    <input type="password" name="password" class="form-control" placeholder="Password" required>
  </div>

  <button type="submit" class="btn btn-danger w-100">Se connecter</button>

  <div class="text-center mt-3">
    <a href="#">Mot de passe oublié ?</a>
  </div>

  @if (errors->any())
    <ul class="mt-3 px-3 py-2 bg-light border rounded">
      @foreach (errors->all() as error)
        <li class="text-danger">{{ $error }}</li>
      @endforeach
    </ul>
  @endif
</form>


      <div class="text-center mt-4">
        <small>Pas encore inscrit ? <a href="{{ route('show.inscription') }}">Créer un compte</a></small>
      </div>
    </div>
  </div>
</x-layout>
