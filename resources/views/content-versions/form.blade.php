<div class="mb-3">
    <label for="version_id" class="form-label">Version ID</label>
    <input type="number" name="version_id" class="form-control" value="{{ old('version_id', $contentVersion->version_id ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="content_id" class="form-label">Content ID</label>
    <input type="number" name="content_id" class="form-control" value="{{ old('content_id', $contentVersion->content_id ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="value" class="form-label">Value</label>
    <input type="text" name="value" class="form-control" value="{{ old('value', $contentVersion->value ?? '') }}" required>
</div>
