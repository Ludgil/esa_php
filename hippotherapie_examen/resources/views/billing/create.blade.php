@extends('layouts.app')

@section('title', 'Créer des Factures')

@section('content')
<h1>Créer des Factures</h1>
@if (session('error'))
<div class="alert alert-danger">
    <ul>
        <li>{{ session('error') }}</li>
    </ul>
</div>
@endif
<form method="POST" action="{{ route('billing.store')}}">
    @csrf
    <div class="mb-3">
        <label for="year" class="form-label">Année :</label>
        <input type="number" id="year" name="year" class="form-control" required min="2000" max="2099">
    </div>

    <div class="mb-3">
        <label for="month" class="form-label">Mois :</label>
        <select id="month" name="month" class="form-select" required>
            <option value="">Sélectionner un mois</option>
            @php
                $months = [
                    1 => 'Janvier',
                    2 => 'Février',
                    3 => 'Mars',
                    4 => 'Avril',
                    5 => 'Mai',
                    6 => 'Juin',
                    7 => 'Juillet',
                    8 => 'Août',
                    9 => 'Septembre',
                    10 => 'Octobre',
                    11 => 'Novembre',
                    12 => 'Décembre',
                ];
            @endphp
            @foreach ($months as $number => $name)
                <option value="{{ $number }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Créer les Factures</button>
</form>
@endsection