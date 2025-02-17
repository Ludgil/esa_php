@extends('layouts.app')

@section('title', 'Détail facture')

@section('content')
<h1 class="mb-4">Détails de la facture</h1>


<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        Informations sur la facture
    </div>
    <div class="card-body">
        <p><strong>Nom du client : </strong>{{ $invoice->customer->name }}</p>
        <p><strong>Adresse : </strong>{{ $invoice->customer->street }}, {{ $invoice->customer->number }} {{ $invoice->customer->postal_code }} {{ $invoice->customer->city }}</p>
        <p><strong>Adresse e-mail : </strong>{{ $invoice->customer->email }}</p>
        <p><strong>Mois de facturation : </strong>{{ \Carbon\Carbon::parse($invoice->month)->locale('fr')->isoFormat('MMMM YYYY') }}</p>
        <p><strong>Nombre total de rendez-vous : </strong>{{ $invoice->details->count() }}</p>
        <p><strong>Montant total : </strong>{{ number_format($invoice->total_amount, 2, ',', ' ') }} €</p>
    </div>
</div>


<div class="card">
    <div class="card-header bg-secondary text-white">
        Détails des rendez-vous
    </div>
    <div class="card-body">
        @if ($invoice->details->isEmpty())
            <p>Aucun rendez-vous trouvé pour cette facture.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Horaire</th>
                        <th>Poneys associés</th>
                        <th>Prix (€)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->details as $detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($detail->appointment->appointment_date)->format('d/m/Y') }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($detail->appointment->start_hour)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($detail->appointment->end_hour)->format('H:i') }}
                            </td>
                            <td>
                                @foreach ($detail->appointment->ponies as $pony)
                                {{ $pony->name }}{{ !$loop->last ? ',' : '' }}
                                @endforeach
                            </td>
                            <td>{{ number_format($detail->price, 2, ',', ' ') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('billing.index') }}" class="btn btn-secondary">Retour à la liste des factures</a>
    <a href="{{ route('billing.download', $invoice->id) }}" class="btn btn-secondary">
        Télécharger la facture en PDF
    </a>
</div>
@endsection
