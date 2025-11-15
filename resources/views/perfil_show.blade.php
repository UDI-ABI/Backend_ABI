@extends('tablar::page')

@section('title', 'Perfil')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">{{ __('Perfil') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Nombre de Usuario</label>
                        <div class="form-control-plaintext">{{ auth()->user()->name }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <div class="form-control-plaintext">{{ auth()->user()->email }}</div>
                    </div>

                    @php($roles = method_exists(auth()->user(), 'getRoleNames') ? auth()->user()->getRoleNames() : collect())
                    <div class="mb-3">
                        <label class="form-label">Roles</label>
                        <div>
                            @forelse($roles as $role)
                                <span class="badge bg-blue-lt">{{ $role }}</span>
                            @empty
                                <span class="text-secondary">Sin roles asignados</span>
                            @endforelse
                        </div>
                    </div>

                    @if(auth()->user() && method_exists(auth()->user(), 'hasRole') && auth()->user()->hasRole('research_staff'))
                        <a href="{{ route('perfil.edit') }}" class="btn btn-primary">Editar perfil</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
