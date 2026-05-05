@extends('tablar::page')

@section('title', 'Módulo de Formatos')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Módulo de Formatos</h2>
                <p class="text-muted mb-0">Gestión de formatos institucionales para proyectos de grado.</p>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row row-cards">
            {{-- Acta de Reunión --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <span class="bg-blue text-white avatar me-3">
                                <i class="ti ti-writing fs-2"></i>
                            </span>
                            <div>
                                <h3 class="card-title mb-0">Acta de Reunión</h3>
                                <p class="text-muted small mb-0">Registro de reuniones del proyecto</p>
                            </div>
                        </div>
                        <p class="text-muted">
                            Documenta las reuniones de seguimiento, acuerdos y compromisos
                            establecidos entre los participantes del proyecto.
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('formatos.acta-reunion.index') }}" class="btn btn-primary w-100">
                            <i class="ti ti-arrow-right me-1"></i> Ir al formato
                        </a>
                    </div>
                </div>
            </div>

            {{-- Formato de Ideas de Estudiante --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <span class="bg-green text-white avatar me-3">
                                <i class="ti ti-bulb fs-2"></i>
                            </span>
                            <div>
                                <h3 class="card-title mb-0">Ideas de Estudiante</h3>
                                <p class="text-muted small mb-0">Formato de propuesta de ideas</p>
                            </div>
                        </div>
                        <p class="text-muted">
                            Permite a los estudiantes registrar y presentar sus ideas de
                            proyecto ante el comité evaluador.
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('formatos.ideas-estudiante.index') }}" class="btn btn-success w-100">
                            <i class="ti ti-arrow-right me-1"></i> Ir al formato
                        </a>
                    </div>
                </div>
            </div>

            {{-- Ficha de Propuesta Docente --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <span class="bg-orange text-white avatar me-3">
                                <i class="ti ti-file-description fs-2"></i>
                            </span>
                            <div>
                                <h3 class="card-title mb-0">Ficha de Propuesta</h3>
                                <p class="text-muted small mb-0">Banco de proyectos docentes</p>
                            </div>
                        </div>
                        <p class="text-muted">
                            Permite a los profesores registrar propuestas de temas de grado
                            en el banco de proyectos institucional.
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('formatos.ficha-propuesta.index') }}" class="btn btn-warning w-100">
                            <i class="ti ti-arrow-right me-1"></i> Ir al formato
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
