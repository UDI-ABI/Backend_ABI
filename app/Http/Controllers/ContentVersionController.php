<?php

namespace App\Http\Controllers;

use App\Models\ContentVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContentVersionController extends Controller
{
    /**
     * Lista los valores diligenciados por contenido y versión
     *
     * Permite filtrar por version_id, content_id, project_id y búsqueda de texto.
     */
    public function index(Request $request)
    {
        try {
            // Validar y obtener parámetro de paginación
            $perPage = (int) $request->query('per_page', 15);
            $perPage = $perPage > 0 ? min($perPage, 100) : 15;

            // Construir query base con relaciones
            $query = ContentVersion::query()->with(['content', 'version.project']);

            // Aplicar filtros si existen
            if ($versionId = $request->query('version_id')) {
                $query->where('version_id', $versionId);
            }

            if ($contentId = $request->query('content_id')) {
                $query->where('content_id', $contentId);
            }

            if ($projectId = $request->query('project_id')) {
                $query->whereHas('version', function ($q) use ($projectId) {
                    $q->where('project_id', $projectId);
                });
            }

            // Búsqueda por valor
            if ($search = trim((string) $request->query('search', ''))) {
                $query->where('value', 'like', '%' . $search . '%');
            }

            // Obtener resultados paginados
            $contentVersions = $query
                ->orderByDesc('updated_at')
                ->paginate($perPage)
                ->withQueryString();

            // 🔹 Retornar vista de listado con Tablar
            return view('content-versions.index', compact('contentVersions'));

        } catch (\Exception $e) {
            Log::error('Error al listar versiones de contenido: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Ocurrió un error al obtener los registros.');
        }
    }

    /**
     * Registra un nuevo valor de contenido para una versión
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'content_id' => 'required|integer|exists:contents,id',
                'version_id' => 'required|integer|exists:versions,id',
                'value' => 'required|string|max:255',
            ]);

            return DB::transaction(function () use ($data) {
                $contentVersion = ContentVersion::create($data);

                Log::info('Versión de contenido creada', [
                    'content_version_id' => $contentVersion->id,
                    'content_id' => $contentVersion->content_id,
                    'version_id' => $contentVersion->version_id,
                    'user_id' => auth()->id(),
                ]);

                return redirect()
                    ->route('content-versions.index')
                    ->with('success', 'Contenido diligenciado correctamente.');
            });
        } catch (\Exception $e) {
            Log::error('Error al crear versión de contenido: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Ocurrió un error al crear el registro.');
        }
    }

    /**
     * Muestra el formulario de edición de un registro
     */
    public function edit(ContentVersion $contentVersion)
    {
        return view('content-versions.edit', compact('contentVersion'));
    }

    /**
     * Actualiza el valor de un contenido para una versión
     */
    public function update(Request $request, ContentVersion $contentVersion)
    {
        try {
            $data = $request->validate([
                'content_id' => 'required|integer|exists:contents,id',
                'version_id' => 'required|integer|exists:versions,id',
                'value' => 'required|string|max:255',
            ]);

            return DB::transaction(function () use ($contentVersion, $data) {
                $contentVersion->update($data);

                Log::info('Versión de contenido actualizada', [
                    'content_version_id' => $contentVersion->id,
                    'content_id' => $contentVersion->content_id,
                    'version_id' => $contentVersion->version_id,
                    'user_id' => auth()->id(),
                ]);

                return redirect()
                    ->route('content-versions.index')
                    ->with('success', 'Registro actualizado correctamente.');
            });
        } catch (\Exception $e) {
            Log::error('Error al actualizar versión de contenido: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el registro.');
        }
    }

    /**
     * Elimina lógicamente (soft delete) un registro contenido-versión
     */
    public function destroy(ContentVersion $contentVersion)
    {
        try {
            return DB::transaction(function () use ($contentVersion) {
                if ($contentVersion->trashed()) {
                    return redirect()
                        ->route('content-versions.index')
                        ->with('warning', 'El registro ya fue eliminado.');
                }

                $contentVersion->delete();

                Log::info('Versión de contenido eliminada', [
                    'content_version_id' => $contentVersion->id,
                    'content_id' => $contentVersion->content_id,
                    'version_id' => $contentVersion->version_id,
                    'user_id' => auth()->id(),
                ]);

                return redirect()
                    ->route('content-versions.index')
                    ->with('success', 'Registro eliminado correctamente.');
            });
        } catch (\Exception $e) {
            Log::error('Error al eliminar versión de contenido: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el registro.');
        }
    }

    /**
     * Restaura un registro contenido-versión eliminado
     */
    public function restore(int $id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $contentVersion = ContentVersion::withTrashed()->findOrFail($id);

                if (!$contentVersion->trashed()) {
                    return redirect()
                        ->route('content-versions.index')
                        ->with('warning', 'El registro no está eliminado.');
                }

                $contentVersion->restore();

                Log::info('Versión de contenido restaurada', [
                    'content_version_id' => $contentVersion->id,
                    'content_id' => $contentVersion->content_id,
                    'version_id' => $contentVersion->version_id,
                    'user_id' => auth()->id(),
                ]);

                return redirect()
                    ->route('content-versions.index')
                    ->with('success', 'Registro restaurado correctamente.');
            });
        } catch (\Exception $e) {
            Log::error('Error al restaurar versión de contenido: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Ocurrió un error al restaurar el registro.');
        }
    }
}
