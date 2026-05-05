@extends('tablar::page')

@section('title', 'Nueva Acta de Reunión')

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
                    Nueva Acta de Reunión
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
                    Formulario de Acta de Reunión
                </h3>
            </div>

            <form action="{{ route('formatos.acta-reunion.store') }}" method="POST">
                @csrf

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

                    @include('formats.acta-reunion.form')

                </div>
            </form>

        </div>

    </div>
</div>

@endsection