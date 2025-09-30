@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Contenido</h1>

    <form action="{{ route('contents.store') }}" method="POST">
        @csrf
        @include('contents._form', ['content' => new App\Models\Content])
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('contents.index') }}" class="btn btn-secondary">Atrás</a>
    </form>
</div>
@endsection
