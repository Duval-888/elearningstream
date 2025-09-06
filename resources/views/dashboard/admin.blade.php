@extends('layouts.dashboard')
@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard Administrateur</h2>
    <h4>Gestion des utilisateurs</h4>
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
    <h4>Statistiques</h4>
    <ul>
        <li>Total utilisateurs : {{ $stats['users'] ?? 0 }}</li>
        <li>Total cours : {{ $stats['courses'] ?? 0 }}</li>
        <li>Total sessions live : {{ $stats['sessions'] ?? 0 }}</li>
    </ul>
</div>
@endsection
