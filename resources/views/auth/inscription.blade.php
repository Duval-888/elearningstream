<x-layout :title="'Inscription'" :hideNavbar="true" :hideFooter="true">
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="bg-white p-5 rounded shadow" style="width: 100%; max-width: 400px;">
      <h3 class="text-center mb-4">Créer un compte</h3>

      <form action="{{ route('inscription') }}" method="POST">
        @csrf

        <div class="mb-3">
          <input type="text" name="name" class="form-control" placeholder="Nom complet" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
        </div>

        <div class="mb-3">
          <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmer le mot de passe" required>
        </div>

        <!-- ✅ Sélection du rôle -->
        <div class="mb-3">
          <select name="role" class="form-select" required>
            <option value="">-- Choisir un rôle --</option>
            <option value="apprenant" {{ old('role') == 'apprenant' ? 'selected' : '' }}>Apprenant</option>
            <option value="formateur" {{ old('role') == 'formateur' ? 'selected' : '' }}>Formateur</option>
           
          </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">S'inscrire</button>

        @if ($errors->any())
        <ul class="mt-3 px-3 py-2 bg-light border rounded">
            @foreach ($errors->all() as $error)
              <li class="text-danger">{{ $error }}</li>
            @endforeach
          </ul>
        @endif
      </form>
    </div>
  </div>
</x-layout>
