@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-3">Gestion Journalière</h1>
    <a href="{{ route('week.create') }}" class="btn btn-primary mb-3 mt-2">Créer les semaines pour une année</a>
</div>
<form method="GET" action="{{ route('week.index') }}" class="mb-4">
    <div class="row align-items-center">
        <div class="col-auto">
            <label for="year" class="form-label me-2">Filtrer par année :</label>
        </div>
        <div class="col-auto">
            <select id="year" name="year" class="form-select">
                @foreach ($availableYears as $year)
                    <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-sm btn-primary">Choisir</button>
        </div>
    </div>
</form>
<table class="table">
    <thead>
        <tr>
            <th>Année</th>
            <th>Semaine</th>
            <th>Dates</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($weeks as $week)
            <tr>
                <td>{{ $week->year }}</td>
                <td>{{ $week->week_number }}</td>
                <td>{{ \Carbon\Carbon::parse($week->start_date)->format('d-m-Y')}} - {{\Carbon\Carbon::parse($week->end_date)->format('d-m-Y')}}</td>
                <td>
                    <a href="{{ route('appointment.index', $week->id) }}" class="btn btn-sm btn-info">Voir les rendez-vous</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="mt-3">
    {{  $weeks->appends(['year' => $selectedYear])->links('pagination::bootstrap-5') }}
</div>

@endsection
