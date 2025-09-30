<!DOCTYPE html>
<html>
<head>
    <title>Validación de Usuarios</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .filters { margin-bottom: 20px; padding: 10px; background-color: #f5f5f5; }
        .pagination { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Validación de Usuarios</h1>
    
    <!-- Filtros -->
    <div class="filters">
        <form method="GET" action="">
            <div>
                <label>Búsqueda: <input type="text" name="search" value="{{ request('search') }}"></label>
            </div>
            <div>
                <label>Rol: 
                    <select name="role">
                        <option value="">Todos</option>
                        <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Estudiante</option>
                        <option value="professor" {{ request('role') == 'professor' ? 'selected' : '' }}>Profesor</option>
                        <option value="committee_leader" {{ request('role') == 'committee_leader' ? 'selected' : '' }}>Líder de Comité</option>
                        <option value="research_staff" {{ request('role') == 'research_staff' ? 'selected' : '' }}>Staff de Investigación</option>
                    </select>
                </label>
            </div>
            <div>
                <label>Estado: 
                    <select name="state">
                        <option value="">Todos</option>
                        <option value="active" {{ request('state') == 'active' ? 'selected' : '' }}>Activo</option>
                        <option value="inactive" {{ request('state') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </label>
            </div>
            <div>
                <label>Programa: 
                    <select name="city_program_id">
                        <option value="">Todos</option>
                        @foreach($cityPrograms as $program)
                            <option value="{{ $program->id }}" {{ request('city_program_id') == $program->id ? 'selected' : '' }}>
                                {{ $program->full_name }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div>
                <label>Registros por página:
                    <select name="per_page">
                        @foreach($perPageOptions as $option)
                            <option value="{{ $option }}" {{ $perPage == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div style="margin-top: 10px;">
                <button type="submit">Filtrar</button>
                <a href="">Limpiar filtros</a>
            </div>
        </form>
    </div>

    <!-- Resultados -->
    <div>
        <p>Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de {{ $users->total() }} registros</p>
        
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cédula</th>
                    <th>Teléfono</th>
                    <th>Programa</th>
                    <th>Semestre/Líder</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->state }}</td>
                    <td>
                        @if($user->details)
                            {{ $user->details->name }}
                        @endif
                    </td>
                    <td>
                        @if($user->details)
                            {{ $user->details->last_name }}
                        @endif
                    </td>
                    <td>
                        @if($user->details)
                            {{ $user->details->card_id }}
                        @endif
                    </td>
                    <td>
                        @if($user->details)
                            {{ $user->details->phone }}
                        @endif
                    </td>
                    <td>
                        @if($user->details && ($user->role == 'student' || $user->role == 'professor' || $user->role == 'committee_leader'))
                            @if(isset($user->details->cityProgram))
                                {{ $user->details->cityProgram->program->name ?? 'N/A' }} - 
                                {{ $user->details->cityProgram->city->name ?? 'N/A' }}
                            @endif
                        @endif
                    </td>
                    <td>
                        @if($user->role == 'student' && $user->details)
                            {{ $user->details->semester }}
                        @elseif(($user->role == 'professor' || $user->role == 'committee_leader') && $user->details)
                            {{ $user->details->committee_leader ? 'Sí' : 'No' }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="pagination">
        {{ $users->appends(request()->query())->links() }}
    </div>
</body>
</html>