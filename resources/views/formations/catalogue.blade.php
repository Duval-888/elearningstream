<x-layouts.app>
@php
$panierCount = session('panier') ? count(session('panier')) : 0;
@endphp

<header class="bg-gray-800 text-white py-4 mb-8 shadow">
<div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
<h1 class="text-2xl font-bold">🎓 Explorez nos formations</h1>
<nav class="flex space-x-6">
<a href="/about" class="inline-flex items-center hover:text-indigo-400">À propos</a>
<a href="/contact" class="inline-flex items-center hover:text-indigo-400">Contact</a>
<a href="/panier" class="inline-flex items-center space-x-2 hover:text-indigo-400 relative">
    <i class="fa-solid fa-cart-shopping text-xl"></i>
    @if($panierCount > 0)
        <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs font-bold rounded-full px-2 py-0.5">
            {{ $panierCount }}
        </span>
    @endif
   <a href="{{ route('panier') }}">Panier</a>

</a>
</nav>
</div>
</header>

@if($formations->count())
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
@foreach($formations as $formation)
<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
    <img src="{{ $formation->cover_image ?? 'https://via.placeholder.com/400x200' }}"
            alt="Image de la formation"
            class="w-full h-40 object-cover">

    <div class="p-4 flex flex-col h-full">
        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $formation->title }}</h3>

        <p class="text-sm text-gray-600 mb-2">
            📊 <span class="font-medium">Niveau :</span> {{ ucfirst($formation->level) }}<br>
            ⏱️ <span class="font-medium">Durée :</span> {{ $formation->duration ?? '—' }}h
        </p>

        <p class="text-green-600 font-bold text-lg mb-4">
            💰 {{ $formation->price }} €
        </p>

      <form action="{{ route('panier.add') }}" method="POST">
    @csrf
    <input type="hidden" name="formation_id" value="{{ $formation->id }}">
    <button type="submit"
            class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded transition duration-200 ease-in-out transform hover:scale-105 flex items-center justify-center space-x-2">
        <i class="fa-solid fa-cart-shopping"></i>
        <span>Suivre la formation</span>
    </button>
</form>


    </div>
</div>
@endforeach
</div>

<div class="mt-10 flex justify-center">
{{ $formations->links('vendor.pagination.tailwind') }}
</div>
@else
<div class="text-center text-gray-400 mt-10">
Aucune formation disponible pour le moment.
</div>
@endif
</x-layouts.app>
