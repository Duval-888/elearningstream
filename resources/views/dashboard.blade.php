
@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Bienvenue sur le Dashboard principal</h2>
    <p>Choisissez votre espace :</p>
    <ul class="list-group mb-4">
        <li class="list-group-item"><a href="{{ route('dashboard.apprenant') }}">Dashboard Apprenant</a></li>
        <li class="list-group-item"><a href="{{ route('dashboard.formateur') }}">Dashboard Formateur</a></li>
        <li class="list-group-item"><a href="{{ route('dashboard.admin') }}">Dashboard Administrateur</a></li>
        <li class="list-group-item"><a href="{{ route('dashboard.formation') }}">Dashboard Formation</a></li>
        <li class="list-group-item"><a href="{{ route('dashboard.sessionlive') }}">Dashboard Session Live</a></li>
    </ul>
</div>
@endsection
