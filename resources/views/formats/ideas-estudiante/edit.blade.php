@extends('tablar::page')

@section('title', 'Editar Idea #' . $ideasEstudiante->id)

@section('content')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">

            <div class="col-auto">
                <a href="{{ route('formatos.ideas-estudiante.show', $ideasEstudiante) }}" class="btn btn-ghost-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Volver
                </a>
            </div>

            <div class="col">
                <h2 class="page-title">
                    Editar Idea #{{ $ideasEstudiante->id }}
                </h2>
            </div>

        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Editar Formulario de Idea de Proyecto
                </h3>
            </div>

            <form action="{{ route('formatos.ideas-estudiante.update', $ideasEstudiante) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @include('formats.ideas-estudiante.form', ['idea' => $ideasEstudiante])

                </div>
            </form>

        </div>

    </div>
</div>

@endsection
