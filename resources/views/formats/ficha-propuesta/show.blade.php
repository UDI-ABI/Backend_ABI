@extends('tablar::page')

@section('title', 'Ficha de Propuesta #' . $fichaPropuesta->id)

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <a href="{{ route('formatos.ficha-propuesta.index') }}" class="btn btn-ghost-secondary">
                    <i class="ti ti-arrow-left me-1"></i> Volver
                </a>
            </div>
            <div class="col">
                <h2 class="page-title">{{ $fichaPropuesta->titulo_propuesta }}</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="{{ route('formatos.ficha-propuesta.edit', $fichaPropuesta) }}" class="btn btn-secondary">
                    <i class="ti ti-edit me-1"></i> Editar
                </a>
                {{-- TODO: Agregar botón de exportar a PDF --}}
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detalle de la Ficha</h3>
                <div class="card-options">
                    @php
                        $badgeClass = match($fichaPropuesta->estado) {
                            'aprobada'  => 'bg-success',
                            'rechazada' => 'bg-danger',
                            default     => 'bg-warning text-dark',
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }} fs-5">{{ ucfirst($fichaPropuesta->estado) }}</span>
                </div>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Título de la Propuesta</dt>
                    <dd class="col-sm-9">{{ $fichaPropuesta->titulo_propuesta }}</dd>

                    <dt class="col-sm-3">Fecha de Propuesta</dt>
                    <dd class="col-sm-9">{{ $fichaPropuesta->fecha_propuesta?->format('d/m/Y') ?? '—' }}</dd>

                    <dt class="col-sm-3">Descripción</dt>
                    <dd class="col-sm-9">{{ $fichaPropuesta->descripcion }}</dd>

                    <dt class="col-sm-3">Objetivos</dt>
                    <dd class="col-sm-9">{{ $fichaPropuesta->objetivos }}</dd>

                    {{-- TODO: Mostrar línea de investigación, área temática, programa --}}
                    {{-- TODO: Mostrar campos adicionales del formato físico --}}
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
