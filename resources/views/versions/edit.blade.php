@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Versión</h1>

    <form action="{{ route('versions.update', $version) }}" method="POST">
        @csrf
        @method('PUT')
        @include('versions._form')
        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</div>
@endsection

