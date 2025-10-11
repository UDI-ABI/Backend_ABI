{{--
    View path: content_versions/index.blade.php.
    Purpose: Tablar-styled dashboard to manage the relationship between
    contents and project versions using the JSON API.
--}}
@extends('tablar::page')

@section('title', 'Versiones de Contenido')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('contents.index') }}">Contenidos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Versiones diligenciadas</li>
                        </ol>
                    </nav>
                    <h2 class="page-title d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg me-2 text-primary" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 3h6a2 2 0 0 1 2 2v14l-5 -3l-5 3v-14a2 2 0 0 1 2 -2" />
                        </svg>
                        Versiones de Contenido
                    </h2>
                    <p class="text-muted mb-0">Administra los valores diligenciados para cada contenido en las versiones de los proyectos.</p>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-content-version" id="btn-new-content-version">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5v14" />
                                <path d="M5 12h14" />
                            </svg>
                            Nuevo registro
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

            <div id="content-version-alert" class="alert d-none" role="alert"></div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Filtros avanzados</h3>
                </div>
                <div class="card-body">
                    <form id="content-version-filters" class="row g-3 align-items-end">
                        <div class="col-12 col-md-3">
                            <label for="filter-version" class="form-label">Versión</label>
                            <select id="filter-version" class="form-select">
                                <option value="">Todas</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="filter-content" class="form-label">Contenido</label>
                            <select id="filter-content" class="form-select">
                                <option value="">Todos</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="filter-project" class="form-label">Proyecto</label>
                            <input type="number" id="filter-project" class="form-control" min="1" placeholder="ID">
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="filter-search" class="form-label">Valor</label>
                            <input type="search" id="filter-search" class="form-control" placeholder="Texto contenido">
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="filter-per-page" class="form-label">Por página</label>
                            <select id="filter-per-page" class="form-select">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2 d-grid">
                            <button type="reset" class="btn btn-outline-secondary">Limpiar</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Registros diligenciados</h3>
                    <div class="card-actions">
                        <span class="badge bg-azure" id="content-version-total">0</span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th class="w-1">ID</th>
                                <th>Contenido</th>
                                <th>Versión</th>
                                <th>Proyecto</th>
                                <th>Valor diligenciado</th>
                                <th class="w-1">Actualizado</th>
                                <th class="w-1">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="content-version-rows">
                            <tr>
                                <td colspan="7" class="text-center text-secondary py-4">Cargando registros...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                    <div class="text-secondary" id="content-version-summary">Mostrando 0 a 0 de 0 registros</div>
                    <nav>
                        <ul class="pagination mb-0" id="content-version-pagination"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-content-version" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-content-version-title">Nuevo registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form id="content-version-form">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12 col-lg-6">
                                <label for="form-version" class="form-label required">Versión</label>
                                <select id="form-version" name="version_id" class="form-select" required>
                                    <option value="">Selecciona una versión</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="form-content" class="form-label required">Contenido</label>
                                <select id="form-content" name="content_id" class="form-select" required>
                                    <option value="">Selecciona un contenido</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="form-value" class="form-label required">Valor diligenciado</label>
                                <textarea id="form-value" name="value" class="form-control" rows="4" required placeholder="Describe la evidencia o valor capturado"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="content-version-submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const apiBase = '{{ url('/api/content-versions') }}';
            const contentsEndpoint = '{{ url('/api/contents') }}';
            const versionsEndpoint = '{{ url('/api/versions') }}';
            const csrfToken = '{{ csrf_token() }}';

            const state = {
                page: 1,
                perPage: 10,
                versionId: null,
                contentId: null,
                projectId: null,
                search: '',
                currentId: null,
                contents: new Map(),
                versions: new Map(),
            };

            const rows = document.getElementById('content-version-rows');
            const totalBadge = document.getElementById('content-version-total');
            const summary = document.getElementById('content-version-summary');
            const pagination = document.getElementById('content-version-pagination');
            const alertBox = document.getElementById('content-version-alert');

            const filtersForm = document.getElementById('content-version-filters');
            const filterVersion = document.getElementById('filter-version');
            const filterContent = document.getElementById('filter-content');
            const filterProject = document.getElementById('filter-project');
            const filterSearch = document.getElementById('filter-search');
            const filterPerPage = document.getElementById('filter-per-page');

            const modalElement = document.getElementById('modal-content-version');
            const modalTitle = document.getElementById('modal-content-version-title');
            const form = document.getElementById('content-version-form');
            const submitBtn = document.getElementById('content-version-submit');
            const formVersion = document.getElementById('form-version');
            const formContent = document.getElementById('form-content');
            const formValue = document.getElementById('form-value');
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
                alertBox.textContent = message;
                alertBox.className = `alert alert-${type}`;
            }

            function clearAlert() {
                alertBox.textContent = '';
                alertBox.className = 'alert d-none';
            }

            function buildQuery(page = 1) {
                const params = new URLSearchParams();
                params.set('page', page);
                params.set('per_page', state.perPage);
                if (state.versionId) {
                    params.set('version_id', state.versionId);
                }
                if (state.contentId) {
                    params.set('content_id', state.contentId);
                }
                if (state.projectId) {
                    params.set('project_id', state.projectId);
                }
                if (state.search) {
                    params.set('search', state.search);
                }
                return `${apiBase}?${params.toString()}`;
            }

            function truncate(text, limit = 80) {
                if (!text) return '—';
                return text.length > limit ? `${text.slice(0, limit)}…` : text;
            }

            function renderTable(data) {
                const items = Array.isArray(data?.data) ? data.data : [];
                if (!items.length) {
                    rows.innerHTML = '<tr><td colspan="7" class="text-center text-secondary py-4">No se encontraron registros.</td></tr>';
                } else {
                    rows.innerHTML = items.map(item => {
                        const version = item.version;
                        const project = version?.project;
                        const content = item.content;
                        const updated = item.updated_at ? new Date(item.updated_at).toLocaleString('es-CO') : '—';
                        const projectTitle = project?.title ? escapeHtml(project.title) : 'Proyecto sin título';
                        const projectLabel = project ? `${projectTitle} (#${project.id ?? '—'})` : 'Sin proyecto';
                        const valuePreview = item.value ? escapeHtml(truncate(item.value, 100)) : '<span class="text-secondary">Sin valor</span>';
                        const contentName = content ? escapeHtml(content.name) : 'Contenido eliminado';
                        const versionLabel = version ? `Versión #${version.id}` : 'Sin versión';
                        return `
                            <tr data-id="${item.id}">
                                <td class="text-secondary">#${item.id}</td>
                                <td>${contentName}</td>
                                <td>${versionLabel}</td>
                                <td>${projectLabel}</td>
                                <td>${valuePreview}</td>
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
                summary.textContent = `Mostrando ${from} a ${to} de ${total} registros`;

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

            async function fetchContentVersions(url = buildQuery(state.page)) {
                try {
                    clearAlert();
                    rows.innerHTML = '<tr><td colspan="7" class="text-center text-secondary py-4">Cargando registros...</td></tr>';
                    const response = await fetch(url, { headers: { 'Accept': 'application/json' } });
                    if (!response.ok) {
                        throw new Error('No fue posible cargar los registros.');
                    }
                    const data = await response.json();
                    state.page = data?.current_page ?? 1;
                    renderTable(data);
                } catch (error) {
                    setAlert(error.message || 'Ocurrió un error al cargar los registros.');
                    rows.innerHTML = '<tr><td colspan="7" class="text-center text-danger py-4">Error al cargar los datos.</td></tr>';
                    pagination.innerHTML = '';
                    totalBadge.textContent = '0';
                    summary.textContent = 'Mostrando 0 a 0 de 0 registros';
                }
            }

            async function getContentVersion(id) {
                const response = await fetch(`${apiBase}/${id}`, { headers: { 'Accept': 'application/json' } });
                if (!response.ok) {
                    throw new Error('No fue posible obtener el registro.');
                }
                return response.json();
            }

            async function submitContentVersion(method, url, payload) {
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
                    const firstError = Object.values(data.errors || {})[0]?.[0] ?? 'Datos inválidos.';
                    throw new Error(firstError);
                }

                if (!response.ok) {
                    const data = await response.json().catch(() => ({}));
                    throw new Error(data.message || 'No fue posible guardar el registro.');
                }

                return response.json().catch(() => ({}));
            }

            async function deleteContentVersion(id) {
                const response = await fetch(`${apiBase}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });

                if (!response.ok && response.status !== 204) {
                    const data = await response.json().catch(() => ({}));
                    throw new Error(data.message || 'No fue posible eliminar el registro.');
                }
            }

            async function loadContents() {
                const response = await fetch(`${contentsEndpoint}?per_page=100`, { headers: { 'Accept': 'application/json' } });
                if (!response.ok) return;
                const data = await response.json();
                const options = data?.data ?? [];
                state.contents.clear();
                formContent.innerHTML = '<option value="">Selecciona un contenido</option>';
                filterContent.innerHTML = '<option value="">Todos</option>';
                options.forEach(item => {
                    state.contents.set(String(item.id), item.name);
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = `${item.name} (#${item.id})`;
                    formContent.append(option.cloneNode(true));
                    filterContent.append(option);
                });
            }

            async function loadVersions() {
                const response = await fetch(`${versionsEndpoint}?per_page=100`, { headers: { 'Accept': 'application/json' } });
                if (!response.ok) return;
                const data = await response.json();
                const options = data?.data ?? [];
                state.versions.clear();
                formVersion.innerHTML = '<option value="">Selecciona una versión</option>';
                filterVersion.innerHTML = '<option value="">Todas</option>';
                options.forEach(item => {
                    const project = item.project ? ` - ${item.project.title ?? 'Proyecto #'+item.project.id}` : '';
                    const label = `Versión #${item.id}${project}`;
                    state.versions.set(String(item.id), label);
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = label;
                    formVersion.append(option.cloneNode(true));
                    filterVersion.append(option);
                });
            }

            filtersForm.addEventListener('submit', event => event.preventDefault());

            filtersForm.addEventListener('reset', () => {
                setTimeout(() => {
                    state.versionId = null;
                    state.contentId = null;
                    state.projectId = null;
                    state.search = '';
                    state.perPage = 10;
                    state.page = 1;
                    filterPerPage.value = '10';
                    filterSearch.value = '';
                    filterProject.value = '';
                    filterVersion.value = '';
                    filterContent.value = '';
                    fetchContentVersions(buildQuery());
                }, 0);
            });

            filterVersion.addEventListener('change', () => {
                state.versionId = filterVersion.value || null;
                state.page = 1;
                fetchContentVersions(buildQuery());
            });

            filterContent.addEventListener('change', () => {
                state.contentId = filterContent.value || null;
                state.page = 1;
                fetchContentVersions(buildQuery());
            });

            filterProject.addEventListener('change', () => {
                const value = filterProject.value.trim();
                state.projectId = value ? Number(value) : null;
                state.page = 1;
                fetchContentVersions(buildQuery());
            });

            filterSearch.addEventListener('input', () => {
                const value = filterSearch.value.trim();
                state.search = value;
                state.page = 1;
                fetchContentVersions(buildQuery());
            });

            filterPerPage.addEventListener('change', () => {
                state.perPage = Number(filterPerPage.value) || 10;
                state.page = 1;
                fetchContentVersions(buildQuery());
            });

            pagination.addEventListener('click', event => {
                const link = event.target.closest('a[data-url]');
                if (!link) return;
                event.preventDefault();
                const url = link.getAttribute('data-url');
                if (!url) return;
                fetchContentVersions(url);
            });

            rows.addEventListener('click', async event => {
                const button = event.target.closest('button[data-action]');
                if (!button) return;
                const id = button.getAttribute('data-id');
                if (!id) return;

                if (button.dataset.action === 'edit') {
                    try {
                        clearAlert();
                        const data = await getContentVersion(id);
                        state.currentId = data.id;
                        modalTitle.textContent = `Editar registro #${data.id}`;
                        formVersion.value = data.version_id ?? '';
                        formContent.value = data.content_id ?? '';
                        formValue.value = data.value ?? '';
                        submitBtn.textContent = 'Actualizar registro';
                        modalInstance?.show();
                    } catch (error) {
                        setAlert(error.message || 'No fue posible cargar el registro para edición.');
                    }
                }

                if (button.dataset.action === 'delete') {
                    if (!confirm('¿Deseas eliminar este registro?')) {
                        return;
                    }
                    try {
                        clearAlert();
                        await deleteContentVersion(id);
                        setAlert('Registro eliminado correctamente.', 'success');
                        fetchContentVersions(buildQuery(state.page));
                    } catch (error) {
                        setAlert(error.message || 'No fue posible eliminar el registro.');
                    }
                }
            });

            modalElement.addEventListener('show.bs.modal', () => {
                if (!state.currentId) {
                    modalTitle.textContent = 'Nuevo registro';
                    submitBtn.textContent = 'Guardar';
                    form.reset();
                }
            });

            modalElement.addEventListener('hidden.bs.modal', () => {
                state.currentId = null;
                form.reset();
            });

            form.addEventListener('submit', async event => {
                event.preventDefault();
                try {
                    clearAlert();
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';

                    const payload = {
                        version_id: Number(formVersion.value),
                        content_id: Number(formContent.value),
                        value: formValue.value.trim(),
                    };

                    if (!payload.version_id || !payload.content_id || !payload.value) {
                        throw new Error('Completa todos los campos obligatorios.');
                    }

                    let method = 'POST';
                    let url = apiBase;

                    if (state.currentId) {
                        method = 'PUT';
                        url = `${apiBase}/${state.currentId}`;
                    }

                    await submitContentVersion(method, url, payload);
                    modalInstance?.hide();
                    setAlert(state.currentId ? 'Registro actualizado correctamente.' : 'Registro creado con éxito.', 'success');
                    fetchContentVersions(buildQuery());
                } catch (error) {
                    setAlert(error.message || 'No fue posible guardar el registro.');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.textContent = state.currentId ? 'Actualizar registro' : 'Guardar';
                }
            });

            document.getElementById('btn-new-content-version').addEventListener('click', () => {
                state.currentId = null;
                modalTitle.textContent = 'Nuevo registro';
                submitBtn.textContent = 'Guardar';
                form.reset();
            });

            loadContents();
            loadVersions();
            fetchContentVersions(buildQuery());
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
