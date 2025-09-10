@extends('layouts.dashboard')

@section('content')
<div class="container py-5">

    {{-- ✅ Message de bienvenue dynamique --}}
    <div class="alert alert-success text-center mb-4">
        Bonjour {{ auth()->user()->name }} 👋, bienvenue dans votre espace <strong>Administrateur</strong> !
    </div>
    <p class="text-muted text-center mb-4">Vous avez accès à toutes les fonctionnalités de gestion de la plateforme.</p>

    {{-- 🔍 Barre de recherche avec filtre --}}
    <form action="{{ route('search.global') }}" method="GET" class="mb-5">
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" name="query" class="form-control" placeholder="Rechercher...">
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select">
                    <option value="">Tous les types</option>
                    <option value="utilisateur">Utilisateurs</option>
                    <option value="cours">Cours</option>
                    <option value="session">Sessions live</option>
                    <option value="certificat">Certificats</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100" type="submit">🔍 Rechercher</button>
            </div>
        </div>
    </form>

    {{-- 📊 Blocs horizontaux --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <x-dashboard-card title="Utilisateurs" color="primary" icon="👥">
                <p>{{ $stats['total_users'] }} utilisateurs</p>
                <a href="#users" class="btn btn-outline-primary btn-sm">Gérer</a>
            </x-dashboard-card>
        </div>
        <div class="col-md-4">
            <x-dashboard-card title="Cours publiés" color="info" icon="📘">
                <p>{{ $stats['published_courses'] }} cours publiés</p>
                <a href="#courses" class="btn btn-outline-info btn-sm">Voir</a>
            </x-dashboard-card>
        </div>
        <div class="col-md-4">
            <x-dashboard-card title="Sessions Live" color="danger" icon="🎥">
                <p>{{ $stats['live_sessions'] }} sessions</p>
                <a href="#sessions" class="btn btn-outline-danger btn-sm">Consulter</a>
            </x-dashboard-card>
        </div>
    </div>

    {{-- Gestion des utilisateurs --}}
    <h2 class="text-2xl fw-bold mb-4" id="users">👥 Gestion des utilisateurs</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>
                    <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('admin.delete', $user->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
