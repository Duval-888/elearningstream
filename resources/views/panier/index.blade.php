<x-layouts.app>
<div class="container py-5">
    <h1 class="mb-4">🛒 Mon panier</h1>

    @if($formations->count())
        <ul class="list-group">
            @foreach($formations as $formation)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $formation->title }}
                    <span class="badge bg-primary rounded-pill">{{ $formation->price }} €</span>
                </li>
            @endforeach
        </ul>
        <div class="mt-4 text-end">
            <a href="#" class="btn btn-success">Valider l'inscription</a>
        </div>
    @else
        <p>Votre panier est vide.</p>
    @endif
</div>
</x-layouts.app>
