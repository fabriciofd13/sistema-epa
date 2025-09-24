@extends('adminlte::page')

@section('title', 'Resumen de Notas - ' . $materia->nombre . ' - ' . $curso->nombre . ' | REGLA')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded mb-3">
        <h4 class="m-0 pl-2 text-muted">
            <span class="badge bg-light">Resumen de</span>
            <span class="badge bg-light border border-secondary"><strong>{{ $materia->nombre }}</strong></span>
            <span class="badge bg-light border border-secondary">{{ $curso->nombre }} ({{ $curso->anio_lectivo }})</span>
        </h4>
        <a href="{{ route('notas.show', $curso->id) }}" class="btn btn-outline-secondary">
            <i class="fas fa-times"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($resumen as $trimestre => $data)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="m-0">Resumen: {{ ucfirst(str_replace('_', ' ', $trimestre)) }}</h5>
                        </div>
                        <div class="card-body">
                            @if ($data['total'] > 0)
                                <div class="mb-3">
                                    <div class="alert alert-info">Total Alumnos: <strong>{{ $data['total'] }}</strong></div>
                                    <div class="alert alert-success">Aprobados: <strong>{{ $data['aprobados'] }}</strong>
                                    </div>
                                    <div class="alert alert-warning">Desaprobados (4-5):
                                        <strong>{{ $data['desaprobados'] }}</strong></div>
                                    <div class="alert alert-danger">Aplazados (1-3):
                                        <strong>{{ $data['aplazados'] }}</strong></div>
                                </div>
                                <div>
                                    <canvas id="chart-{{ $trimestre }}"></canvas>
                                </div>
                            @else
                                <div class="alert alert-warning text-center mb-0">
                                    Aún no se ingresaron notas para esta etapa.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @foreach ($resumen as $trimestre => $data)
                @if ($data['total'] > 0)
                    new Chart(document.getElementById("chart-{{ $trimestre }}"), {
                        type: 'pie',
                        data: {
                            labels: ['Aprobados', 'Desaprobados (4-5)', 'Aplazados (1-3)'],
                            datasets: [{
                                label: 'Distribución de Notas',
                                data: [
                                    {{ $data['aprobados'] }},
                                    {{ $data['desaprobados'] }},
                                    {{ $data['aplazados'] }}
                                ],
                                backgroundColor: [
                                    'rgba(40, 167, 69, 0.7)',
                                    'rgba(255, 193, 7, 0.7)',
                                    'rgba(220, 53, 69, 0.7)'
                                ],
                                borderColor: [
                                    'rgba(40, 167, 69, 1)',
                                    'rgba(255, 193, 7, 1)',
                                    'rgba(220, 53, 69, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top'
                                }
                            }
                        }
                    });
                @endif
            @endforeach
        });
    </script>
@endsection
