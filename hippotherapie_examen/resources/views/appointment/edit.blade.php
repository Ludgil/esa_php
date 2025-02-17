@extends('layouts.app')

@section('title', 'Modifier le Rendez-vous')

@section('content')

<h2 class="mb-4">Modifier le Rendez-vous</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('appointment.update', [$week->id, $appointment->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="appointment_date" class="form-label">Date du Rendez-vous</label>
        <input type="date" id="appointment_date" name="appointment_date" class="form-control" value="{{ old('appointment_date', $appointment->appointment_date) }}" required>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="customer_id" class="form-label">Client</label>
            <select name="customer_id" id="customer_id" class="form-select" required>
                <option value="" disabled selected>Sélectionnez un client</option>
                @foreach($customers as $customer)
                <option value="{{ $customer->id }}" 
                    {{ $customer->id == old('customer_id', $appointment->customer_id) ? 'selected' : '' }}>
                    {{ $customer->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="number_of_people" class="form-label">Nombre de personnes</label>
            <input type="number" name="number_of_people" id="number_of_people" class="form-control" value="{{ old('number_of_people', $appointment->number_of_people)}}" required min="1">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="start_hour" class="form-label">Heure de début</label>
            <input type="time" name="start_hour" id="start_hour" class="form-control" value="{{ old('start_hour', $appointment->start_hour) }}" required>
        </div>
        <div class="col-md-6">
            <label for="end_hour" class="form-label">Heure de fin</label>
            <input type="time" name="end_hour" id="end_hour" class="form-control" value="{{ old('end_hour', $appointment->end_hour) }}" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Prix (€)</label>
        <input type="number" name="price" id="price" class="form-control" required min="0" step="0.01" value="{{ old('price', $appointment->price)}}" required>
    </div>

    <div class="mb-3">
        <label for="ponies" class="form-label">Poneys Assignés</label>
        @foreach ($week->ponies as $pony)
        <div class="form-check">
            <input 
                class="form-check-input" 
                type="checkbox" 
                name="ponies[]" 
                id="pony{{ $pony->id }}" 
                value="{{ $pony->id }}" 
                {{ in_array($pony->id, old('ponies', $appointment->ponies->pluck('id')->toArray())) ? 'checked' : '' }}>
            <label class="form-check-label" for="pony_{{ $pony->id }}">
                {{ $pony->name }}
            </label>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('appointment.index', $week->id) }}" class="btn btn-secondary">Annuler</a>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </div>
</form>
@endsection
