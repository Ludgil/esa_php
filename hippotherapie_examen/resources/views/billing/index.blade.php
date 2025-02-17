@extends('layouts.app')

@section('title', 'Gestion des factures')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Gestion des Factures</h1>
    <a href="{{ route('billing.create') }}" class="btn btn-success">Générer des Factures</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Client</th>
            <th>Mois</th>
            <th>Total (€)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($invoices as $invoice)
            <tr>
                <td>{{ $invoice->customer->name }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice->month)->locale('fr')->isoFormat('MMMM YYYY') }}</td>
                <td>{{ number_format($invoice->total_amount, 2, ',', ' ') }} €</td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('billing.invoice', $invoice->id) }}" class="btn btn-sm btn-info me-2">Voir</a>
                        <a href="{{ route('billing.download', $invoice->id) }}" class="btn btn-sm btn-secondary me-5">Télécharger</a>
                        <form method="POST" action="{{ route('billing.destroy', $invoice->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Aucune facture trouvée</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
