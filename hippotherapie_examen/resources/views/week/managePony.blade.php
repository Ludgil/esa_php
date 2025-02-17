@extends('layouts.app')

@section('content')
<h1>Gérer les poneys pour la semaine {{ $week->week_number }} ({{ $week->year }})</h1>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{ route('week.updatePony', $week->id) }}" method="POST">
    @csrf
    <table class="table">
        <thead>
            <tr>
                <th>Poney</th>
                <th>Heures maximum</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ponies as $pony)
            <tr>
                <td>{{ $pony->name }}</td>
                <td>
                    <input type="number" name="ponies[{{ $pony->id }}]" class="form-control" 
                           value="{{ $assignedPonies->find($pony->id)?->pivot->max_work_hours ?? 0 }}">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>
@endsection