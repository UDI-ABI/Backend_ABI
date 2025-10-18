@extends('tablar::page')

@section('title', 'Detalle del proyecto')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('projects.evaluation.index') }}">Evaluación de proyectos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $project->title }}</li>
                    </ol>
                </nav>
                <h2 class="page-title d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg me-2 text-indigo" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="4" y="4" width="16" height="16" rx="2" />
                        <path d="M8 12h8M8 8h8M8 16h8" />
                    </svg>
                    {{ $project->title }}
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        {{-- Mensajes de éxito o error --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Información general</h3>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Título</dt>
                    <dd class="col-sm-9">{{ $project->title }}</dd>

                    <dt class="col-sm-3">Área temática</dt>
                    <dd class="col-sm-9">{{ $project->thematicArea->name ?? 'N/A' }}</dd>

                    <dt class="col-sm-3">Línea de investigación</dt>
                    <dd class="col-sm-9">{{ $project->thematicArea->investigationLine->name ?? 'N/A' }}</dd>

                    <dt class="col-sm-3">Estado</dt>
                    <dd class="col-sm-9"><span class="badge bg-warning-lt">{{ $project->projectStatus->name }}</span></dd>

                    <dt class="col-sm-3">Fecha</dt>
                    <dd class="col-sm-9">{{ $project->date ? \Carbon\Carbon::parse($project->date)->format('d/m/Y') : 'N/D' }}</dd>
                </dl>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">Contenidos</h3></div>
            <div class="card-body">
                @if($latestVersion)
                    @foreach($latestVersion->contentVersions as $cv)
                        <p><strong>{{ $cv->content->name }}:</strong> {{ $cv->value }}</p>
                    @endforeach
                @else
                    <p class="text-muted">Sin versiones registradas.</p>
                @endif
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">Frameworks asociados</h3></div>
            <div class="card-body">
                @forelse($project->contentFrameworkProjects as $cfp)
                    <p>
                        <strong>{{ $cfp->contentFramework->framework->name ?? 'N/A' }}</strong>
                        → {{ $cfp->contentFramework->name ?? 'N/A' }}
                    </p>
                @empty
                    <p class="text-muted">No hay frameworks asociados.</p>
                @endforelse
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">Autores</h3></div>
            <div class="card-body">
                @forelse($project->students as $s)
                    <span class="badge bg-blue-lt">{{ $s->name }} {{ $s->last_name }}</span>
                @empty
                @endforelse
                @forelse($project->professors as $p)
                    <span class="badge bg-green-lt">{{ $p->name }} {{ $p->last_name }}</span>
                @empty
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3 class="card-title">Evaluar proyecto</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ route('projects.evaluation.evaluate', $project) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Resultado de la evaluación</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <option value="Aprobado">Aprobar</option>
                            <option value="Rechazado">Rechazar</option>
                            <option value="Devuelto para corrección">Devolver para corrección</option>
                        </select>
                    </div>

                    <div class="mb-3" id="comments-field" style="display:none;">
                        <label for="comments" class="form-label">Comentarios</label>
                        <textarea name="comments" id="comments" class="form-control" rows="3" placeholder="Indica las observaciones..."></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('projects.evaluation.index') }}" class="btn btn-outline-secondary">
                            ← Volver al listado
                        </a>
                        <button type="submit" class="btn btn-primary">Enviar evaluación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('status').addEventListener('change', function() {
        const commentsField = document.getElementById('comments-field');
        commentsField.style.display = this.value === 'Devuelto para corrección' ? 'block' : 'none';
    });
</script>
@endsection
