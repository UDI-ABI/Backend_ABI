@extends('tablar::page')

@section('title', 'Actas de Reunión')

@section('content')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">

            <div class="col">
                <h2 class="page-title">
                    Actas de Reunión
                </h2>

                <p class="text-muted mb-0">
                    Registro de actas de reuniones académicas
                </p>
            </div>

            <div class="col-auto ms-auto">
                <a href="{{ route('formatos.acta-reunion.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i>
                    Nueva Acta
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
                    Listado de Actas
                </h3>
            </div>

            <div class="table-responsive">
                <table class="table table-vcenter card-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Investigador</th>
                            <th>Grupo</th>
                            <th>Programa</th>
                            <th>Ubicación</th>
                            <th class="w-1">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($actas as $acta)
                            <tr>

                                <td>{{ $acta->id }}</td>

                                <td>
                                    {{ $acta->fecha_realizacion?->format('d/m/Y') ?? '—' }}
                                </td>

                                <td>
                                    {{ $acta->investigador_nombre ?? '—' }}
                                </td>

                                <td>
                                    {{ $acta->grupo_investigacion ?? '—' }}
                                </td>

                                <td>
                                    {{ $acta->programa_academico ?? '—' }}
                                </td>

                                <td>
                                    {{ $acta->medio_ubicacion ?? '—' }}
                                </td>

                                <td>
                                    <div class="btn-list flex-nowrap">

                                        <a href="{{ route('formatos.acta-reunion.show', $acta) }}"
                                           class="btn btn-sm btn-primary">
                                            Ver
                                        </a>

                                        <a href="{{ route('formatos.acta-reunion.edit', $acta) }}"
                                           class="btn btn-sm btn-warning">
                                            Editar
                                        </a>

                                        <form action="{{ route('formatos.acta-reunion.destroy', $acta) }}"
                                              method="POST"
                                              style="display:inline-block;"
                                              onsubmit="return confirm('¿Desea eliminar esta acta?')">

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
                                <td colspan="7" class="text-center">
                                    No hay actas registradas
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            <div class="card-footer">
                {{ $actas->links() }}
            </div>

        </div>

    </div>
</div>

@endsection