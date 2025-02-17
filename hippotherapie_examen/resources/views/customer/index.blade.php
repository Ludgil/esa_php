@extends('layouts.app')

@section('title', 'Gestion clientèle')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-3">Gestion clientèle</h1>
    <a href="{{route('customer.create')}}" class="btn btn-primary mb-3 mt-2">Ajouter un client</a>
</div>
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between">
        <h4 class="card-title">Liste des clients</h4>
    </div>
    <div class="card-body">
        @if (isset($customers) && count($customers) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td class="d-flex">
                            <a href="{{ route('customer.customer', $customer->id) }}" class="btn btn-sm btn-info me-2">Voir</a>
                            <a href="{{route('customer.edit', $customer->id)}}" class="btn btn-sm btn-primary me-2">Modifier</a>
                            <form action="{{route('customer.destroy', $customer->id)}}" method="post">
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
            <p class="text-muted">Il n'existe aucun client.</p>
        @endif
    </div>
</div>
@endsection
