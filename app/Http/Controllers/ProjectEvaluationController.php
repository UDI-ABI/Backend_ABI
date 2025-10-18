<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Content;
use App\Models\Version;
use App\Models\ContentVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectEvaluationController extends Controller
{
    /**
     * Muestra los proyectos pendientes de aprobación.
     */
    public function index()
    {
        // Solo proyectos en estado “Pendiente de aprobación”
        // (ajusta el ID según tu tabla project_statuses)
        $pendingProjects = Project::whereHas('status', function ($query) {
            $query->where('name', 'Pendiente de aprobación');
        })->get();

        return view('project_evaluation.index', compact('pendingProjects'));
    }

    /**
     * Procesa la evaluación de un proyecto.
     * - Aprobado o Rechazado → solo cambia el estado.
     * - Devuelto para corrección → crea un nuevo ContentVersion con comentarios.
     */
    public function evaluate(Request $request, $projectId)
    {
        $request->validate([
            'status' => 'required|string|in:Aprobado,Rechazado,Devuelto para corrección',
            'comments' => 'nullable|string',
        ]);

        $project = Project::findOrFail($projectId);

        DB::beginTransaction();

        try {
            // Buscar ID del nuevo estado
            $newStatusId = DB::table('project_statuses')
                ->where('name', $request->status)
                ->value('id');

            if (!$newStatusId) {
                throw new \Exception("No se encontró el estado '{$request->status}'");
            }

            // Si el estado es "Devuelto para corrección"
            if ($request->status === 'Devuelto para corrección') {
                // Última versión
                $latestVersion = $project->versions()->latest('created_at')->first();

                if (!$latestVersion) {
                    throw new \Exception("No se encontró una versión previa para este proyecto");
                }

                // Buscar contenido “Comentarios” del comité
                $commentContent = Content::where('name', 'Comentarios')
                    ->where('role', 'committee_leader')
                    ->first();

                if (!$commentContent) {
                    throw new \Exception("No se encontró el contenido 'Comentarios' para committee_leader");
                }

                // Crear nueva relación en content_version
                ContentVersion::create([
                    'version_id' => $latestVersion->id,
                    'content_id' => $commentContent->id,
                    'value' => $request->comments ?: 'Sin comentarios',
                ]);
            }

            // Actualizar estado del proyecto
            $project->update(['project_status_id' => $newStatusId]);

            DB::commit();

            return redirect()->back()->with('success', 'Evaluación registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
