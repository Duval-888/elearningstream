@extends('layouts.dashboard')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">🔍 Résultats pour : <strong>{{ $query }}</strong></h2>

    @if(empty($results) || collect($results)->flatten()->isEmpty())
        <div class="alert alert-warning">Aucun résultat trouvé.</div>
    @else
        @foreach($results as $category => $items)
            <h4 class="mt-4 text-capitalize">
                @switch($category)
                    @case('cours') 📘 Cours @break
                    @case('sessions') 🎥 Sessions Live @break
                    @case('certificats') 🏅 Certificats @break
                    @case('utilisateurs') 👥 Utilisateurs @break
                    @case('apprenants') 🎓 Apprenants @break
                    @default 📁 {{ ucfirst($category) }}
                @endswitch
                <span class="badge bg-secondary">{{ $items->count() }}</span>
            </h4>

            <ul class="list-group mb-4">
                @foreach($items as $item)
                    <li class="list-group-item">
                        @switch($category)
                            @case('cours')
                                <strong>{{ $item->title }}</strong><br>
                                <small class="text-muted">{{ $item->description }}</small>
                                <a href="{{ route('courses.show', $item->id) }}" class="btn btn-sm btn-outline-primary mt-2">Voir</a>
                                @break

                            @case('sessions')
                                <strong>{{ $item->title }}</strong><br>
                                <small class="text-muted">Prévue le {{ $item->scheduled_at->format('d M Y à H:i') }}</small>
                                <a href="{{ $item->meeting_url }}" target="_blank" class="btn btn-sm btn-outline-danger mt-2">Rejoindre</a>
                                @break

                            @case('certificats')
                                <strong>{{ $item->course->title }}</strong><br>
                                <small>Score : {{ $item->final_score }}%</small><br>
                                <a href="{{ asset($item->file_path) }}" download class="btn btn-sm btn-outline-success mt-2">📥 Télécharger</a>
                                @break

                            @case('utilisateurs')
                            @case('apprenants')
                                <strong>{{ $item->name }}</strong> — {{ $item->email }}<br>
                                <span class="badge bg-info">{{ ucfirst($item->role) }}</span>
                                @break

                            @default
                                {{ $item }}
                        @endswitch
                    </li>
                @endforeach
            </ul>
        @endforeach
    @endif
</div>
@endsection
