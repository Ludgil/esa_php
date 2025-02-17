@extends('layouts.app')

@section('content')
<h1 class="mb-4">Créer les Semaines</h1>
<form action="{{ route('week.store') }}" method="POST" class="row g-3">
    @csrf
    <div class="mb-3">
        <label for="year" class="form-label">Année :</label>
        <input type="number" name="year" id="year" class="form-control" placeholder="Exemple: 2024" min="2000" max="2099" required>
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary me-3">Créer les semaines</button>
        <a href="{{ route('week.index') }}" class="btn btn-primary">Retour</a>
    </div>
</form>
@endsection
