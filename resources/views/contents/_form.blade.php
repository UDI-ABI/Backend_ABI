<div class="mb-3">
    <label for="name" class="form-label">Nombre</label>
    <input type="text" name="name" id="name" class="form-control"
           value="{{ old('name', $content->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Descripción</label>
    <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $content->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="roles" class="form-label">Roles</label>
    <input type="text" name="roles" id="roles" class="form-control"
       value="{{ old('roles', is_array($content->roles) ? implode(',', $content->roles) : $content->roles) }}">

</div>
