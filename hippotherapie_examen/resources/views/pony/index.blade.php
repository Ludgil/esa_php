@extends('layouts.app')

@section('title', 'Gestion des poneys')

@section('content')


<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-3">Gestion des Poneys</h1>
    <a href="{{route('pony.create')}}" class="btn btn-primary mb-3 mt-2">Ajouter un poney</a>
</div>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between">
        <h4 class="card-title">Liste des poneys</h4>
    </div>
    <div class="card-body">
        @if (isset($ponies) && count($ponies) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ponies as $pony)
                    <tr>
                        <td>{{ $pony->name }}</td>
                        <td class="d-flex">
                            <a href="{{route('pony.edit', $pony->id)}}" class="btn btn-sm btn-primary me-2">Modifier</a>
                            <form action="{{route('pony.destroy', $pony->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">Aucun poney trouvé.</p>
        @endif
    </div>
</div>
@endsection
