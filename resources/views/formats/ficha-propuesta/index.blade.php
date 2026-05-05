@extends('tablar::page')

@section('title', 'Fichas de Propuesta Docente')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Fichas de Propuesta de Tema</h2>
                <p class="text-muted mb-0">Banco de propuestas de temas de grado de profesores.</p>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('formatos.ficha-propuesta.create') }}" class="btn btn-warning">
                    <i class="ti ti-plus me-1"></i> Nueva Ficha
                </a>
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

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Fichas</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título de la Propuesta</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            {{-- TODO: Agregar columna Programa, Línea de Investigación --}}
                            <th class="w-1">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($fichas as $ficha)
                            <tr>
                                <td>{{ $ficha->id }}</td>
                                <td>{{ $ficha->titulo_propuesta }}</td>
                                <td>{{ $ficha->fecha_propuesta?->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $badgeClass = match($ficha->estado) {
                                            'aprobada'  => 'bg-success',
                                            'rechazada' => 'bg-danger',
                                            default     => 'bg-warning text-dark',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($ficha->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-list flex-nowrap">
                                        <a href="{{ route('formatos.ficha-propuesta.show', $ficha) }}"
                                           class="btn btn-sm btn-ghost-primary">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="{{ route('formatos.ficha-propuesta.edit', $ficha) }}"
                                           class="btn btn-sm btn-ghost-secondary">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('formatos.ficha-propuesta.destroy', $ficha) }}"
                                              method="POST"
                                              onsubmit="return confirm('¿Eliminar esta ficha?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-ghost-danger">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No hay fichas registradas aún.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($fichas->hasPages())
                <div class="card-footer d-flex align-items-center">
                    {{ $fichas->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
