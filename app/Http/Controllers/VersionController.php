<?php

namespace App\Http\Controllers;

use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VersionController extends Controller
{
    /**
     * Lista las versiones registradas con filtros
     *
     * Permite filtrar por project_id y paginar resultados.
     */
    public function index(Request $request)
    {
        try {
            // Validar y obtener parámetro de paginación
            $perPage = (int) $request->query('per_page', 15);
            $perPage = $perPage > 0 ? min($perPage, 100) : 15;

            // Query base con relaciones
            $query = Version::query()->with('project');

            // Filtrar por proyecto si se especifica
            if ($projectId = $request->query('project_id')) {
                $query->where('project_id', $projectId);
            }

            // Obtener resultados paginados
            $versions = $query
                ->orderByDesc('created_at')
                ->paginate($perPage)
                ->withQueryString();

            // 🔹 Retornar la vista en lugar de JSON
            return view('versions.index', compact('versions'));

        } catch (\Exception $e) {
            Log::error('Error al listar versiones: ' . $e->getMessage());

            return redirect()->back()->withErrors('Ocurrió un error al obtener las versiones.');
        }
    }

    // --- resto de tu código se mantiene igual ---

    public function store(VersionRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            return DB::transaction(function () use ($data) {
                $version = Version::create($data);

                Log::info('Versión creada', [
                    'version_id' => $version->id,
                    'project_id' => $version->project_id,
                    'user_id' => auth()->id(),
                ]);

                return response()->json([
                    'message' => 'Versión creada correctamente.',
                    'data' => $version->load('project'),
                ], 201);
            });

        } catch (\Exception $e) {
            Log::error('Error al crear versión: ' . $e->getMessage());

            return response()->json([
                'message' => 'Ocurrió un error al crear la versión.',
            ], 500);
        }
    }

    public function show(Version $version): JsonResponse
    {
        try {
            if ($version->trashed()) {
                return response()->json([
                    'message' => 'La versión no está disponible.',
                ], 404);
            }

            $version->load(['project', 'contents' => function ($query) {
                $query->orderBy('name');
            }]);

            return response()->json($version);

        } catch (\Exception $e) {
            Log::error('Error al mostrar versión: ' . $e->getMessage());

            return response()->json([
                'message' => 'Ocurrió un error al obtener la versión.',
            ], 500);
        }
    }

    public function update(VersionRequest $request, Version $version): JsonResponse
    {
        try {
            $data = $request->validated();

            return DB::transaction(function () use ($version, $data) {
                if ($version->trashed()) {
                    return response()->json([
                        'message' => 'No se puede actualizar una versión eliminada.',
                    ], 410);
                }

                $version->update($data);

                Log::info('Versión actualizada', [
                    'version_id' => $version->id,
                    'project_id' => $version->project_id,
                    'user_id' => auth()->id(),
                ]);

                return response()->json([
                    'message' => 'Versión actualizada correctamente.',
                    'data' => $version->load('project'),
                ]);
            });

        } catch (\Exception $e) {
            Log::error('Error al actualizar versión: ' . $e->getMessage());

            return response()->json([
                'message' => 'Ocurrió un error al actualizar la versión.',
            ], 500);
        }
    }

    public function destroy(Version $version): JsonResponse
    {
        try {
            return DB::transaction(function () use ($version) {
                if ($version->trashed()) {
                    return response()->json([
                        'message' => 'La versión ya fue eliminada.',
                    ], 410);
                }

                if ($version->contentVersions()->exists()) {
                    return response()->json([
                        'message' => 'No es posible eliminar la versión porque tiene contenidos diligenciados.',
                    ], 409);
                }

                $version->delete();

                Log::info('Versión eliminada', [
                    'version_id' => $version->id,
                    'project_id' => $version->project_id,
                    'user_id' => auth()->id(),
                ]);

                return response()->json(null, 204);
            });

        } catch (\Exception $e) {
            Log::error('Error al eliminar versión: ' . $e->getMessage());

            return response()->json([
                'message' => 'Ocurrió un error al eliminar la versión.',
            ], 500);
        }
    }

    public function restore(int $id): JsonResponse
    {
        try {
            return DB::transaction(function () use ($id) {
                $version = Version::withTrashed()->findOrFail($id);

                if (!$version->trashed()) {
                    return response()->json([
                        'message' => 'La versión no está eliminada.',
                    ], 400);
                }

                $version->restore();

                Log::info('Versión restaurada', [
                    'version_id' => $version->id,
                    'project_id' => $version->project_id,
                    'user_id' => auth()->id(),
                ]);

                return response()->json([
                    'message' => 'Versión restaurada correctamente.',
                    'data' => $version->load('project'),
                ]);
            });

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'No se encontró la versión especificada.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error al restaurar versión: ' . $e->getMessage());

            return response()->json([
                'message' => 'Ocurrió un error al restaurar la versión.',
            ], 500);
        }
    }
}
