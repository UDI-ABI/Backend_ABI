@extends('tablar::page')

@section('title')
    Gestión de Contenidos
@endsection

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contenidos</li>
                    </ol>
                </nav>
                <h2 class="page-title d-flex align-items-center">
                    📄 Gestión de Contenidos
                    <span class="badge bg-azure ms-2">{{ $contents->total() }}</span>
                </h2>
                <p class="text-muted">Administra los contenidos educativos</p>
            </div>
            <div class="col-12 col-md-auto ms-auto d-print-none">
                <a href="{{ route('contents.create') }}" class="btn btn-primary">Nuevo Contenido</a>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                        <tr>
                            <th class="w-1">#</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Creado</th>
                            <th class="w-1">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = $contents->firstItem() ? $contents->firstItem() - 1 : 0; @endphp
                        @forelse ($contents as $content)
                            <tr>
                                <td><span class="text-muted">{{ ++$i }}</span></td>
                                <td>{{ $content->name }}</td>
                                <td>{{ Str::limit($content->description, 80) }}</td>
                                <td>{{ $content->created_at?->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('contents.show', $content->id) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                    <a href="{{ route('contents.edit', $content->id) }}" class="btn btn-sm btn-outline-success">Editar</a>
                                    <form action="{{ route('contents.destroy', $content->id) }}" method="POST" style="display:inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este contenido?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No hay contenidos registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-between">
                {{ $contents->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

