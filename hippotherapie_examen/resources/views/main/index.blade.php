@extends('layouts.app')
@section('title')
@section('content')

<h1>Tableau de Bord</h1>
<form method="GET" action="{{ route('main.index') }}" class="d-flex align-items-center">
    <div class="me-2 d-flex align-items-center">
        <label for="year" class="form-label me-2">Année :</label>
        <select name="year" class="form-select me-2">
            @foreach($years as $yr)
                <option value="{{ $yr }}" {{ $yr == $year ? 'selected' : '' }}>{{ $yr }}</option>
            @endforeach
        </select>
    </div>

    <div class="me-2 d-flex align-items-center">
        <label for="month" class="form-label me-2">Mois :</label>
        <select id="month" name="month" class="form-select me-2" required>
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ $i == $month ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($i)->locale('fr')->translatedFormat('F') }}
                </option>
            @endfor
        </select>
    </div>
  
    <button type="submit" class="btn btn-sm btn-primary">Afficher</button>
</form>

<canvas id="myChart"></canvas>
<script src=" https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js "></script>
<script>
      const ctx = document.getElementById('myChart').getContext('2d');
        const graphData = @json($graphData);
        const poniesNames = @json($poniesNames);

        const ponies = Object.keys(graphData).map(id => poniesNames[id]); 
        const hours = Object.values(graphData);

        const myChart = new Chart(ctx, {
            type: 'bar', 
            data: {
                labels: ponies, // Poneys sur l'axe des X
                datasets: [{
                    label: 'Heures Prestées',
                    data: hours, // Heures sur l'axe des Y
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Heures Prestées'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Poneys'
                        }
                    }
                }
            }
        });
    </script>
    
@endsection
