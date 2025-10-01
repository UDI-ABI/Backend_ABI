@extends('tablar::page')

@section('title', 'Nuevo departamento')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departamentos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
                        </ol>
                    </nav>
                    <h2 class="page-title">Registrar departamento</h2>
                    <p class="text-muted mb-0">Crea un nuevo departamento para asociar ciudades y programas.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Datos del departamento</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('departments.store') }}" method="POST" novalidate>
                        @csrf
                        @include('departments.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection