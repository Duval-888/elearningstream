@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Bienvenue <strong>{{ auth()->user()->name }}</strong></h2>
    <p class="text-muted">Espace : <span class="badge bg-primary">{{ ucfirst(auth()->user()->role) }}</span></p>

    <ul class="list-group mb-4">

        @if(auth()->user()->role === 'apprenant')
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <i class="fas fa-graduation-cap me-2"></i> <a href="{{ route('dashboard.apprenant') }}">Dashboard Apprenant</a>
                <span class="badge bg-info">Nouveau</span>
            </li>
            <li class="list-group-item"><i class="fas fa-comments me-2"></i> <a href="{{ route('dashboard.chat') }}">Chat</a></li>
            <li class="list-group-item"><i class="fas fa-users me-2"></i> <a href="{{ route('dashboard.forums') }}">Forums</a></li>
        @endif

        @if(auth()->user()->role === 'formateur')
            <li class="list-group-item"><i class="fas fa-chalkboard-teacher me-2"></i> <a href="{{ route('dashboard.formateur') }}">Dashboard Formateur</a></li>
            <li class="list-group-item"><i class="fas fa-book me-2"></i> <a href="{{ route('dashboard.formation') }}">Formations</a></li>
            <li class="list-group-item"><i class="fas fa-video me-2"></i> <a href="{{ route('dashboard.sessionlive') }}">Sessions Live</a></li>
            <li class="list-group-item"><i class="fas fa-comments me-2"></i> <a href="{{ route('dashboard.chat') }}">Chat</a></li>
            <li class="list-group-item"><i class="fas fa-users me-2"></i> <a href="{{ route('dashboard.forums') }}">Forums</a></li>
        @endif

        @if(auth()->user()->role === 'admin')
            <li class="list-group-item"><i class="fas fa-user-shield me-2"></i> <a href="{{ route('dashboard.admin') }}">Dashboard Administrateur</a></li>
            <li class="list-group-item"><i class="fas fa-book me-2"></i> <a href="{{ route('dashboard.formation') }}">Formations</a></li>
            <li class="list-group-item"><i class="fas fa-video me-2"></i> <a href="{{ route('dashboard.sessionlive') }}">Sessions Live</a></li>
            <li class="list-group-item"><i class="fas fa-comments me-2"></i> <a href="{{ route('dashboard.chat') }}">Chat</a></li>
            <li class="list-group-item"><i class="fas fa-users me-2"></i> <a href="{{ route('dashboard.forums') }}">Forums</a></li>
        @endif

    </ul>
</div>
@endsection
