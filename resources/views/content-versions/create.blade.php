@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Versión del Contenido</h1>

    <form action="{{ route('content-versions.store') }}" method="POST">
        @csrf
        @include('content-versions._form', ['contentVersion' => new App\Models\ContentVersion])
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection


