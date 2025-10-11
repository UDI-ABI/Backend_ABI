{{--
    View path: contents/index.blade.php.
    Purpose: Renders the management dashboard for catalog contents using Tablar styling.
    This template relies entirely on asynchronous API calls handled via JavaScript
    and therefore does not expect variables passed from the controller.
--}}
@extends('tablar::page')

@php
    use App\Models\Content;
    $roleLabels = [
        'research_staff' => 'Equipo de investigación',
        'professor' => 'Profesor',
        'student' => 'Estudiante',
        'committee_leader' => 'Líder de comité',
    ];
@endphp

@section('title', 'Gestión de Contenidos')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contenidos</li>
                        </ol>
                    </nav>
                    <h2 class="page-title d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg me-2 text-primary" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 5a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-7 -4l-7 4z" />
                        </svg>
                        Gestión de Contenidos
                    </h2>
                    <p class="text-muted mb-0">Administra el catálogo de contenidos disponibles para los proyectos y controla qué roles pueden gestionarlos.</p>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <button class="btn btn-primary" id="btn-new-content" type="button" data-bs-toggle="modal" data-bs-target="#modal-content">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Nuevo contenido
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            @if(config('tablar.display_alert'))
                @include('tablar::common.alert')
            @endif

            <div id="content-alert" class="alert d-none" role="alert"></div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Filtrar contenidos</h3>
                </div>
                <div class="card-body">
                    <form id="content-filters" class="row g-3 align-items-end">
                        <div class="col-12 col-lg-4">
                            <label for="content-search" class="form-label">Búsqueda</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <circle cx="10" cy="10" r="7" />
                                        <line x1="21" y1="21" x2="15" y2="15" />
                                    </svg>
                                </span>
                                <input type="search" class="form-control" id="content-search" placeholder="Nombre, descripción o ID">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Roles habilitados</label>
                            <div class="row g-1" id="content-roles">
                                @foreach(Content::ALLOWED_ROLES as $role)
                                    <div class="col-6">
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $role }}">
                                            <span class="form-check-label">{{ $roleLabels[$role] ?? ucfirst(str_replace('_',' ',$role)) }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <small class="form-hint">Selecciona uno o varios roles para filtrar.</small>
                        </div>
                        <div class="col-6 col-lg-2">
                            <label for="content-per-page" class="form-label">Por página</label>
                            <select id="content-per-page" class="form-select">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="col-6 col-lg-2 d-grid">
                            <button class="btn btn-outline-secondary" type="reset">Limpiar</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Listado de contenidos</h3>
                    <div class="card-actions">
                        <span class="badge bg-azure" id="content-total">0</span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th class="w-1">ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Roles permitidos</th>
                                <th class="w-1">Actualizado</th>
                                <th class="w-1">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="content-rows">
                            <tr>
                                <td colspan="6" class="text-center text-secondary py-4">Cargando contenidos...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                    <div class="text-secondary" id="content-summary">Mostrando 0 a 0 de 0 registros</div>
                    <nav>
                        <ul class="pagination mb-0" id="content-pagination"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-content" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-content-title">Nuevo contenido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form id="content-form" autocomplete="off">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label required" for="content-name">Nombre</label>
                                <input type="text" id="content-name" name="name" class="form-control" required maxlength="255">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="content-description">Descripción</label>
                                <textarea id="content-description" name="description" class="form-control" rows="3" placeholder="Describe brevemente el propósito del contenido"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label required">Roles con acceso</label>
                                <div class="row g-2" id="content-form-roles">
                                    @foreach(Content::ALLOWED_ROLES as $role)
                                        <div class="col-12 col-md-6">
                                            <label class="form-check">
                                                <input class="form-check-input" type="checkbox" value="{{ $role }}">
                                                <span class="form-check-label">{{ $roleLabels[$role] ?? ucfirst(str_replace('_',' ',$role)) }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="form-hint">Selecciona al menos un rol.</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="content-submit">
                            Guardar contenido
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const apiBase = '{{ url('/api/contents') }}';
            const csrfToken = '{{ csrf_token() }}';
            const allowedRoles = @json(Content::ALLOWED_ROLES);

            const state = {
                page: 1,
                perPage: 10,
                search: '',
                roles: [],
                currentId: null,
            };

            const rows = document.getElementById('content-rows');
            const totalBadge = document.getElementById('content-total');
            const summary = document.getElementById('content-summary');
            const pagination = document.getElementById('content-pagination');
            const alertBox = document.getElementById('content-alert');

            const filtersForm = document.getElementById('content-filters');
            const searchInput = document.getElementById('content-search');
            const perPageSelect = document.getElementById('content-per-page');
            const rolesFilterContainer = document.getElementById('content-roles');

            const modalElement = document.getElementById('modal-content');
            const modalTitle = document.getElementById('modal-content-title');
            const form = document.getElementById('content-form');
            const submitBtn = document.getElementById('content-submit');
            const formRolesContainer = document.getElementById('content-form-roles');

            const modalInstance = window.bootstrap ? window.bootstrap.Modal.getOrCreateInstance(modalElement) : null;

            function escapeHtml(value) {
                return String(value ?? '')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function setAlert(message, type = 'danger') {
                if (!alertBox) return;
                alertBox.textContent = message;
                alertBox.className = `alert alert-${type}`;
            }

            function clearAlert() {
                if (!alertBox) return;
                alertBox.textContent = '';
                alertBox.className = 'alert d-none';
            }

            function buildQuery(page = 1) {
                const params = new URLSearchParams();
                params.set('page', page);
                params.set('per_page', state.perPage);
                if (state.search) {
                    params.set('search', state.search);
                }
                if (state.roles.length) {
                    params.set('roles', JSON.stringify(state.roles));
                }
                return `${apiBase}?${params.toString()}`;
            }

            function renderRoles(roles) {
                if (!Array.isArray(roles) || !roles.length) {
                    return '<span class="badge bg-secondary">Sin roles definidos</span>';
                }
                return roles.map(role => {
                    const label = {
                        @foreach($roleLabels as $key => $label)
                            '{{ $key }}': '{{ $label }}',
                        @endforeach
                    }[role] || role;
                    return `<span class="badge bg-azure-lt me-1 mb-1">${label}</span>`;
                }).join('');
            }

            function renderTable(data) {
                const items = Array.isArray(data?.data) ? data.data : [];

                if (!items.length) {
                    rows.innerHTML = '<tr><td colspan="6" class="text-center text-secondary py-4">No se encontraron contenidos para los filtros seleccionados.</td></tr>';
                } else {
                    rows.innerHTML = items.map(item => {
                        const updated = item.updated_at ? new Date(item.updated_at).toLocaleString('es-CO') : '—';
                        const description = item.description
                            ? escapeHtml(item.description)
                            : '<span class="text-secondary">Sin descripción</span>';
                        return `
                            <tr data-id="${item.id}">
                                <td class="text-secondary">#${item.id}</td>
                                <td class="fw-semibold">${escapeHtml(item.name)}</td>
                                <td>${description}</td>
                                <td>${renderRoles(item.roles)}</td>
                                <td>${updated}</td>
                                <td>
                                    <div class="btn-list flex-nowrap">
                                        <button class="btn btn-outline-primary btn-sm" data-action="edit" data-id="${item.id}">Editar</button>
                                        <button class="btn btn-outline-danger btn-sm" data-action="delete" data-id="${item.id}">Eliminar</button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    }).join('');
                }

                totalBadge.textContent = data?.total ?? 0;
                const from = data?.from ?? 0;
                const to = data?.to ?? 0;
                const total = data?.total ?? 0;
                summary.textContent = `Mostrando ${from ?? 0} a ${to ?? 0} de ${total} registros`;

                renderPagination(data?.links || []);
            }

            function renderPagination(links) {
                if (!Array.isArray(links) || !links.length) {
                    pagination.innerHTML = '';
                    return;
                }

                pagination.innerHTML = links.map(link => {
                    const label = link.label
                        .replace('&laquo;', '«')
                        .replace('&raquo;', '»');
                    const disabled = link.url === null ? ' disabled' : '';
                    const active = link.active ? ' active' : '';
                    return `
                        <li class="page-item${disabled}${active}">
                            <a class="page-link" href="#" data-url="${link.url ?? ''}">${label}</a>
                        </li>
                    `;
                }).join('');
            }

            async function fetchContents(url = buildQuery(state.page)) {
                try {
                    clearAlert();
                    rows.innerHTML = '<tr><td colspan="6" class="text-center text-secondary py-4">Cargando contenidos...</td></tr>';
                    const response = await fetch(url, { headers: { 'Accept': 'application/json' } });
                    if (!response.ok) {
                        throw new Error('No fue posible cargar los contenidos.');
                    }
                    const data = await response.json();
                    state.page = data?.current_page ?? 1;
                    renderTable(data);
                } catch (error) {
                    setAlert(error.message || 'Ocurrió un error inesperado al cargar los contenidos.');
                    rows.innerHTML = '<tr><td colspan="6" class="text-center text-danger py-4">Error al cargar los datos.</td></tr>';
                    pagination.innerHTML = '';
                    totalBadge.textContent = '0';
                    summary.textContent = 'Mostrando 0 a 0 de 0 registros';
                }
            }

            async function getContent(id) {
                const response = await fetch(`${apiBase}/${id}`, { headers: { 'Accept': 'application/json' } });
                if (!response.ok) {
                    throw new Error('No fue posible obtener la información del contenido.');
                }
                return response.json();
            }

            async function submitContent(method, url, payload) {
                const response = await fetch(url, {
                    method,
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(payload),
                });

                if (response.status === 422) {
                    const data = await response.json();
                    const firstError = Object.values(data.errors || {})[0]?.[0] ?? 'Revisa la información ingresada.';
                    throw new Error(firstError);
                }

                if (!response.ok) {
                    const data = await response.json().catch(() => ({}));
                    throw new Error(data.message || 'No fue posible guardar la información.');
                }

                return response.json().catch(() => ({}));
            }

            async function deleteContent(id) {
                const response = await fetch(`${apiBase}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });

                if (response.status === 409) {
                    const data = await response.json();
                    throw new Error(data.message || 'El contenido no puede eliminarse.');
                }

                if (!response.ok && response.status !== 204) {
                    const data = await response.json().catch(() => ({}));
                    throw new Error(data.message || 'No fue posible eliminar el contenido.');
                }
            }

            filtersForm.addEventListener('submit', event => event.preventDefault());

            filtersForm.addEventListener('reset', () => {
                setTimeout(() => {
                    state.search = '';
                    state.roles = [];
                    state.page = 1;
                    perPageSelect.value = '10';
                    fetchContents(buildQuery());
                }, 0);
            });

            const searchListener = (window._ && typeof window._.debounce === 'function')
                ? window._.debounce(handleSearch, 350)
                : handleSearch;
            searchInput.addEventListener('input', searchListener);

            function handleSearch() {
                state.search = searchInput.value.trim();
                state.page = 1;
                fetchContents(buildQuery());
            }

            perPageSelect.addEventListener('change', () => {
                state.perPage = Number(perPageSelect.value) || 10;
                state.page = 1;
                fetchContents(buildQuery());
            });

            rolesFilterContainer.addEventListener('change', () => {
                const selected = Array.from(rolesFilterContainer.querySelectorAll('input:checked')).map(input => input.value);
                state.roles = selected;
                state.page = 1;
                fetchContents(buildQuery());
            });

            pagination.addEventListener('click', event => {
                const link = event.target.closest('a[data-url]');
                if (!link) return;
                event.preventDefault();
                const url = link.getAttribute('data-url');
                if (!url) return;
                fetchContents(url);
            });

            rows.addEventListener('click', async event => {
                const button = event.target.closest('button[data-action]');
                if (!button) return;
                const id = button.getAttribute('data-id');
                if (!id) return;

                if (button.dataset.action === 'edit') {
                    try {
                        clearAlert();
                        const data = await getContent(id);
                        state.currentId = data.id;
                        modalTitle.textContent = `Editar contenido #${data.id}`;
                        form.querySelector('#content-name').value = data.name || '';
                        form.querySelector('#content-description').value = data.description || '';
                        Array.from(formRolesContainer.querySelectorAll('input[type="checkbox"]')).forEach(input => {
                            input.checked = Array.isArray(data.roles) ? data.roles.includes(input.value) : false;
                        });
                        submitBtn.textContent = 'Actualizar contenido';
                        modalInstance?.show();
                    } catch (error) {
                        setAlert(error.message || 'No fue posible cargar el contenido para edición.');
                    }
                }

                if (button.dataset.action === 'delete') {
                    if (!confirm('¿Seguro que deseas eliminar este contenido? Esta acción no se puede deshacer.')) {
                        return;
                    }
                    try {
                        clearAlert();
                        await deleteContent(id);
                        setAlert('Contenido eliminado correctamente.', 'success');
                        fetchContents(buildQuery(state.page));
                    } catch (error) {
                        setAlert(error.message || 'No fue posible eliminar el contenido.');
                    }
                }
            });

            modalElement.addEventListener('show.bs.modal', () => {
                if (!state.currentId) {
                    modalTitle.textContent = 'Nuevo contenido';
                    submitBtn.textContent = 'Guardar contenido';
                    form.reset();
                    Array.from(formRolesContainer.querySelectorAll('input[type="checkbox"]')).forEach(input => {
                        input.checked = false;
                    });
                }
            });

            modalElement.addEventListener('hidden.bs.modal', () => {
                state.currentId = null;
                form.reset();
                Array.from(formRolesContainer.querySelectorAll('input[type="checkbox"]')).forEach(input => {
                    input.checked = false;
                });
            });

            form.addEventListener('submit', async event => {
                event.preventDefault();
                try {
                    clearAlert();
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';

                    const payload = {
                        name: form.querySelector('#content-name').value.trim(),
                        description: form.querySelector('#content-description').value.trim(),
                        roles: Array.from(formRolesContainer.querySelectorAll('input:checked')).map(input => input.value),
                    };

                    if (!payload.name) {
                        throw new Error('El nombre del contenido es obligatorio.');
                    }

                    if (!payload.roles.length) {
                        throw new Error('Selecciona al menos un rol.');
                    }

                    let method = 'POST';
                    let url = apiBase;

                    if (state.currentId) {
                        method = 'PUT';
                        url = `${apiBase}/${state.currentId}`;
                    }

                    await submitContent(method, url, payload);
                    modalInstance?.hide();
                    setAlert(state.currentId ? 'Contenido actualizado correctamente.' : 'Contenido creado con éxito.', 'success');
                    fetchContents(buildQuery());
                } catch (error) {
                    setAlert(error.message || 'No fue posible guardar la información.');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.textContent = state.currentId ? 'Actualizar contenido' : 'Guardar contenido';
                }
            });

            document.getElementById('btn-new-content').addEventListener('click', () => {
                state.currentId = null;
                modalTitle.textContent = 'Nuevo contenido';
                submitBtn.textContent = 'Guardar contenido';
                form.reset();
                Array.from(formRolesContainer.querySelectorAll('input[type="checkbox"]')).forEach(input => {
                    input.checked = false;
                });
            });

            fetchContents(buildQuery());
        });
    </script>
@endpush

@push('css')
    <style>
        .form-label.required::after {
            content: ' *';
            color: var(--tblr-danger);
        }
    </style>
@endpush
