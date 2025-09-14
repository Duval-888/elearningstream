@extends('layouts.dashboard')

@section('content')
<div class="container mt-5">
    <h2>👥 Apprenants inscrits à "{{ $formation->title }}"</h2>

    @if($inscriptions->isEmpty())
        <p>Aucun apprenant inscrit pour le moment.</p>
    @else
        <ul class="list-group">
            @foreach($inscriptions as $inscription)
                <li class="list-group-item">
                    {{ $inscription->user->name }} – inscrit le {{ $inscription->created_at->format('d/m/Y') }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
