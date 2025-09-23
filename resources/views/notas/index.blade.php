@extends('adminlte::page')

@section('title', 'Planillas de Notas por Curso')

@section('content_header')
    <div class="d-flex align-items-center justify-content-between bg-light p-2 border rounded"
        style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h4 class="m-0 pl-2" style="color: gray">
            <span class="badge bg-light border border-secondary"><strong>Planillas de Notas</strong></span>
        </h4>
        <div class="d-flex">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>

@endsection

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card p-4">
            <div class="accordion" id="accordionCursos">
                @foreach ($cursosPorAnio as $anioLectivo => $cursos)
                    <div class="accordion-item mb-2">
                        <h2 class="accordion-header" id="heading-{{ $anioLectivo }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{ $anioLectivo }}" aria-expanded="false"
                                aria-controls="collapse-{{ $anioLectivo }}">
                                Año Lectivo {{ $anioLectivo }}
                            </button>
                        </h2>
                        <div id="collapse-{{ $anioLectivo }}" class="accordion-collapse collapse"
                            aria-labelledby="heading-{{ $anioLectivo }}" data-bs-parent="#accordionCursos">
                            <div class="accordion-body">
                                <div class="row">
                                    @foreach ($cursos as $curso)
                                        <div class="col-md-3 mb-2">
                                            <a href="{{ route('notas.show', $curso->id) }}"
                                                class="btn btn-outline-primary w-100">
                                                {{ $curso->nombre }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @include('partials.footer')
    </div>


@endsection
@section('js')
    <!-- Bootstrap bundle para accordion -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
