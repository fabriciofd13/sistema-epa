@extends('adminlte::page')

@section('title', 'Gráficos por Trimestre - ' . $curso->nombre . ' (' . $curso->anio_lectivo . ')')

@section('css')
    <style>
        @media print {
            body {
                font-size: 12px;
                color: #000;
            }

            .print-header {
                text-align: center;
                margin-bottom: 20px;
            }

            .print-header img {
                max-height: 60px;
            }

            .card,
            .card-body,
            .card-header,
            .table {
                border: none !important;
                box-shadow: none !important;
            }

            .card-header {
                font-size: 16px;
                font-weight: bold;
                background-color: #f8f8f8 !important;
            }

            .table {
                width: 100%;
                border-collapse: collapse;
            }

            .table th,
            .table td {
                border: 1px solid #000 !important;
                padding: 6px !important;
            }

            .alert {
                display: none;
            }

            a[href]:after {
                content: "";
            }

            /* Ocultar botones y navbars */
            .no-print,
            .btn,
            nav,
            footer {
                display: none !important;
            }
        }
    </style>

@endsection

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded mb-3">
        <h4 class="m-0 pl-2 text-muted">
            <span class="badge bg-light">Gráficos por Trimestre</span>
            <span class="badge bg-light border border-secondary"><strong>{{ $curso->nombre }}</strong></span>
            <span class="badge bg-light border border-secondary">{{ $curso->anio_lectivo }}</span>
        </h4>
        
        <div class="no-print float-right">
            <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print"></i> Imprimir
            </button>
            <a href="{{ route('notas.show', $curso->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
            </a>            
        </div>
    </div>
@endsection

@section('content')
    <div class="print-header text-center" hidden>
        <img src="{{ public_path('/vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="Logo Escuela" height="60">
        <h4 class="mt-2">Escuela Provincial de Artes N° 1 Medardo Pantoja</h4>
    </div>
    <div class="container">
        @foreach (['primer_trimestre', 'segundo_trimestre', 'tercer_trimestre'] as $etapa)
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0 text-muted">{{ ucfirst(str_replace('_', ' ', $etapa)) }}</h5>
                </div>
                <div class="card-body">
                    @if ($datos[$etapa]['materias'])
                        <canvas id="chart-{{ $etapa }}" height="200"></canvas>
                    @else
                        <div class="alert alert-warning">Aún no hay notas cargadas para esta etapa.</div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const data = @json($datos);

            for (const etapa in data) {
                const materias = data[etapa]['materias'];

                if (!materias.length) continue;

                const labels = materias.map(m => m.nombre);

                const datasets = ['aprobados', 'desaprobados', 'aplazados'].map((categoria, index) => {
                    const colores = ['#28a745', '#ffc107', '#dc3545'];
                    return {
                        label: categoria.charAt(0).toUpperCase() + categoria.slice(1),
                        data: materias.map(m => m[categoria]),
                        backgroundColor: colores[index]
                    };
                });

                new Chart(document.getElementById(`chart-${etapa}`), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        indexAxis: 'x',
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            title: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Cantidad de Alumnos'
                                }
                            },
                            x: {
                                ticks: {
                                    autoSkip: false,
                                    maxRotation: 90,
                                    minRotation: 90
                                },
                                title: {
                                    display: true,
                                    text: 'Materias'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection
