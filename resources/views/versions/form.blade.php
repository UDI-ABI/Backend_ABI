<div class="mb-3">
    <label for="date" class="form-label">Fecha</label>
    <input type="date" name="date" class="form-control" value="{{ old('date', $version->date ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="project_id" class="form-label">ID del Proyecto</label>
    <input type="number" name="project_id" class="form-control" value="{{ old('project_id', $version->project_id ?? '') }}" required>
</div>
