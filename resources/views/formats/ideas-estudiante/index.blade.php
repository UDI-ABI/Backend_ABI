@extends('tablar::page')

@section('title', 'Ideas de Estudiante')

@section('content')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">

            <div class="col">
                <h2 class="page-title">
                    Ideas de Estudiante
                </h2>

                <p class="text-muted mb-0">
                    Registro de ideas de proyectos de grado
                </p>
            </div>

            <div class="col-auto ms-auto">
                <a href="{{ route('formatos.ideas-estudiante.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i>
                    Nueva Idea
                </a>
            </div>

        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">
                    Listado de Ideas
                </h3>
            </div>

            <div class="table-responsive">
                <table class="table table-vcenter card-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Docente</th>
                            <th>Concepto</th>
                            <th class="w-1">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($ideas as $idea)
                            <tr>

                                <td>{{ $idea->id }}</td>

                                <td>
                                    {{ $idea->titulo ?? '—' }}
                                </td>

                                <td>
                                    {{ $idea->docente ?? '—' }}
                                </td>

                                <td>
                                    @if($idea->concepto === 'aprobada')
                                        <span class="badge bg-success">Aprobada</span>
                                    @elseif($idea->concepto === 'no_aprobada')
                                        <span class="badge bg-danger">No aprobada</span>
                                    @else
                                        <span class="badge bg-secondary">Sin definir</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="btn-list flex-nowrap">

                                        <a href="{{ route('formatos.ideas-estudiante.show', $idea) }}"
                                           class="btn btn-sm btn-primary">
                                            Ver
                                        </a>

                                        <a href="{{ route('formatos.ideas-estudiante.edit', $idea) }}"
                                           class="btn btn-sm btn-warning">
                                            Editar
                                        </a>

                                        <form action="{{ route('formatos.ideas-estudiante.destroy', $idea) }}"
                                              method="POST"
                                              style="display:inline-block;"
                                              onsubmit="return confirm('¿Desea eliminar esta idea?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Eliminar
                                            </button>

                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @empty

                            <tr>
                                <td colspan="5" class="text-center">
                                    No hay ideas registradas
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            <div class="card-footer">
                {{ $ideas->links() }}
            </div>

        </div>

    </div>
</div>

@endsection
