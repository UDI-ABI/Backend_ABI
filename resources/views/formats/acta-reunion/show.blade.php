@extends('tablar::page')

@section('title', 'Acta de Reunión #' . $actaReunion->id)

@section('content')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">

            <div class="col-auto">
                <a href="{{ route('formatos.acta-reunion.index') }}" class="btn btn-ghost-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Volver
                </a>
            </div>

            <div class="col">
                <h2 class="page-title">
                    Acta de Reunión #{{ $actaReunion->id }}
                </h2>

                <p class="text-muted mb-0">
                    {{ $actaReunion->fecha_realizacion?->format('d/m/Y') ?? 'Sin fecha' }}
                </p>
            </div>

            <div class="col-auto ms-auto d-print-none">

                <a href="{{ route('formatos.acta-reunion.pdf', $actaReunion) }}"
                   class="btn btn-success"
                   target="_blank">
                    <i class="ti ti-file-download me-1"></i>
                    Exportar PDF
                </a>

                <a href="{{ route('formatos.acta-reunion.edit', $actaReunion) }}"
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
                    Detalle del Acta de Reunión
                </h3>
            </div>

            <div class="card-body">

                <dl class="row">

                    <dt class="col-sm-3">Tema / Agenda</dt>
                    <dd class="col-sm-9">{{ $actaReunion->tema_agenda_propuesta ?? '—' }}</dd>

                    <dt class="col-sm-3">Investigador</dt>
                    <dd class="col-sm-9">{{ $actaReunion->investigador_nombre ?? '—' }}</dd>

                    <dt class="col-sm-3">Grupo de Investigación</dt>
                    <dd class="col-sm-9">{{ $actaReunion->grupo_investigacion ?? '—' }}</dd>

                    <dt class="col-sm-3">Programa Académico</dt>
                    <dd class="col-sm-9">{{ $actaReunion->programa_academico ?? '—' }}</dd>

                    <dt class="col-sm-3">Fecha de Realización</dt>
                    <dd class="col-sm-9">
                        {{ $actaReunion->fecha_realizacion?->format('d/m/Y') ?? '—' }}
                    </dd>

                    <dt class="col-sm-3">Medio / Ubicación</dt>
                    <dd class="col-sm-9">{{ $actaReunion->medio_ubicacion ?? '—' }}</dd>

                    <dt class="col-sm-3">Hora Inicial</dt>
                    <dd class="col-sm-9">{{ $actaReunion->hora_inicial ?? '—' }}</dd>

                    <dt class="col-sm-3">Hora Finaliza</dt>
                    <dd class="col-sm-9">{{ $actaReunion->hora_finaliza ?? '—' }}</dd>

                    <dt class="col-sm-3">Orden del Día</dt>
                    <dd class="col-sm-9">{{ $actaReunion->orden_dia ?? '—' }}</dd>

                    <dt class="col-sm-3">Asistentes</dt>
                    <dd class="col-sm-9">{{ $actaReunion->asistentes_listado ?? '—' }}</dd>

                    <dt class="col-sm-3">Docentes Asistentes</dt>
                    <dd class="col-sm-9">{{ $actaReunion->docentes_asistentes ?? '—' }}</dd>

                    <dt class="col-sm-3">Estudiantes Asistentes</dt>
                    <dd class="col-sm-9">{{ $actaReunion->estudiantes_asistentes ?? '—' }}</dd>

                    <dt class="col-sm-3">Desarrollo de la Reunión</dt>
                    <dd class="col-sm-9">{{ $actaReunion->desarrollo_reunion ?? '—' }}</dd>

                    <dt class="col-sm-3">Plan de Acción</dt>
                    <dd class="col-sm-9">{{ $actaReunion->plan_accion ?? '—' }}</dd>

                    <dt class="col-sm-3">Eficacia (%)</dt>
                    <dd class="col-sm-9">{{ $actaReunion->eficacia_reunion ?? '—' }}</dd>

                    <dt class="col-sm-3">Próxima Reunión</dt>
                    <dd class="col-sm-9">
                        {{ $actaReunion->proxima_reunion_fecha?->format('d/m/Y') ?? '—' }}
                        /
                        {{ $actaReunion->proxima_reunion_lugar ?? '—' }}
                        /
                        {{ $actaReunion->proxima_reunion_hora ?? '—' }}
                    </dd>

                    <dt class="col-sm-3">Preparado por</dt>
                    <dd class="col-sm-9">{{ $actaReunion->preparado_por ?? '—' }}</dd>

                    <dt class="col-sm-3">Aprobado por</dt>
                    <dd class="col-sm-9">{{ $actaReunion->aprobado_por ?? '—' }}</dd>

                    <dt class="col-sm-3">Revisado por</dt>
                    <dd class="col-sm-9">{{ $actaReunion->revisado_por ?? '—' }}</dd>

                    <dt class="col-sm-3">Aprobado por Director</dt>
                    <dd class="col-sm-9">{{ $actaReunion->aprobado_por_director ?? '—' }}</dd>

                </dl>

            </div>
        </div>

    </div>
</div>

@endsection