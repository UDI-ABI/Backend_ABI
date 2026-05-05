@extends('tablar::page')

@section('title', 'Idea de Proyecto #' . $ideasEstudiante->id)

@section('content')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">

            <div class="col-auto">
                <a href="{{ route('formatos.ideas-estudiante.index') }}" class="btn btn-ghost-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Volver
                </a>
            </div>

            <div class="col">
                <h2 class="page-title">
                    Idea de Proyecto #{{ $ideasEstudiante->id }}
                </h2>

                <p class="text-muted mb-0">
                    {{ $ideasEstudiante->titulo }}
                </p>
            </div>

            <div class="col-auto ms-auto d-print-none">

                <a href="{{ route('formatos.ideas-estudiante.edit', $ideasEstudiante) }}"
                   class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>
                    Editar
                </a>

            </div>

        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Detalle de la Idea de Proyecto
                </h3>
            </div>

            <div class="card-body">

                <dl class="row">

                    <dt class="col-sm-3">Título</dt>
                    <dd class="col-sm-9">{{ $ideasEstudiante->titulo ?? '—' }}</dd>

                    <dt class="col-sm-3">Docente</dt>
                    <dd class="col-sm-9">{{ $ideasEstudiante->docente ?? '—' }}</dd>

                    <dt class="col-sm-3">Concepto</dt>
                    <dd class="col-sm-9">
                        @if($ideasEstudiante->concepto === 'aprobada')
                            <span class="badge bg-success">Aprobada</span>
                        @elseif($ideasEstudiante->concepto === 'no_aprobada')
                            <span class="badge bg-danger">No aprobada</span>
                        @else
                            <span class="badge bg-secondary">Sin definir</span>
                        @endif
                    </dd>

                    <dt class="col-sm-3">Viabilidad</dt>
                    <dd class="col-sm-9">{{ $ideasEstudiante->viabilidad ? 'Sí' : 'No' }}</dd>

                    <dt class="col-sm-3">Pertinencia con el Programa</dt>
                    <dd class="col-sm-9">{{ $ideasEstudiante->pertinencia ? 'Sí' : 'No' }}</dd>

                    <dt class="col-sm-3">Disponibilidad de Docentes</dt>
                    <dd class="col-sm-9">{{ $ideasEstudiante->disponibilidad_docentes ? 'Sí' : 'No' }}</dd>

                    <dt class="col-sm-3">Calidad Título vs Objetivos</dt>
                    <dd class="col-sm-9">{{ $ideasEstudiante->calidad_titulo_objetivos ? 'Sí' : 'No' }}</dd>

                    <dt class="col-sm-3">Observaciones</dt>
                    <dd class="col-sm-9">{{ $ideasEstudiante->observaciones ?? '—' }}</dd>

                    <dt class="col-sm-3">N° Acta</dt>
                    <dd class="col-sm-9">{{ $ideasEstudiante->numero_acta ?? '—' }}</dd>

                    <dt class="col-sm-3">VoBo. Dirección de Investigaciones</dt>
                    <dd class="col-sm-9">{{ $ideasEstudiante->vobo ?? '—' }}</dd>

                </dl>

            </div>
        </div>

    </div>
</div>

@endsection
