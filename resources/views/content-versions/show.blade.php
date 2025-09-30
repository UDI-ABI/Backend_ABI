@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle de la Versión del Contenido</h1>
    <p><strong>ID:</strong> {{ $contentVersion->id }}</p>
    <p><strong>Versión ID:</strong> {{ $contentVersion->version_id }}</p>
    <p><strong>Contenido ID:</strong> {{ $contentVersion->content_id }}</p>
    <p><strong>Valor:</strong> {{ $contentVersion->value }}</p>
    <a href="{{ route('content-versions.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
