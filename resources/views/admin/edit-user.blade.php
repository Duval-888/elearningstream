@extends('layouts.dashboard')
@section('content')
<div class="container">
    <h2 class="mb-4">Modifier l'utilisateur</h2>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Informations de l'utilisateur</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="role" class="form-label">Rôle</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="apprenant" {{ $user->role == 'apprenant' ? 'selected' : '' }}>Apprenant</option>
                                <option value="formateur" {{ $user->role == 'formateur' ? 'selected' : '' }}>Formateur</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrateur</option>
                            </select>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard.admin') }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection