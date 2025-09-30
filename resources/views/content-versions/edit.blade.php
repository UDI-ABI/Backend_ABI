@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Versión del Contenido</h1>

    <form action="{{ route('content-versions.update', $contentVersion->id) }}" method="POST">
    @method('PUT')
    @include('content-versions._form')
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('content-versions.index') }}" class="btn btn-secondary">Regresar</a>
    </form>

</div>
@endsection


