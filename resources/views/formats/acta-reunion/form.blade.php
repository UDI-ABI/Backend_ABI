<div class="row">

    {{-- INFORMACIÓN GENERAL --}}

    <div class="col-md-12">
        <h3>Información General</h3>
        <hr>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Tema / Agenda propuesta</label>
        <textarea name="tema_agenda_propuesta" class="form-control" rows="3">{{ old('tema_agenda_propuesta', $actaReunion->tema_agenda_propuesta ?? '') }}</textarea>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Nombre del investigador</label>
        <input type="text" name="investigador_nombre" class="form-control"
            value="{{ old('investigador_nombre', $actaReunion->investigador_nombre ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Grupo de investigación</label>
        <input type="text" name="grupo_investigacion" class="form-control"
            value="{{ old('grupo_investigacion', $actaReunion->grupo_investigacion ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Programa académico</label>
        <input type="text" name="programa_academico" class="form-control"
            value="{{ old('programa_academico', $actaReunion->programa_academico ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Fecha de realización</label>
        <input type="date" name="fecha_realizacion" class="form-control"
            value="{{ old('fecha_realizacion', $actaReunion->fecha_realizacion ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Medio y/o ubicación</label>
        <input type="text" name="medio_ubicacion" class="form-control"
            value="{{ old('medio_ubicacion', $actaReunion->medio_ubicacion ?? '') }}">
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">Hora inicial</label>
        <input type="time" name="hora_inicial" class="form-control"
            value="{{ old('hora_inicial', $actaReunion->hora_inicial ?? '') }}">
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">Hora finaliza</label>
        <input type="time" name="hora_finaliza" class="form-control"
            value="{{ old('hora_finaliza', $actaReunion->hora_finaliza ?? '') }}">
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Orden del día</label>
        <textarea name="orden_dia" class="form-control" rows="4">{{ old('orden_dia', $actaReunion->orden_dia ?? '') }}</textarea>
    </div>

    {{-- ASISTENTES --}}

    <div class="col-md-12">
        <h3>Asistentes</h3>
        <hr>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Listado</label>
        <textarea name="asistentes_listado" class="form-control" rows="3">{{ old('asistentes_listado', $actaReunion->asistentes_listado ?? '') }}</textarea>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Docentes asistentes</label>
        <textarea name="docentes_asistentes" class="form-control" rows="3">{{ old('docentes_asistentes', $actaReunion->docentes_asistentes ?? '') }}</textarea>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Estudiantes asistentes</label>
        <textarea name="estudiantes_asistentes" class="form-control" rows="3">{{ old('estudiantes_asistentes', $actaReunion->estudiantes_asistentes ?? '') }}</textarea>
    </div>

    {{-- DESARROLLO DE LA REUNIÓN --}}

    <div class="col-md-12">
        <h3>Desarrollo de la reunión</h3>
        <hr>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Descripción del desarrollo</label>
        <textarea name="desarrollo_reunion" class="form-control" rows="6">{{ old('desarrollo_reunion', $actaReunion->desarrollo_reunion ?? '') }}</textarea>
    </div>

    {{-- PLAN DE ACCIÓN --}}

    <div class="col-md-12">
        <h3>Plan de Acción</h3>
        <hr>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Actividades</label>
        <textarea name="actividades" class="form-control" rows="3">{{ old('actividades', $actaReunion->actividades ?? '') }}</textarea>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Responsable</label>
        <input type="text" name="responsable" class="form-control"
            value="{{ old('responsable', $actaReunion->responsable ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Fecha límite</label>
        <input type="date" name="fecha_limite" class="form-control"
            value="{{ old('fecha_limite', $actaReunion->fecha_limite ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Evidencia</label>
        <textarea name="evidencia" class="form-control" rows="3">{{ old('evidencia', $actaReunion->evidencia ?? '') }}</textarea>
    </div>

    {{-- EFICACIA --}}

    <div class="col-md-12">
        <h3>Eficacia de la reunión</h3>
        <hr>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Eficacia (%)</label>
        <input type="number" name="eficacia_reunion" class="form-control"
            value="{{ old('eficacia_reunion', $actaReunion->eficacia_reunion ?? '') }}">
    </div>

    {{-- PRÓXIMA REUNIÓN --}}

    <div class="col-md-12">
        <h3>Próxima reunión</h3>
        <hr>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Fecha</label>
        <input type="date" name="proxima_reunion_fecha" class="form-control"
            value="{{ old('proxima_reunion_fecha', $actaReunion->proxima_reunion_fecha ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Lugar</label>
        <input type="text" name="proxima_reunion_lugar" class="form-control"
            value="{{ old('proxima_reunion_lugar', $actaReunion->proxima_reunion_lugar ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Hora</label>
        <input type="time" name="proxima_reunion_hora" class="form-control"
            value="{{ old('proxima_reunion_hora', $actaReunion->proxima_reunion_hora ?? '') }}">
    </div>

    {{-- FIRMAS --}}

    <div class="col-md-12">
        <h3>Firmas</h3>
        <hr>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Preparado por</label>
        <input type="text" name="preparado_por" class="form-control"
            value="{{ old('preparado_por', $actaReunion->preparado_por ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Aprobado por</label>
        <input type="text" name="aprobado_por" class="form-control"
            value="{{ old('aprobado_por', $actaReunion->aprobado_por ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Revisado por</label>
        <input type="text" name="revisado_por" class="form-control"
            value="{{ old('revisado_por', $actaReunion->revisado_por ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Aprobado por Director</label>
        <input type="text" name="aprobado_por_director" class="form-control"
            value="{{ old('aprobado_por_director', $actaReunion->aprobado_por_director ?? '') }}">
    </div>

    {{-- BOTÓN --}}

    <div class="col-md-12 mt-4">
        <button type="submit" class="btn btn-primary">
            Guardar Acta de Reunión
        </button>

        <a href="{{ route('formatos.acta-reunion.index') }}" class="btn btn-secondary">
            Cancelar
        </a>
    </div>

</div>