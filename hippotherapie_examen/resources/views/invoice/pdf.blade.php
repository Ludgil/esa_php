<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
        }
        .details, .items {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .details td, .items th, .items td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .items th {
            background-color: #f4f4f4;
        }
        .total {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Facture N° {{ $invoice->id }}</h1>
        <p>Date : {{ $invoice->created_at->format('d/m/Y') }}</p>
    </div>

    <table class="details">
        <tr>
            <td><strong>Client :</strong></td>
            <td>{{ $invoice->customer->name }}</td>
        </tr>
        <tr>
            <td><strong>Adresse :</strong></td>
            <td>{{ $invoice->customer->street }}, {{ $invoice->customer->number }} {{ $invoice->customer->postal_code }} {{ $invoice->customer->city }}</td>
        </tr>
        <tr>
            <td><strong>Adresse e-mail :</strong></td>
            <td>{{ $invoice->customer->email }}</td>
        </tr>
        <tr>
            <td><strong>Mois de facturation :</strong></td>
            <td>{{ \Carbon\Carbon::parse($invoice->month)->locale('fr')->isoFormat('MMMM YYYY') }}</td>
        </tr>
        <tr>
            <td><strong>Nombre total de rendez-vous :</strong></td>
            <td>{{ $invoice->details->count() }}</td>
        </tr>
    </table>

    <table class="items">
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
            @foreach($invoice->details as $detail)
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

    <div class="total">
        <h3>Total : {{ number_format($invoice->total_amount, 2, ',', ' ') }} €</h3>
    </div>
</body>
</html>
