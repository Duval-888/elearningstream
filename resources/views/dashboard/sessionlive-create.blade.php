@extends('layouts.dashboard')
@section('content')
<div class="container">
    <h2>Créer une nouvelle session live</h2>
    <form method="POST" action="#">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <button type="submit" class="btn btn-success">Créer</button>
    </form>
</div>
@endsection
