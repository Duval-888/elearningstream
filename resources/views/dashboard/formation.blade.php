@extends('layouts.dashboard')
@section('content')
<div class="container">
    <h2 class="mb-4">Gestion des Formations</h2>
    <a href="{{ route('formation.create') }}" class="btn btn-success mb-3">Créer une formation</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Formateur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($formations as $formation)
            <tr>
                <td>{{ $formation->title }}</td>
                <td>{{ $formation->formateur->name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('formation.edit', $formation->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('formation.delete', $formation->id) }}" method="POST" style="display:inline-block;">
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
