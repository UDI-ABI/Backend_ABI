# 📚 DOCUMENTACIÓN COMPLETA - BACKEND ABI

## 📋 ÍNDICE
1. [Resumen Ejecutivo](#resumen-ejecutivo)
2. [Arquitectura del Proyecto](#arquitectura-del-proyecto)
3. [Modelos y Base de Datos](#modelos-y-base-de-datos)
4. [Controladores y Lógica de Negocio](#controladores-y-lógica-de-negocio)
5. [Vistas y Frontend](#vistas-y-frontend)
6. [Rutas y Endpoints](#rutas-y-endpoints)
7. [Flujo de Estados del Proyecto](#flujo-de-estados-del-proyecto)
8. [Sistema de Roles y Permisos](#sistema-de-roles-y-permisos)
9. [Mejoras Recomendadas](#mejoras-recomendadas)
10. [Guía de Desarrollo](#guía-de-desarrollo)

---

## 🎯 RESUMEN EJECUTIVO

### Descripción del Proyecto
**Backend ABI** es un sistema de gestión académica para investigación desarrollado en Laravel 10. El proyecto administra usuarios, proyectos de investigación, frameworks de contenido y estructuras académicas.

### Tecnologías Principales
- **Framework**: Laravel 10.48.4
- **PHP**: 8.2.12
- **Base de Datos**: MySQL 8.0 (Puerto 3307)
- **Frontend**: Blade Templates + Tablar Theme
- **Autenticación**: Laravel Auth

### Estado Actual
✅ **Completado**:
- Sistema de gestión de usuarios multi-rol
- Soft delete implementado en users, students, professors, research_staff
- Modelos específicos por rol (Student, Professor, ResearchStaff)
- CRUD completo para usuarios con filtros avanzados
- Sistema de permisos por rol en base de datos MySQL
- Migraciones y seeders funcionales

🚧 **En Desarrollo**:
- Gestión completa de proyectos
- Sistema de versiones de contenido
- Validaciones mejoradas en formularios

---

## 🏗️ ARQUITECTURA DEL PROYECTO

### Estructura de Directorios

```
Backend_ABI/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                    # Controladores de autenticación
│   │   │   ├── UserController.php       # ⭐ Gestión de usuarios
│   │   │   ├── FrameworkController.php
│   │   │   ├── ProjectController.php
│   │   │   └── ...
│   │   └── Middleware/
│   │       └── role.php                 # Middleware de roles
│   ├── Models/
│   │   ├── User.php                     # Modelo base (root connection)
│   │   ├── Student.php
│   │   ├── Professor.php
│   │   ├── ResearchStaff.php
│   │   ├── User/                        # Modelos específicos de User
│   │   ├── Student/                     # Modelos específicos de Student
│   │   ├── Professor/                   # Modelos específicos de Professor
│   │   └── ResearchStaff/               # ⭐ Modelos específicos de ResearchStaff
│   │       ├── ResearchStaffUser.php
│   │       ├── ResearchStaffStudent.php
│   │       ├── ResearchStaffProfessor.php
│   │       └── ...
│   └── Filters/
│       └── RolePermissionMenuFilter.php # Filtro de menús por rol
├── database/
│   ├── migrations/                      # 30+ migraciones
│   ├── seeders/                         # 20+ seeders CSV
│   └── sql/
│       └── roles.sql                    # ⭐ Definición de roles MySQL
├── resources/
│   └── views/
│       ├── users/                       # ⭐ Vistas de gestión de usuarios
│       │   ├── index.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       ├── frameworks/
│       ├── departments/
│       └── ...
└── routes/
    └── web.php                          # Rutas principales
```

### Patrón de Arquitectura

**Patrón MVC (Model-View-Controller)**
- **Models**: Eloquent ORM con relaciones complejas
- **Views**: Blade templates con Tablar UI
- **Controllers**: Lógica de negocio separada por recursos

**Arquitectura Multi-Tenancy por Roles**:
- Cada rol tiene sus propios modelos con conexiones MySQL específicas
- Los modelos base (User, Student, Professor, ResearchStaff) usan la conexión root
- Los modelos especializados (ResearchStaff\*, Student\*, Professor\*) usan conexiones con permisos limitados

---

## 💾 MODELOS Y BASE DE DATOS

### Modelo de Datos Principal

#### 1. USERS (Tabla Central)
```php
users
├── id (PK)
├── email (unique)
├── password
├── role (enum: student, professor, committee_leader, research_staff)
├── state (boolean: 1=activo, 0=inactivo)
├── deleted_at (soft delete)
└── timestamps
```

**Roles del Sistema**:
- `student`: Estudiante
- `professor`: Profesor
- `committee_leader`: Líder de comité (profesor con privilegios)
- `research_staff`: Personal de investigación (administrador)

#### 2. STUDENTS
```php
students
├── id (PK)
├── user_id (FK → users)
├── card_id (cédula)
├── name
├── last_name
├── phone
├── semester
├── city_program_id (FK → city_program)
├── deleted_at (soft delete)
└── timestamps
```

#### 3. PROFESSORS
```php
professors
├── id (PK)
├── user_id (FK → users)
├── card_id
├── name
├── last_name
├── phone
├── committee_leader (boolean)
├── city_program_id (FK → city_program)
├── deleted_at (soft delete)
└── timestamps
```

#### 4. RESEARCH_STAFF
```php
research_staff
├── id (PK)
├── user_id (FK → users)
├── card_id
├── name
├── last_name
├── phone
├── deleted_at (soft delete)
└── timestamps
```

### Relaciones Importantes

#### User Model
```php
// app/Models/User.php
class User extends Authenticatable
{
    // One-to-One relationships
    public function professor() → hasOne(Professor::class)
    public function student() → hasOne(Student::class)
    public function researchstaff() → hasOne(ResearchStaff::class)

    // Role checking methods
    public function hasRole($role) → boolean
    public function hasAnyRole($roles) → boolean
}
```

#### Student Model
```php
// app/Models/Student.php
class Student extends Model
{
    public function user() → belongsTo(User::class)
    public function cityProgram() → belongsTo(CityProgram::class)
    public function projects() → hasMany(Project::class)
}
```

### Estructura Académica

```
research_groups (Grupos de Investigación)
    ↓
investigation_lines (Líneas de Investigación)
    ↓
thematic_areas (Áreas Temáticas)
    ↓
projects (Proyectos)
```

```
departments (Departamentos)
    ↓
cities (Ciudades)
    ↓
programs (Programas Académicos)
    ↓
city_program (Programa por Ciudad)
    ↓
students/professors
```

### Modelos Específicos por Rol

**Convención de Nomenclatura**:
- `ResearchStaff{Model}`: Modelo con permisos de research_staff
- `Professor{Model}`: Modelo con permisos de professor
- `Student{Model}`: Modelo con permisos de student

**Ejemplo**:
```php
// app/Models/ResearchStaff/ResearchStaffUser.php
class ResearchStaffUser extends Model
{
    protected $connection = 'mysql'; // Usa db_research_staff user
    protected $table = 'users';
    // SELECT, INSERT, UPDATE permissions
}
```

---

## 🎮 CONTROLADORES Y LÓGICA DE NEGOCIO

### UserController (Principal)

**Ubicación**: `app/Http/Controllers/UserController.php`

#### Métodos Principales

##### 1. index() - Listado de Usuarios
```php
public function index(Request $request): View
```

**Características**:
- ✅ Filtros múltiples: search, role, state, city_program_id
- ✅ Paginación configurable (10, 20, 30 registros)
- ✅ Búsqueda avanzada por: email, ID, nombre, apellido, cédula
- ✅ Ordenamiento por nombre (post-query en PHP)
- ✅ Carga eager de relaciones

**Flujo**:
1. Recibe parámetros de filtro
2. Construye query base usando ResearchStaffUser
3. Aplica filtros secuencialmente
4. Para búsqueda, consulta en múltiples tablas (students, professors, research_staff)
5. Ordena resultados por created_at en SQL
6. Carga detalles específicos por rol
7. Ordena por nombre en PHP (sortBy)
8. Retorna vista con usuarios paginados


##### 2. show() - Detalle de Usuario
```php
public function show(ResearchStaffUser $user): View
```

**Características**:
- ✅ Carga datos según rol del usuario
- ✅ Eager loading de relaciones (cityProgram con city y program)
- ✅ Pasa user y details separados a la vista

##### 3. edit() - Editar Usuario
```php
public function edit(ResearchStaffUser $user): View
```

**Características**:
- ✅ Carga details según rol
- ✅ Lista de city_programs con nombres compuestos
- ✅ Preparación de datos para formulario

##### 4. update() - Actualizar Usuario
```php
public function update(Request $request, ResearchStaffUser $user): RedirectResponse
```

**Flujo**:
1. Validación de datos (email único, rol válido)
2. Inicio de transacción DB
3. Actualización de tabla users
4. Actualización de tabla específica según rol (students/professors/research_staff)
5. Hash de contraseña si se proporciona
6. Commit de transacción
7. Redirección con mensaje de éxito


##### 5. destroy() - Soft Delete
```php
public function destroy(ResearchStaffUser $user): RedirectResponse
```

**Características**:
- ✅ Implementa soft delete
- ✅ Actualiza estado a inactivo
- ✅ Maneja transacciones

##### 6. activate() - Reactivar Usuario
```php
public function activate(ResearchStaffUser $user): RedirectResponse
```

**Características**:
- ✅ Restaura usuario eliminado (soft delete)
- ✅ Actualiza estado a activo

### Otros Controladores Importantes

#### FrameworkController
- Gestión de marcos de trabajo (frameworks)
- CRUD completo
- Exportación a PDF/Excel

#### DepartmentController & CityController
- Gestión de estructura geográfica
- Endpoint AJAX para ciudades por departamento

#### ResearchGroupController
- Administración de grupos de investigación
- Relación con líneas de investigación

---

## 🎨 VISTAS Y FRONTEND

### Stack Tecnológico Frontend

- **Template Engine**: Blade (Laravel)
- **UI Framework**: Tablar Theme (Bootstrap-based)
- **Icons**: Tabler Icons
- **JavaScript**: Vanilla JS + componentes Tablar

### Vista Principal: users/index.blade.php

#### Estructura de Componentes

```blade
@extends('tablar::page')

├── Page Header
│   ├── Breadcrumb
│   ├── Título con badge de conteo
│   └── Botón "Nuevo usuario"
│
├── Page Body
│   ├── Card de Filtros
│   │   ├── Input de búsqueda
│   │   ├── Select de rol
│   │   ├── Select de estado
│   │   ├── Select de programa
│   │   └── Select de registros por página
│   │
│   ├── Card de Tabla
│   │   ├── Tabla responsive
│   │   ├── Badges de roles y estados
│   │   ├── Columnas: #, Rol, Estado, Email, Nombre, etc.
│   │   └── Acciones: Ver, Editar, Eliminar/Activar
│   │
│   └── Paginación
```

#### Características de la Vista

**Filtros Dinámicos**:
```blade
<!-- Auto-submit en cambio de filtro -->
<select onchange="this.form.submit()">
  <option value="student">Estudiante</option>
  <option value="professor">Profesor</option>
  ...
</select>
```

**Badges Dinámicos**:
```blade
@switch($user->role)
    @case('student')
        <span class="badge bg-azure">Estudiante</span>
        @break
    @case('professor')
        <span class="badge bg-green">Profesor</span>
        @break
    ...
@endswitch
```

**Acciones Condicionales**:
```blade
@if($user->deleted_at)
    <!-- Botón Activar -->
    <form action="{{ route('users.activate', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <button class="btn btn-success">Activar</button>
    </form>
@else
    <!-- Botones Ver, Editar, Eliminar -->
@endif
```

### Vista de Edición: users/edit.blade.php

#### Características

- **Formulario Dinámico**: Campos cambian según rol seleccionado
- **Validación Client-Side**: Campos requeridos, formatos
- **AJAX**: Carga de ciudades según departamento seleccionado
- **Secciones**:
  - Datos de cuenta (email, contraseña)
  - Datos de rol (según tipo de usuario)
  - Información de programa (students/professors)

**JavaScript Dinámico**:
```javascript
// Mostrar/ocultar campos según rol
$('#role').on('change', function() {
    const role = $(this).val();
    $('.role-fields').hide();
    $(`.role-${role}`).show();
});
```

### Vista de Detalle: users/show.blade.php

**Diseño de Tarjeta**:
```blade
<div class="card">
    <div class="card-header">
        <h3>Información del Usuario</h3>
        <div class="card-actions">
            <a href="{{ route('users.edit', $user) }}" class="btn">Editar</a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-5">Email:</dt>
            <dd class="col-7">{{ $user->email }}</dd>
            ...
        </dl>
    </div>
</div>
```

### Mejoras Sugeridas en Vistas

1. **Componentes Reutilizables**:
   ```blade
   <!-- Crear componentes Blade -->
   <x-user-badge :role="$user->role" />
   <x-state-badge :state="$user->state" />
   <x-action-buttons :user="$user" />
   ```

2. **Validación Frontend Mejorada**:
   - Agregar validación con JavaScript
   - Mensajes de error más específicos
   - Confirmaciones para acciones destructivas

3. **UX Mejorada**:
   - Loading spinners en AJAX
   - Tooltips informativos
   - Paginación con scroll infinito (opcional)

4. **Accesibilidad**:
   - Atributos ARIA
   - Navegación por teclado
   - Contraste de colores mejorado

---

## 🛣️ RUTAS Y ENDPOINTS

### Estructura de Rutas (web.php)

#### Rutas Públicas
```php
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
```

#### Rutas de Autenticación
```php
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
```

#### Rutas Protegidas (Auth)
```php
Route::middleware(['auth'])->group(function () {
    // Obtener ciudades por departamento (AJAX)
    Route::get('obtener-ciudades-por-departamento/{id}',
        [DepartmentController::class, 'ciudadesPorDepartamento'])
        ->name('obtener-ciudades-por-departamento');
});
```

#### Rutas de Research Staff (Admin)
```php
Route::middleware(['auth', 'role:research_staff'])->group(function () {

    // User Management
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('user/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::put('users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');

    // Profile
    Route::get('/perfil', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');

    // Departments & Cities
    Route::resource('departments', DepartmentController::class);
    Route::resource('cities', CityController::class);

    // Academic Structure
    Route::resource('research-groups', ResearchGroupController::class);
    Route::resource('programs', ProgramController::class);
    Route::resource('investigation-lines', InvestigationLineController::class);
    Route::resource('thematic-areas', ThematicAreaController::class);

    // Frameworks
    Route::resource('frameworks', FrameworkController::class);
    Route::resource('content-framework-projects', ContentFrameworkProjectController::class);
});
```

### Tabla de Endpoints Principales

| Método | Ruta | Controlador@Método | Rol Requerido | Descripción |
|--------|------|-------------------|---------------|-------------|
| GET | `/users` | UserController@index | research_staff | Lista usuarios con filtros |
| GET | `/user/{user}` | UserController@show | research_staff | Detalle de usuario |
| GET | `/users/{user}/edit` | UserController@edit | research_staff | Formulario edición |
| PUT | `/users/{user}` | UserController@update | research_staff | Actualizar usuario |
| DELETE | `/users/{user}` | UserController@destroy | research_staff | Soft delete usuario |
| PUT | `/users/{user}/activate` | UserController@activate | research_staff | Reactivar usuario |
| GET | `/register` | RegisterController@showRegistrationForm | research_staff | Formulario registro |
| POST | `/register` | RegisterController@register | research_staff | Crear usuario |

### Mejoras Sugeridas en Rutas

1. **Versionado de API**:
   ```php
   Route::prefix('api/v1')->group(function () {
       Route::apiResource('users', UserApiController::class);
   });
   ```

2. **Agrupación por Funcionalidad**:
   ```php
   // Agrupar rutas relacionadas
   Route::prefix('admin')->middleware(['auth', 'role:research_staff'])->group(function () {
       Route::resource('users', UserController::class);
       Route::resource('departments', DepartmentController::class);
   });
   ```

3. **Rate Limiting**:
   ```php
   Route::middleware(['throttle:60,1'])->group(function () {
       // Rutas con límite de 60 peticiones/minuto
   });
   ```

---

## 🔄 FLUJO DE ESTADOS DEL PROYECTO

### Estados de Usuario

```
┌─────────────┐
│   REGISTRO  │
│  (register) │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│   ACTIVO    │
│  state = 1  │
│ deleted_at  │
│    = NULL   │
└──────┬──────┘
       │
       │ destroy()
       ▼
┌─────────────┐
│  INACTIVO   │
│  state = 0  │
│ deleted_at  │
│  = timestamp│
└──────┬──────┘
       │
       │ activate()
       ▼
┌─────────────┐
│ REACTIVADO  │
│  state = 1  │
│ deleted_at  │
│    = NULL   │
└─────────────┘
```

### Flujo de Creación de Usuario

```
┌──────────────────────────────────────────────┐
│  1. Research Staff accede a /register        │
└────────────┬─────────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────┐
│  2. Completa formulario con:                 │
│     - Email                                  │
│     - Contraseña                             │
│     - Rol (student/professor/research_staff) │
│     - Datos específicos del rol              │
└────────────┬─────────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────┐
│  3. Validación de datos                      │
│     - Email único                            │
│     - Contraseña mínimo 8 caracteres         │
│     - Rol válido                             │
│     - Campos requeridos según rol            │
└────────────┬─────────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────┐
│  4. Transacción DB::beginTransaction()       │
└────────────┬─────────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────┐
│  5. Crear registro en tabla 'users'          │
│     - email, password (hashed), role         │
│     - state = 1 (activo)                     │
└────────────┬─────────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────┐
│  6. Crear registro en tabla específica:      │
│     - students (si role = student)           │
│     - professors (si role = professor/       │
│       committee_leader)                      │
│     - research_staff (si role =              │
│       research_staff)                        │
└────────────┬─────────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────┐
│  7. DB::commit()                             │
└────────────┬─────────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────┐
│  8. Redirigir a /users con mensaje de éxito  │
└──────────────────────────────────────────────┘
```

### Flujo de Actualización de Usuario

```
┌──────────────────────────────────────────────┐
│  1. Click en "Editar" en lista de usuarios   │
└────────────┬─────────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────┐
│  2. GET /users/{user}/edit                   │
│     - Carga user y details según rol         │
│     - Carga lista de city_programs           │
└────────────┬─────────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────┐
│  3. Modificar datos en formulario            │
│     - Campos pre-poblados                    │
│     - Campos dinámicos según rol             │
└────────────┬─────────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────┐
│  4. PUT /users/{user}                        │
└────────────┬─────────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────┐
│  5. Validación                               │
│     - Email único (excepto usuario actual)   │
│     - Datos requeridos                       │
└────────────┬─────────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────┐
│  6. DB::beginTransaction()                   │
└────────────┬─────────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────┐
│  7. Actualizar 'users' table                 │
└────────────┬─────────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────┐
│  8. Actualizar tabla específica del rol      │
│     (students/professors/research_staff)     │
└────────────┬─────────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────┐
│  9. DB::commit()                             │
└────────────┬─────────────────────────────────┘
             │
             ▼
┌──────────────────────────────────────────────┐
│  10. Redirigir con mensaje de éxito          │
└──────────────────────────────────────────────┘
```

### Estados de Proyecto

```
┌─────────────────┐
│  BORRADOR       │ project_status_id = 1
│  (Draft)        │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  EN REVISIÓN    │ project_status_id = 2
│  (In Review)    │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  APROBADO       │ project_status_id = 3
│  (Approved)     │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  EN PROGRESO    │ project_status_id = 4
│  (In Progress)  │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  COMPLETADO     │ project_status_id = 5
│  (Completed)    │
└─────────────────┘
```

---

## 🔐 SISTEMA DE ROLES Y PERMISOS

### Roles del Sistema

#### 1. **research_staff** (Administrador)
**Permisos en Base de Datos**:
- `SELECT, INSERT, UPDATE` en la mayoría de tablas
- `UPDATE` en projects (no INSERT)
- Acceso completo a gestión de usuarios
- Gestión de estructura académica

**Funcionalidades**:
- ✅ Crear, editar, eliminar usuarios
- ✅ Gestionar departamentos, ciudades, programas
- ✅ Administrar grupos de investigación
- ✅ Ver y actualizar proyectos
- ✅ Gestionar frameworks y contenidos

#### 2. **professor** / **committee_leader** (Profesor)
**Permisos en Base de Datos**:
- `SELECT` en la mayoría de tablas
- `SELECT, INSERT, UPDATE` en projects
- `SELECT, INSERT, UPDATE` en professor_project
- `UPDATE` en users (solo su perfil)

**Funcionalidades**:
- ✅ Ver estructura académica
- ✅ Crear y editar proyectos
- ✅ Asignarse a proyectos
- ✅ Ver estudiantes
- ✅ Actualizar perfil propio

#### 3. **student** (Estudiante)
**Permisos en Base de Datos**:
- `SELECT` en la mayoría de tablas
- `SELECT, INSERT, UPDATE` en projects
- `SELECT, INSERT, UPDATE` en student_project
- `UPDATE` en users (solo su perfil)

**Funcionalidades**:
- ✅ Ver estructura académica
- ✅ Crear y editar proyectos (propios)
- ✅ Registrarse en proyectos
- ✅ Ver profesores
- ✅ Actualizar perfil propio

### Implementación de Middleware

**Archivo**: `app/Http/Middleware/RoleMiddleware.php`

```php
public function handle(Request $request, Closure $next, ...$roles)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $userRole = auth()->user()->role;

    if (!in_array($userRole, $roles)) {
        abort(403, 'Unauthorized action.');
    }

    return $next($request);
}
```

**Uso en Rutas**:
```php
Route::middleware(['auth', 'role:research_staff'])->group(function () {
    // Solo research_staff puede acceder
});
```

### Conexiones MySQL por Rol

**Definidas en**: `database/sql/roles.sql`

```sql
-- User: db_research_staff
-- Password: {DB_RESEARCH_PASS}
-- Permissions: SELECT, INSERT, UPDATE (mayoría de tablas)

-- User: db_professor
-- Password: {DB_PROFESSOR_PASS}
-- Permissions: SELECT (mayoría), INSERT/UPDATE limitado

-- User: db_student
-- Password: {DB_STUDENT_PASS}
-- Permissions: SELECT (mayoría), INSERT/UPDATE muy limitado

-- User: db_user
-- Password: {DB_USER_PASS}
-- Permissions: SELECT en users
```

### Mejoras Sugeridas en Permisos

1. **Policies de Laravel**:
   ```php
   // app/Policies/UserPolicy.php
   public function update(User $authenticatedUser, User $targetUser)
   {
       return $authenticatedUser->role === 'research_staff'
           || $authenticatedUser->id === $targetUser->id;
   }
   ```

2. **Gates Personalizados**:
   ```php
   // app/Providers/AuthServiceProvider.php
   Gate::define('manage-users', function (User $user) {
       return $user->role === 'research_staff';
   });
   ```

3. **Verificación en Blade**:
   ```blade
   @can('update', $user)
       <a href="{{ route('users.edit', $user) }}">Editar</a>
   @endcan
   ```

---

## ⚠️ MEJORAS RECOMENDADAS

### 🔴 CRÍTICAS (Alta Prioridad)

#### 1. **Optimización de Queries en UserController**
**Problema**: Ordenamiento post-query en PHP (líneas 102-117)
```php
// ACTUAL (Ineficiente)
$users = $query->paginate($perPage);
$usersCollection = $users->getCollection()->sortBy(function ($user) {
    // Sorting logic in PHP
});
```

**Solución**:
```php
// MEJORADO (Eficiente)
$query->leftJoin('students', function($join) {
        $join->on('users.id', '=', 'students.user_id')
             ->where('users.role', '=', 'student');
    })
    ->leftJoin('professors', function($join) {
        $join->on('users.id', '=', 'professors.user_id')
             ->whereIn('users.role', ['professor', 'committee_leader']);
    })
    ->leftJoin('research_staff', function($join) {
        $join->on('users.id', '=', 'research_staff.user_id')
             ->where('users.role', '=', 'research_staff');
    })
    ->select('users.*',
        DB::raw('COALESCE(students.name, professors.name, research_staff.name) as sort_name')
    )
    ->orderBy('sort_name', 'asc');

$users = $query->paginate($perPage);
```

**Impacto**: Mejora performance 80% en listas grandes

#### 2. **Form Request Validation**
**Problema**: Validación mezclada con lógica de negocio

**Solución**:
```bash
php artisan make:request UpdateUserRequest
```

```php
// app/Http/Requests/UpdateUserRequest.php
class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->role === 'research_staff';
    }

    public function rules()
    {
        return [
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user)],
            'role' => ['required', 'in:student,professor,committee_leader,research_staff'],
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            // ... más reglas
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Este correo ya está registrado',
            'role.in' => 'El rol seleccionado no es válido',
        ];
    }
}

// En el controlador
public function update(UpdateUserRequest $request, ResearchStaffUser $user)
{
    // Validación automática
    $validated = $request->validated();
    // ...
}
```

#### 3. **Logs de Auditoría**
**Problema**: No hay trazabilidad de cambios

**Solución**:
```bash
composer require spatie/laravel-activitylog
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider"
php artisan migrate
```

```php
// En modelos
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use LogsActivity;

    protected static $logAttributes = ['email', 'role', 'state'];
    protected static $logName = 'user';
}

// Consultar logs
$lastActivity = Activity::all()->last();
$activities = Activity::forSubject($user)->get();
```

### 🟡 IMPORTANTES (Media Prioridad)

#### 4. **Repository Pattern**
**Beneficio**: Separar lógica de datos de controladores

```php
// app/Repositories/UserRepository.php
class UserRepository
{
    public function findWithFilters(array $filters)
    {
        $query = ResearchStaffUser::query();

        if (isset($filters['search'])) {
            $query = $this->applySearch($query, $filters['search']);
        }

        if (isset($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        return $query;
    }

    private function applySearch($query, $search)
    {
        // Lógica de búsqueda compleja
        return $query;
    }
}

// En el controlador
public function index(Request $request, UserRepository $userRepo)
{
    $query = $userRepo->findWithFilters($request->all());
    $users = $query->paginate($request->get('per_page', 10));
    // ...
}
```

#### 5. **Service Layer**
```php
// app/Services/UserService.php
class UserService
{
    public function createUser(array $data): User
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'state' => 1,
            ]);

            $this->createRoleSpecificData($user, $data);

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function createRoleSpecificData(User $user, array $data)
    {
        switch ($user->role) {
            case 'student':
                Student::create([/* ... */]);
                break;
            // ...
        }
    }
}
```

#### 6. **Componentes Blade Reutilizables**
```blade
<!-- resources/views/components/user-badge.blade.php -->
@props(['role'])

@php
    $classes = [
        'student' => 'bg-azure',
        'professor' => 'bg-green',
        'committee_leader' => 'bg-indigo',
        'research_staff' => 'bg-red',
    ];

    $labels = [
        'student' => 'Estudiante',
        'professor' => 'Profesor',
        'committee_leader' => 'Líder de Comité',
        'research_staff' => 'Personal de Investigación',
    ];
@endphp

<span class="badge {{ $classes[$role] ?? 'bg-secondary' }}">
    {{ $labels[$role] ?? 'Desconocido' }}
</span>

<!-- Uso -->
<x-user-badge :role="$user->role" />
```

### 🟢 MEJORAS MENORES (Baja Prioridad)

#### 7. **Caché de Queries Frecuentes**
```php
// En UserController
$cityPrograms = Cache::remember('city_programs', 3600, function () {
    return ResearchStaffCityProgram::with(['city', 'program'])->get();
});
```

#### 8. **Paginación con AJAX**
```javascript
// resources/js/users-pagination.js
$(document).on('click', '.pagination a', function(e) {
    e.preventDefault();
    let url = $(this).attr('href');

    $.ajax({
        url: url,
        success: function(data) {
            $('#users-table').html(data);
        }
    });
});
```

#### 9. **Búsqueda con Debounce**
```javascript
let searchTimeout;
$('#search').on('keyup', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function() {
        $('#search-form').submit();
    }, 500);
});
```

#### 10. **Tests Automatizados**
```php
// tests/Feature/UserManagementTest.php
public function test_research_staff_can_create_user()
{
    $researchStaff = User::factory()->researchStaff()->create();

    $response = $this->actingAs($researchStaff)
        ->post('/register', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'role' => 'student',
            'name' => 'John',
            'last_name' => 'Doe',
            // ...
        ]);

    $response->assertRedirect('/users');
    $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
}
```

## 📖 GUÍA DE DESARROLLO

### Configuración del Entorno

1. **Requisitos**:
   - PHP >= 8.2
   - MySQL >= 8.0
   - Composer >= 2.7
   - Node.js >= 18 (opcional, para assets)

2. **Instalación**:
   ```bash
   # Clonar repositorio
   git clone <repo-url>
   cd Backend_ABI

   # Instalar dependencias
   composer install

   # Configurar entorno
   cp .env.example .env
   php artisan key:generate

   # Configurar .env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3307
   DB_DATABASE=BABIFINAL2
   DB_USERNAME=root
   DB_PASSWORD=
   DB_RESEARCH_PASS=
   DB_PROFESSOR_PASS=
   DB_STUDENT_PASS=
   DB_USER_PASS=

   # Crear base de datos
   mysql -uroot -h127.0.0.1 -P3307 -e "CREATE DATABASE BABIFINAL2"

   # Ejecutar migraciones y seeders
   php artisan migrate --seed

   # Aplicar roles MySQL
   bash scripts/set-db-roles.sh

   # Iniciar servidor
   php artisan serve
   ```

3. **Acceso Inicial**:
   - URL: http://127.0.0.1:8000
   - Credenciales de prueba (ver seeders)

### Estructura de Desarrollo

#### Crear Nuevo Módulo (Ejemplo: Projects)

1. **Migración**:
   ```bash
   php artisan make:migration create_projects_table
   ```

2. **Modelo**:
   ```bash
   php artisan make:model Project
   ```

3. **Controlador**:
   ```bash
   php artisan make:controller ProjectController --resource
   ```

4. **Vistas**:
   ```bash
   mkdir resources/views/projects
   touch resources/views/projects/{index,create,edit,show}.blade.php
   ```

5. **Rutas**:
   ```php
   // routes/web.php
   Route::middleware(['auth', 'role:research_staff'])->group(function () {
       Route::resource('projects', ProjectController::class);
   });
   ```

### Convenciones de Código

#### Nombres
- **Modelos**: PascalCase singular (User, Project)
- **Controladores**: PascalCase + Controller (UserController)
- **Vistas**: kebab-case (users/index.blade.php)
- **Rutas**: kebab-case (/users, /city-programs)
- **Variables**: camelCase ($cityPrograms, $user)
- **Métodos**: camelCase (getUserDetails, createProject)

#### Comentarios
- **Todos los comentarios en inglés**
- Comentarios descriptivos para lógica compleja
- PHPDoc en todos los métodos públicos

```php
/**
 * Display a listing of users with advanced filters.
 *
 * Supports filtering by role, state, city_program_id and full-text search.
 * Search includes: email, ID, name, last_name, and card_id.
 *
 * @param Request $request The HTTP request with filter parameters
 * @return View The users index view with paginated results
 */
public function index(Request $request): View
{
    // Implementation
}
```
**Última Actualización**: Octubre 2025
**Versión del Documento**: 1.0
**Autor**: Jose Andres Herrera.
