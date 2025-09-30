@extends('tablar::page')

@section('title')
    Gestión de Content Versions
@endsection

@section('content')
    <!-- Encabezado de la página -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Navegación breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Content Versions</li>
                        </ol>
                    </nav>
                    <!-- Título principal -->
                    <h2 class="page-title d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg me-2 text-primary" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                            <line x1="9" y1="9" x2="15" y2="9" />
                            <line x1="9" y1="15" x2="15" y2="15" />
                        </svg>
                        Gestión de Content Versions
                        <span class="badge bg-azure ms-2">{{ $contentVersions->total() }}</span>
                    </h2>
                    <p class="text-muted">Administra las versiones de contenido asociadas a tus proyectos</p>
                </div>

                <!-- Botón para crear nuevo registro -->
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('content-versions.create') }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Nueva Content Version
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cuerpo principal de la página -->
    <div class="page-body">
        <div class="container-xl">
            @if(config('tablar.display_alert'))
                @include('tablar::common.alert')
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="w-1">
                                            <input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Seleccionar todos" id="select-all">
                                        </th>
                                        <th class="w-1">#</th>
                                        <th>Content ID</th>
                                        <th>Version ID</th>
                                        <th>Value</th>
                                        <th>Creado</th>
                                        <th>Actualizado</th>
                                        <th class="w-1">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = $contentVersions->firstItem() ? $contentVersions->firstItem() - 1 : 0;
                                    @endphp

                                    @if ($contentVersions->count())
                                        @foreach ($contentVersions as $cv)
                                            <tr>
                                                <td>
                                                    <input class="form-check-input m-0 align-middle content-version-checkbox" type="checkbox" value="{{ $cv->id }}" aria-label="Seleccionar content-version">
                                                </td>
                                                <td><span class="text-muted">{{ ++$i }}</span></td>
                                                <td>{{ $cv->content_id }}</td>
                                                <td>{{ $cv->version_id }}</td>
                                                <td>
                                                    <div class="text-truncate" style="max-width: 250px;" title="{{ $cv->value }}">
                                                        {{ Str::limit($cv->value, 80) }}
                                                    </div>
                                                </td>
                                                <td>{{ $cv->created_at?->diffForHumans() }}</td>
                                                <td>{{ $cv->updated_at?->diffForHumans() }}</td>
                                                <td>
                                                    <div class="btn-list flex-nowrap">
                                                        <a href="{{ route('content-versions.show', $cv->id) }}" class="btn btn-sm btn-outline-primary" title="Ver detalles">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <circle cx="12" cy="12" r="2" />
                                                                <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                                                            </svg>
                                                        </a>
                                                        <a href="{{ route('content-versions.edit', $cv->id) }}" class="btn btn-sm btn-outline-success" title="Editar">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                <path d="M16 5l3 3" />
                                                            </svg>
                                                        </a>
                                                        <form action="{{ route('content-versions.destroy', $cv->id) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que quieres eliminar este registro?')" title="Eliminar">
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
                                            <td colspan="8">
                                                <div class="empty">
                                                    <div class="empty-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg text-muted" width="48" height="48" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                                            <line x1="3" y1="9" x2="21" y2="9" />
                                                            <line x1="9" y1="21" x2="9" y2="9" />
                                                        </svg>
                                                    </div>
                                                    <p class="empty-title">No se encontraron registros</p>
                                                    <p class="empty-subtitle text-muted">Crea una nueva content version para comenzar.</p>
                                                    <a href="{{ route('content-versions.create') }}" class="btn btn-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <line x1="12" y1="5" x2="12" y2="19" />
                                                            <line x1="5" y1="12" x2="19" y2="12" />
                                                        </svg>
                                                        Nueva Content Version
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                            <div class="text-muted">
                                @if($contentVersions->total())
                                    Mostrando <span class="fw-semibold">{{ $contentVersions->firstItem() }}</span> - <span class="fw-semibold">{{ $contentVersions->lastItem() }}</span> de <span class="fw-semibold">{{ $contentVersions->total() }}</span> registros
                                @else
                                    No hay registros para mostrar
                                @endif
                            </div>
                            {{ $contentVersions->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('select-all');

        if (selectAll) {
          selectAll.addEventListener('change', function () {
            document.querySelectorAll('.content-version-checkbox').forEach(function (checkbox) {
              checkbox.checked = selectAll.checked;
            });
          });
        }
      });
    </script>
    @endpush
@endsection
