@extends('tablar::page')

@section('title', 'Nueva Ficha de Propuesta')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <a href="{{ route('formatos.ficha-propuesta.index') }}" class="btn btn-ghost-secondary">
                    <i class="ti ti-arrow-left me-1"></i> Volver
                </a>
            </div>
            <div class="col">
                <h2 class="page-title">Nueva Ficha de Propuesta de Tema</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Datos de la Propuesta</h3>
            </div>
            <form action="{{ route('formatos.ficha-propuesta.store') }}" method="POST">
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

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label required">Título de la Propuesta</label>
                            <input type="text"
                                   name="titulo_propuesta"
                                   class="form-control @error('titulo_propuesta') is-invalid @enderror"
                                   value="{{ old('titulo_propuesta') }}"
                                   placeholder="Nombre del tema propuesto"
                                   required>
                            @error('titulo_propuesta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label required">Descripción</label>
                            <textarea name="descripcion"
                                      rows="4"
                                      class="form-control @error('descripcion') is-invalid @enderror"
                                      placeholder="Descripción del tema propuesto">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label required">Objetivos</label>
                            <textarea name="objetivos"
                                      rows="4"
                                      class="form-control @error('objetivos') is-invalid @enderror"
                                      placeholder="Objetivo general y objetivos específicos">{{ old('objetivos') }}</textarea>
                            @error('objetivos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            {{-- TODO: Convertir en <select> dinámico con los registros de la BD --}}
                            <label class="form-label required">Línea de Investigación</label>
                            <select name="linea_investigacion_id"
                                    class="form-select @error('linea_investigacion_id') is-invalid @enderror">
                                <option value="">Seleccione una línea...</option>
                                {{-- TODO: @foreach ($lineas as $linea) --}}
                                {{-- TODO:     <option value="{{ $linea->id }}">{{ $linea->name }}</option> --}}
                                {{-- TODO: @endforeach --}}
                            </select>
                            @error('linea_investigacion_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            {{-- TODO: Convertir en <select> dinámico con los registros de la BD --}}
                            <label class="form-label required">Área Temática</label>
                            <select name="area_tematica_id"
                                    class="form-select @error('area_tematica_id') is-invalid @enderror">
                                <option value="">Seleccione un área...</option>
                                {{-- TODO: @foreach ($areas as $area) --}}
                                {{-- TODO:     <option value="{{ $area->id }}">{{ $area->name }}</option> --}}
                                {{-- TODO: @endforeach --}}
                            </select>
                            @error('area_tematica_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label required">Fecha de Propuesta</label>
                            <input type="date"
                                   name="fecha_propuesta"
                                   class="form-control @error('fecha_propuesta') is-invalid @enderror"
                                   value="{{ old('fecha_propuesta') }}"
                                   required>
                            @error('fecha_propuesta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- TODO: Agregar campos adicionales del formato físico --}}
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('formatos.ficha-propuesta.index') }}" class="btn btn-ghost-secondary me-2">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="ti ti-device-floppy me-1"></i> Guardar Ficha
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
