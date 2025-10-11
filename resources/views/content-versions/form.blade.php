{{--
    Partial path: content_versions/form.blade.php.
    Purpose: Shared Tablar form fragment for linking contents to versions with a captured value.
    Expected variables:
    - $contentVersion (optional): existing record used when editing.
    - $contentId (optional): selected content identifier passed from JS.
    - $versionId (optional): selected version identifier passed from JS.
--}}
@php
    $contentVersionModel = $contentVersion ?? null;
    $selectedContent = old('content_id', $contentId ?? ($contentVersionModel->content_id ?? ''));
    $selectedVersion = old('version_id', $versionId ?? ($contentVersionModel->version_id ?? ''));
    $value = old('value', $contentVersionModel->value ?? '');
@endphp

<div class="mb-3">
    <label for="content_id" class="form-label required">Contenido</label>
    <select id="content_id" name="content_id" class="form-select" required data-selected-content="{{ $selectedContent }}">
        <option value="">Selecciona un contenido</option>
    </select>
    <small class="form-hint">Busca el contenido por nombre o utiliza el selector para filtrar.</small>
    <div class="invalid-feedback d-none" data-feedback-for="content_id"></div>
</div>

<div class="mb-3">
    <label for="version_id" class="form-label required">Versión del proyecto</label>
    <select id="version_id" name="version_id" class="form-select" required data-selected-version="{{ $selectedVersion }}">
        <option value="">Selecciona una versión</option>
    </select>
    <small class="form-hint">Selecciona la versión del proyecto a la que pertenece el contenido.</small>
    <div class="invalid-feedback d-none" data-feedback-for="version_id"></div>
</div>

<div class="mb-3">
    <label for="value" class="form-label required">Valor diligenciado</label>
    <textarea
        id="value"
        name="value"
        class="form-control"
        rows="4"
        placeholder="Registra el valor capturado en la versión"
        required
    >{{ $value }}</textarea>
    <div class="invalid-feedback d-none" data-feedback-for="value"></div>
</div>

@push('css')
    <style>
        .form-label.required::after {
            content: ' *';
            color: var(--tblr-danger);
        }
    </style>
@endpush
