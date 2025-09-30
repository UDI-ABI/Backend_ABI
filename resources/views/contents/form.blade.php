<div class="mb-3">
    <label for="name" class="form-label">Nombre</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $content->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Descripción</label>
    <textarea name="description" class="form-control" required>{{ old('description', $content->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="role" class="form-label">Rol</label>
    <input type="text" name="role" class="form-control" value="{{ old('role', $content->role ?? '') }}" required>
</div>

