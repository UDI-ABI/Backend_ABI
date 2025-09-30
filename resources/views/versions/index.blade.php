@extends('tablar::page')

@section('title')
    Gestión de Versiones
@endsection

@section('content')
    <!-- Encabezado de la página -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Versiones</li>
                        </ol>
                    </nav>

                    <!-- Título -->
                    <h2 class="page-title d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg me-2 text-primary" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 20l9 -5l-9 -5l-9 5l9 5" />
                            <path d="M12 12l9 -5l-9 -5l-9 5l9 5" />
                        </svg>
                        Gestión de Versiones
                        <span class="badge bg-azure ms-2">{{ $versions->total() }}</span>
                    </h2>
                    <p class="text-muted">Administra las versiones de cada proyecto registrado en el sistema</p>
                </div>

                <!-- Botón crear nueva versión -->
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('versions.create') }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Nueva Versión
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cuerpo principal -->
    <div class="page-body">
        <div class="container-xl">
            @if(config('tablar.display_alert'))
                @include('tablar::common.alert')
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- Tabla -->
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="w-1">#</th>
                                        <th>Proyecto</th>
                                        <th>Creado</th>
                                        <th>Actualizado</th>
                                        <th class="w-1">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($versions->count())
                                        @foreach ($versions as $version)
                                            <tr>
                                                <td><span class="text-muted">{{ $version->id }}</span></td>
                                                <td>
                                                    <div class="d-flex py-1 align-items-center">
                                                        <div class="avatar me-2 bg-green-lt">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <circle cx="12" cy="12" r="9" />
                                                                <path d="M12 7v5l3 3" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <div class="font-weight-medium">
                                                                Proyecto #{{ $version->project_id }}
                                                            </div>
                                                            <div class="text-muted">
                                                                <small>Versión creada {{ $version->created_at->diffForHumans() }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $version->created_at->format('d/m/Y H:i') }}</td>
                                                <td>{{ $version->updated_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <div class="btn-list flex-nowrap">
                                                        <a href="{{ route('versions.show', $version->id) }}" class="btn btn-sm btn-outline-primary" title="Ver">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <circle cx="12" cy="12" r="2" />
                                                                <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                                                            </svg>
                                                        </a>
                                                        <a href="{{ route('versions.edit', $version->id) }}" class="btn btn-sm btn-outline-success" title="Editar">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                <path d="M16 5l3 3" />
                                                            </svg>
                                                        </a>
                                                        <form action="{{ route('versions.destroy', $version->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar esta versión?')" title="Eliminar">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path d="M4 7h16" />
                                                                    <path d="M10 11v6" />
                                                                    <path d="M14 11v6" />
                                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                    <path d="M9 7v-2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">
                                                <div class="empty">
                                                    <div class="empty-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg text-muted" width="48" height="48" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                                            <line x1="3" y1="9" x2="21" y2="9"/>
                                                            <line x1="9" y1="21" x2="9" y2="9"/>
                                                        </svg>
                                                    </div>
                                                    <p class="empty-title">No se encontraron versiones</p>
                                                    <p class="empty-subtitle text-muted">Crea una nueva versión para comenzar a gestionar.</p>
                                                    <a href="{{ route('versions.create') }}" class="btn btn-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <line x1="12" y1="5" x2="12" y2="19"/>
                                                            <line x1="5" y1="12" x2="19" y2="12"/>
                                                        </svg>
                                                        Nueva Versión
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="card-footer d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                            <div class="text-muted">
                                @if($versions->total())
                                    Mostrando <span class="fw-semibold">{{ $versions->firstItem() }}</span> - <span class="fw-semibold">{{ $versions->lastItem() }}</span> de <span class="fw-semibold">{{ $versions->total() }}</span> versiones
                                @else
                                    No hay versiones para mostrar
                                @endif
                            </div>
                            {{ $versions->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
