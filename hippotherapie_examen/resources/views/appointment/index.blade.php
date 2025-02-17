@extends('layouts.app')

@section('content')
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <h1>Rendez-vous pour la semaine {{ $week->week_number }} ({{ \Carbon\Carbon::parse($week->start_date)->locale('fr')->translatedFormat('d F Y') }} au {{ \Carbon\Carbon::parse($week->end_date)->locale('fr')->translatedFormat('d F Y') }})</h1>
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3>Poneys assignés</h3>
            <a href="{{route('week.managePony', $week->id)}}" class="btn btn-primary">Assigné un poney à la semaine</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom du poney</th>
                    <th>Heures maximum</th>
                    <th>Heures restantes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ponies as $pony)
                <tr>
                    <td>{{ $pony->name }}</td>
                    <td>{{ $pony->pivot->max_work_hours }} heures</td>
                    <td>{{ $pony->remaining_hours }} heures</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h3>Liste des rendez-vous</h3>
        <a href="{{route('appointment.create', $week->id)}}" class="btn btn-primary">Ajouter un Rendez-vous</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Client</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Prix</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d-m-Y') }}</td>
                    <td>{{ $appointment->customer->name }}</td>
                    <td>{{ $appointment->start_hour }}</td>
                    <td>{{ $appointment->end_hour }}</td>
                    <td>{{ $appointment->price }}</td>
                    <td>
                        <div class="d-flex">
                            <form action="{{ route('appointment.edit', ['week' => $week->id, 'appointment' => $appointment->id]) }}" class="me-2">
                                <button type="submit" class="btn btn-sm btn-primary me-3">Modifier</button>
                            </form>
                            <form action="{{ route('appointment.destroy', ['week' => $week->id, 'appointment' => $appointment->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('week.index') }}" class="btn btn-primary">Retour</a>
</div>
@endsection
