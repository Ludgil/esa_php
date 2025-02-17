@extends('layouts.app')

@section('title', 'Modifier un client')

@section('content')

<h1 class="text-center">Modifier un client</h1>
<div class="row justify-content-center">
    <div class="col-md-6">
        <form action="{{ route('customer.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nom du client</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control" 
                    value="{{ old('name', $customer->name) }}" 
                    required>
            </div>

          
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    value="{{ old('email', $customer->email) }}">
            </div>

     
            <div class="mb-3">
                <label for="street" class="form-label">Rue</label>
                <input 
                    type="text" 
                    id="street" 
                    name="street" 
                    class="form-control" 
                    value="{{ old('street', $customer->street) }}">
            </div>

     
            <div class="mb-3">
                <label for="number" class="form-label">Numéro</label>
                <input 
                    type="text" 
                    id="number" 
                    name="number" 
                    class="form-control" 
                    value="{{ old('number', $customer->number) }}">
            </div>

         
            <div class="mb-3">
                <label for="postal_code" class="form-label">Code Postal</label>
                <input 
                    type="text" 
                    id="postal_code" 
                    name="postal_code" 
                    class="form-control" 
                    value="{{ old('postal_code', $customer->postal_code) }}">
            </div>

   
            <div class="mb-3">
                <label for="city" class="form-label">Ville</label>
                <input 
                    type="text" 
                    id="city" 
                    name="city" 
                    class="form-control" 
                    value="{{ old('city', $customer->city) }}">
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Téléphone</label>
                <input 
                    type="text" 
                    id="phone" 
                    name="phone" 
                    class="form-control" 
                    value="{{ old('phone', $customer->phone) }}">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('customer.index') }}" class="btn btn-secondary">Retour</a>
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</div>

@endsection