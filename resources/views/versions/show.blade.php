@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles de Versión</h1>
    <p><strong>ID:</strong> {{ $version->id }}</p>
    <p><strong>Fecha:</strong> {{ $version->date }}</p>
    <p><strong>ID del Proyecto:</strong> {{ $version->project_id }}</p>
    <a href="{{ route('versions.index') }}" class="btn btn-secondary">Regresar</a>
</div>
@endsection

