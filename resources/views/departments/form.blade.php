@php
    $isEdit = isset($department) && $department->exists;
@endphp

<div class="mb-3">
    <label for="name" class="form-label required">Nombre del departamento</label>
    <input type="text"
           id="name"
           name="name"
           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
           maxlength="100"
           value="{{ old('name', $department->name ?? '') }}"
           placeholder="Ej: Antioquia"
           required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <small class="form-hint">Introduce el nombre oficial del departamento administrativo.</small>
</div>

<hr class="my-4">

<div class="form-footer d-flex justify-content-between align-items-center">
    <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
        Cancelar
    </a>

    <button type="submit" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12l5 5l10 -10" />
        </svg>
        {{ $isEdit ? 'Actualizar departamento' : 'Crear departamento' }}
    </button>
</div>