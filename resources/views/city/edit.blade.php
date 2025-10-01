@extends('tablar::page')

@section('title', 'Editar ciudad')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('cities.index') }}">Ciudades</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('cities.show', $city) }}">{{ $city->name }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Editar</li>
                        </ol>
                    </nav>
                    <h2 class="page-title">Editar ciudad</h2>
                    <p class="text-muted mb-0">Actualiza los datos de la ciudad seleccionada.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Datos de la ciudad</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('cities.update', $city) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')
                        @includeFirst(['city.form', 'cities.form'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection