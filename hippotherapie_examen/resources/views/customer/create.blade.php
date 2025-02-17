@extends('layouts.app')

@section('title', 'Enregistrer un client')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Enregistrer un client</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('customer.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nom du client</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Nom" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label for="street" class="form-label">Rue</label>
                <input type="text" name="street" id="street" class="form-control" placeholder="Rue" value="{{ old('street') }}">
            </div>

            <div class="mb-3">
                <label for="number" class="form-label">Numéro</label>
                <input type="text" name="number" id="number" class="form-control" placeholder="Numéro de rue" value="{{ old('number') }}">
            </div>

            <div class="mb-3">
                <label for="postal_code" class="form-label">Code Postal</label>
                <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="Code Postal" value="{{ old('postal_code') }}">
            </div>

            <div class="mb-3">
                <label for="city" class="form-label">Ville</label>
                <input type="text" name="city" id="city" class="form-control" placeholder="Ville" value="{{ old('city') }}">
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Téléphone</label>
                <input type="text" name="phone" id="phone" class="form-control" placeholder="Téléphone" value="{{ old('phone') }}">
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Ajouter</button>
                <a href="{{ route('customer.index') }}" class="btn btn-primary">Retour</a>
            </div>
        </form>
    </div>
</div>
@endsection