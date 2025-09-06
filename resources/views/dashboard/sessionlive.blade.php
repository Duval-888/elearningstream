@extends('layouts.dashboard')
@section('content')
<div class="container">
    <h2 class="mb-4">Gestion des Sessions Live</h2>
    <a href="{{ route('sessionlive.create') }}" class="btn btn-success mb-3">Créer une session live</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Date</th>
                <th>Formateur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sessions as $session)
            <tr>
                <td>{{ $session->title }}</td>
                <td>{{ $session->date }}</td>
                <td>{{ $session->formateur->name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('sessionlive.edit', $session->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('sessionlive.delete', $session->id) }}" method="POST" style="display:inline-block;">
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
