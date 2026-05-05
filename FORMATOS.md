# Módulo de Formatos — Guía para el equipo

## Contexto
El módulo de formatos gestiona los tres documentos institucionales que genera el área de investigación para los proyectos de grado:

| Formato | Responsable | Rol(es) que lo usan |
|---|---|---|
| Acta de Reunión | Estudiante 1 | professor, committee_leader, research_staff |
| Formato de Ideas de Estudiante | Estudiante 2 | student, research_staff |
| Ficha de Propuesta de Tema al Banco de Proyectos Docentes | Estudiante 3 | professor, committee_leader, research_staff |

---

## Estructura creada (scaffolding)

```
app/Http/Controllers/Formats/
├── FormatoActaReunionController.php        ← Estudiante 1
├── FormatoIdeasEstudianteController.php    ← Estudiante 2
└── FormatoFichaPropuestaController.php     ← Estudiante 3

app/Models/
├── ActaReunion.php                         ← Estudiante 1
├── IdeasEstudiante.php                     ← Estudiante 2
└── FichaPropuesta.php                      ← Estudiante 3

database/migrations/
├── 2026_04_24_000001_create_actas_reunion_table.php
├── 2026_04_24_000002_create_ideas_estudiante_table.php
└── 2026_04_24_000003_create_fichas_propuesta_table.php

resources/views/formats/
├── index.blade.php                         ← Hub del módulo (todas las tarjetas)
├── acta-reunion/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── ideas-estudiante/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
└── ficha-propuesta/
    ├── index.blade.php
    ├── create.blade.php
    ├── edit.blade.php
    └── show.blade.php
```

---

## Rutas disponibles

| Método | URI | Nombre | Acceso |
|---|---|---|---|
| GET | `/formatos` | `formatos.index` | Todos los roles |
| GET | `/formatos/acta-reunion` | `formatos.acta-reunion.index` | professor, committee_leader, research_staff |
| GET | `/formatos/acta-reunion/create` | `formatos.acta-reunion.create` | ídem |
| POST | `/formatos/acta-reunion` | `formatos.acta-reunion.store` | ídem |
| GET | `/formatos/acta-reunion/{id}` | `formatos.acta-reunion.show` | ídem |
| GET | `/formatos/acta-reunion/{id}/edit` | `formatos.acta-reunion.edit` | ídem |
| PUT | `/formatos/acta-reunion/{id}` | `formatos.acta-reunion.update` | ídem |
| DELETE | `/formatos/acta-reunion/{id}` | `formatos.acta-reunion.destroy` | ídem |
| (misma estructura) | `/formatos/ideas-estudiante/...` | `formatos.ideas-estudiante.*` | student, research_staff |
| (misma estructura) | `/formatos/ficha-propuesta/...` | `formatos.ficha-propuesta.*` | professor, committee_leader, research_staff |

---

## Pasos para empezar (cada estudiante)

### 1. Haz pull del repositorio del líder

```bash
git pull origin main
```

### 2. Instala dependencias y configura el entorno

```bash
composer install
npm install
cp .env.example .env        # Si no tienes .env
php artisan key:generate
```

### 3. Corre las migraciones

```bash
php artisan migrate
```

Si necesitas resetear todo:
```bash
php artisan migrate:fresh --seed
```

### 4. Levanta el servidor de desarrollo

```bash
php artisan serve    # Terminal 1
npm run dev          # Terminal 2
```

---

## Qué debe hacer cada estudiante

### Estudiante 1 — Acta de Reunión

**Archivos a editar:**
- `app/Http/Controllers/Formats/FormatoActaReunionController.php`
- `app/Models/ActaReunion.php`
- `database/migrations/2026_04_24_000001_create_actas_reunion_table.php`
- `resources/views/formats/acta-reunion/*.blade.php`

**Tareas:**
1. Analizar el formato físico del Acta de Reunión
2. Agregar las columnas reales en la migración (buscar los `TODO` en el archivo)
3. Actualizar `$fillable` en el modelo con los campos definitivos
4. Actualizar las reglas de validación en el controlador
5. Actualizar las vistas (formularios y vistas de detalle) con los campos reales
6. Agregar las relaciones con `Project` y `User` en el modelo si aplica
7. (Opcional avanzado) Exportar el acta a PDF usando `barryvdh/laravel-dompdf`

---

### Estudiante 2 — Formato de Ideas de Estudiante

**Archivos a editar:**
- `app/Http/Controllers/Formats/FormatoIdeasEstudianteController.php`
- `app/Models/IdeasEstudiante.php`
- `database/migrations/2026_04_24_000002_create_ideas_estudiante_table.php`
- `resources/views/formats/ideas-estudiante/*.blade.php`

**Tareas:**
1. Analizar el formato físico del Formato de Ideas de Estudiante
2. Agregar las columnas reales en la migración
3. Actualizar `$fillable` en el modelo con los campos definitivos
4. En el método `store`, asociar automáticamente el `student_id` del usuario autenticado:
   ```php
   $validated['student_id'] = auth()->user()->student->id;
   ```
5. Actualizar validaciones y vistas con los campos reales
6. Decidir si el formato se vincula a un `project_id` existente o es previo al proyecto

---

### Estudiante 3 — Ficha de Propuesta de Tema

**Archivos a editar:**
- `app/Http/Controllers/Formats/FormatoFichaPropuestaController.php`
- `app/Models/FichaPropuesta.php`
- `database/migrations/2026_04_24_000003_create_fichas_propuesta_table.php`
- `resources/views/formats/ficha-propuesta/*.blade.php`

**Tareas:**
1. Analizar el formato físico de la Ficha de Propuesta
2. Agregar las columnas reales en la migración
3. Actualizar `$fillable` en el modelo
4. En `create()`, pasar al view las líneas de investigación y áreas temáticas:
   ```php
   use App\Models\InvestigationLine;
   use App\Models\ThematicArea;

   public function create()
   {
       $lineas = InvestigationLine::all();
       $areas  = ThematicArea::all();
       return view('formats.ficha-propuesta.create', compact('lineas', 'areas'));
   }
   ```
5. En el view, descomentar los `@foreach` en los `<select>` para poblarlos dinámicamente
6. Asociar automáticamente el `professor_id` del usuario autenticado en `store()`

---

## Convenciones del proyecto que debes respetar

### Autenticación
- Usa siempre `AuthUserHelper::fullUser()` para obtener el usuario con sus relaciones:
  ```php
  use App\Helpers\AuthUserHelper;
  $user = AuthUserHelper::fullUser();
  $user->professor; // relación eager-loaded
  ```
- No uses `Auth::user()` directamente cuando necesitas relaciones del usuario.

### Modelos con rol específico
- Si el CRUD es **exclusivo de un rol**, considera usar los modelos role-scoped en vez del modelo base:
  - `app/Models/Professor/` para operaciones de professor
  - `app/Models/Student/` para operaciones de student
  - `app/Models/ResearchStaff/` para operaciones de research_staff
- Estos modelos sobrescriben `$connection` para usar credenciales de BD con permisos limitados.

### Vistas
- Todas las vistas extienden `tablar::page`.
- Usa clases de Tabler/Bootstrap 5 (`card`, `table-vcenter`, `btn-ghost-*`, etc.).
- Los mensajes flash de sesión van en `session('success')` y `session('error')`.

### Validaciones
- Todas las validaciones van en el controlador (métodos `store` y `update`).
- Si la validación crece mucho, crea un Form Request en `app/Http/Requests/Formats/`.

---

## Flujo de trabajo en Git

```bash
# Crea tu rama antes de empezar
git checkout -b feature/formato-acta-reunion    # Estudiante 1
git checkout -b feature/formato-ideas-estudiante # Estudiante 2
git checkout -b feature/formato-ficha-propuesta  # Estudiante 3

# Trabaja en tu módulo, haz commits frecuentes
git add .
git commit -m "feat: agregar campos del formato físico al acta de reunión"

# Cuando termines, abre un PR contra la rama del líder
git push origin feature/formato-acta-reunion
```

---

## Preguntas frecuentes

**¿Puedo cambiar los nombres de columnas de la migración?**
Sí. Las columnas actuales son placeholders. Renómbralas según los campos del formato físico real. Solo asegúrate de que el modelo y las vistas queden consistentes.

**¿Qué pasa si el formato físico tiene campos que no encajan en texto plano?**
- Listas de items → usa `text` en BD y guarda como JSON, o crea una tabla relacionada
- Archivos/firmas → considera `string` para ruta de archivo + FilePond en el frontend
- Checkboxes/selects → usa `enum` o `boolean` según corresponda

**¿Dónde agrego lógica de negocio compleja?**
En `app/Services/`. Mira `app/Services/Projects/` como referencia.
