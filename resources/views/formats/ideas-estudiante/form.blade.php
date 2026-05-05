<div class="row">

    {{-- INFORMACIÓN BÁSICA --}}

    <div class="col-md-12">
        <h3>Información Básica</h3>
        <hr>
    </div>

    <div class="col-md-8 mb-3">
        <label class="form-label">Título de la Idea</label>
        <input type="text" name="titulo" class="form-control"
            value="{{ old('titulo', $idea->titulo ?? '') }}"
            placeholder="Nombre tentativo del proyecto" required>
        @error('titulo')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Docente</label>
        <input type="text" name="docente" class="form-control"
            value="{{ old('docente', $idea->docente ?? '') }}"
            placeholder="Nombre del docente">
        @error('docente')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- CONCEPTO DE EVALUACIÓN --}}

    <div class="col-md-12">
        <h3>Concepto de Evaluación</h3>
        <hr>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Concepto</label>
        <select name="concepto" class="form-select">
            <option value="">Sin definir</option>
            <option value="aprobada"
                {{ old('concepto', $idea->concepto ?? '') === 'aprobada' ? 'selected' : '' }}>
                Aprobada
            </option>
            <option value="no_aprobada"
                {{ old('concepto', $idea->concepto ?? '') === 'no_aprobada' ? 'selected' : '' }}>
                No aprobada
            </option>
        </select>
        @error('concepto')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- CRITERIOS DE EVALUACIÓN --}}

    <div class="col-md-12">
        <h3>Criterios de Evaluación</h3>
        <hr>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-check">
            <input type="checkbox" name="viabilidad" class="form-check-input"
                {{ old('viabilidad', $idea->viabilidad ?? false) ? 'checked' : '' }}>
            <span class="form-check-label">Viabilidad</span>
        </label>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-check">
            <input type="checkbox" name="pertinencia" class="form-check-input"
                {{ old('pertinencia', $idea->pertinencia ?? false) ? 'checked' : '' }}>
            <span class="form-check-label">Pertinencia con el Programa</span>
        </label>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-check">
            <input type="checkbox" name="disponibilidad_docentes" class="form-check-input"
                {{ old('disponibilidad_docentes', $idea->disponibilidad_docentes ?? false) ? 'checked' : '' }}>
            <span class="form-check-label">Disponibilidad de Docentes</span>
        </label>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-check">
            <input type="checkbox" name="calidad_titulo_objetivos" class="form-check-input"
                {{ old('calidad_titulo_objetivos', $idea->calidad_titulo_objetivos ?? false) ? 'checked' : '' }}>
            <span class="form-check-label">Calidad Título vs Objetivos</span>
        </label>
    </div>

    {{-- OBSERVACIONES --}}

    <div class="col-md-12">
        <h3>Observaciones</h3>
        <hr>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Observaciones</label>
        <textarea name="observaciones" class="form-control" rows="4"
            placeholder="Observaciones generales sobre la idea">{{ old('observaciones', $idea->observaciones ?? '') }}</textarea>
        @error('observaciones')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- REGISTRO Y SEGUIMIENTO --}}

    <div class="col-md-12">
        <h3>Registro y Seguimiento</h3>
        <hr>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">N° Acta</label>
        <input type="text" name="numero_acta" class="form-control"
            value="{{ old('numero_acta', $idea->numero_acta ?? '') }}"
            placeholder="Número de acta">
        @error('numero_acta')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">VoBo. Dirección de Investigaciones</label>
        <input type="text" name="vobo" class="form-control"
            value="{{ old('vobo', $idea->vobo ?? '') }}"
            placeholder="Visto bueno">
        @error('vobo')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- BOTÓN --}}

    <div class="col-md-12 mt-4">
        <button type="submit" class="btn btn-primary">
            Guardar Idea
        </button>

        <a href="{{ route('formatos.ideas-estudiante.index') }}" class="btn btn-secondary">
            Cancelar
        </a>
    </div>

</div>
