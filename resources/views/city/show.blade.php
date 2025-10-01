@extends('tablar::page')

@section('title', 'Detalle de la ciudad')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('cities.index') }}">Ciudades</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $city->name }}</li>
                        </ol>
                    </nav>
                    <h2 class="page-title">{{ $city->name }}</h2>
                    <p class="text-muted mb-0">Información detallada de la ciudad y su departamento asociado.</p>
                </div>
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('cities.edit', $city) }}" class="btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>
                            Editar
                        </a>
                        <a href="{{ route('cities.index') }}" class="btn btn-outline-secondary">
                            Volver al listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información general</h3>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-muted">Nombre</dt>
                        <dd class="col-sm-8">{{ $city->name }}</dd>

                        <dt class="col-sm-4 text-muted">Departamento</dt>
                        <dd class="col-sm-8">
                            @if($city->department)
                                <a href="{{ route('departments.show', $city->department) }}">{{ $city->department->name }}</a>
                            @else
                                <span class="text-muted">No asignado</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4 text-muted">Creado</dt>
                        <dd class="col-sm-8">{{ $city->created_at?->format('d/m/Y H:i') ?? '—' }}</dd>

                        <dt class="col-sm-4 text-muted">Última actualización</dt>
                        <dd class="col-sm-8">{{ $city->updated_at?->format('d/m/Y H:i') ?? '—' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection