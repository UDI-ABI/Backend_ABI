@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle de Contenido</h1>
    <p><strong>ID:</strong> {{ $content->id }}</p>
    <p><strong>Nombre:</strong> {{ $content->name }}</p>
    <p><strong>Descripción:</strong> {{ $content->description }}</p>
    <p><strong>Roles:</strong> 
    @if(is_array($content->roles))
        {{ implode(', ', $content->roles) }}
    @else
        {{ $content->roles }}
    @endif
</p>

    <a href="{{ route('contents.index') }}" class="btn btn-secondary">Regresar</a>
</div>
@endsection
