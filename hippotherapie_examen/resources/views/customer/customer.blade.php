@extends('layouts.app')

@section('title', 'Client')

@section('content')
    <h1>Détails du Client</h1>

    <div class="card mb-4">
        <div class="card-header">
            Informations du Client
        </div>
        <div class="card-body">
            <p><strong>Nom :</strong> {{ $customer->name }}</p>
            <p><strong>Email :</strong> {{ $customer->email }}</p>
            <p><strong>Adresse :</strong> {{ $customer->street }} {{ $customer->number }}</p>
            <p><strong>Code Postal :</strong> {{ $customer->postal_code }}</p>
            <p><strong>Ville :</strong> {{ $customer->city }}</p>
            <p><strong>Téléphone :</strong> {{ $customer->phone }}</p>
        </div>
    </div>

    <h2>Factures</h2>
    @if($invoices->isEmpty())
        <p>Aucune facture trouvée pour ce client.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td>{{\Carbon\Carbon::parse($invoice->month)->locale('fr')->isoFormat('MMMM YYYY') }}</td>
                        <td>{{ number_format($invoice->total_amount, 2, ',', ' ') }} €</td>
                        <td>
                            <a href="{{ route('billing.invoice', $invoice->id) }}" class="btn btn-sm btn-info me-2">Voir</a>
                            <a href="{{ route('billing.download', $invoice->id) }}" class="btn btn-primary btn-sm">Télécharger</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    </div>
@endsection
