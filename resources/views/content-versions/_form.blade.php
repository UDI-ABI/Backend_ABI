@csrf

<!-- ID Contenido -->
<div class="mb-3">
    <label class="form-label">ID Contenido</label>
    <input type="number" name="content_id" class="form-control" 
           value="{{ old('content_id', $contentVersion->content_id ?? '') }}" required>
</div>

<!-- ID Versión -->
<div class="mb-3">
    <label class="form-label">ID Versión</label>
    <input type="number" name="version_id" class="form-control" 
           value="{{ old('version_id', $contentVersion->version_id ?? '') }}" required>
</div>

<!-- Valor -->
<div class="mb-3">
    <label class="form-label">Valor</label>
    <textarea name="value" class="form-control" rows="3" required>{{ old('value', $contentVersion->value ?? '') }}</textarea>
</div>
