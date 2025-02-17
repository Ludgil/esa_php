@extends('layouts.app')

@section('content')
<h2 class="mb-4">Créer un Rendez-vous</h2>
    
<form action="{{ route('appointment.store', $week) }}" method="POST">
    @csrf

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="mb-3">
        <label for="appointment_date" class="form-label">Date du rendez-vous</label>
        <input type="date" name="appointment_date" id="appointment_date" class="form-control" 
        value="{{ old('appointment_date', $week->start_date) }}" 
        min="{{ $week->start_date }}" 
        max="{{ $week->end_date }}" 
        required>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="customer_id" class="form-label">Client</label>
            <select name="customer_id" id="customer_id" class="form-select" required>
                <option value="" disabled selected>Sélectionnez un client</option>
                @foreach($customers as $customer)
                    <option value="{{old('customer_id', $customer->id) }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="number_of_people" class="form-label">Nombre de personnes</label>
            <input type="number" name="number_of_people" id="number_of_people" class="form-control" value="{{old('number_of_people') }}" required min="1">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="start_hour" class="form-label">Heure de début</label>
            <input type="time" name="start_hour" id="start_hour" class="form-control" value="{{old('start_hour')}}" required>
        </div>
        <div class="col-md-6">
            <label for="end_hour" class="form-label">Heure de fin</label>
            <input type="time" name="end_hour" id="end_hour" class="form-control" value="{{old('end_hour')}}" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Prix (€)</label>
        <input type="number" name="price" id="price" class="form-control" value="{{old('price')}}" required min="0" step="0.01">
    </div>

    <h5>Poneys assignés</h5>
    <div class="mb-3">
        @if ($ponies->isEmpty())
            <p>Aucun poney disponible.</p>
        @else
            @foreach($ponies as $pony)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="ponies[{{ $pony->id }}]" value="{{ $pony->id }}" id="pony{{ $pony->id }}" {{ old('ponies.' . $pony->id) ? 'checked' : '' }}>
                <label class="form-check-label" for="pony{{ $pony->id }}">
                    {{ $pony->name }}
                </label>
            </div>
            @endforeach
        @endif
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary me-2">Enregistrer</button>
        <a href="{{ route('appointment.index', $week->id) }}" class="btn btn-secondary">Retour</a>
    </div>
</form>
@endsection