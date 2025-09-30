@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Versión</h1>

    <form action="{{ route('versions.store') }}" method="POST">
        @csrf
        @include('versions._form', ['version' => new App\Models\Version])
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
</div>
@endsection
