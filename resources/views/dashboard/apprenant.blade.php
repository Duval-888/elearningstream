@extends('layouts.dashboard')
@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard Apprenant</h2>
    <div class="row">
        <div class="col-md-8">
            <h4>Catalogue de cours</h4>
            <!-- Liste des cours -->
            <div class="list-group mb-4">
                @foreach($courses as $course)
                    <a href="{{ route('courses.show', $course->id) }}" class="list-group-item list-group-item-action">
                        {{ $course->title }}
                    </a>
                @endforeach
            </div>
            <h4>Progression</h4>
            <!-- Progression, quiz, notes -->
            <div class="mb-4">
                <p>Progression globale : {{ $progression }}%</p>
                <div class="progress">
                    <div class="progress-bar" style="width: {{ $progression }}%"></div>
                </div>
            </div>
            <h4>Notifications</h4>
            <ul>
                @foreach($notifications as $notif)
                    <li>{{ $notif }}</li>
                @endforeach
            </ul>
            <h4>Forum</h4>
            <a href="#" class="btn btn-primary">Accéder au forum</a>
        </div>
        <div class="col-md-4">
            <h4>Certificats</h4>
            <ul>
                @foreach($certificates as $cert)
                    <li>{{ $cert }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection