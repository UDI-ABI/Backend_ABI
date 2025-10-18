<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Content;
use App\Models\ContentVersion;
use App\Models\Professor;
use App\Models\ProjectStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectEvaluationController extends Controller
{
    /**
     * Muestra los proyectos pendientes para el líder de comité autenticado.
     */
    public function index()
    {
        // 1️⃣ Obtener el registro del profesor asociado al usuario autenticado (líder de comité)
        $professor = Professor::where('user_id', Auth::id())
            ->where('committee_leader', true)
            ->whereNull('deleted_at') // evitar profesores soft-deleted
            ->first();

        // 2️⃣ Validar que tenga city_program_id
        if (!$professor || !$professor->city_program_id) {
            abort(403, 'No se pudo determinar el programa del líder de comité.');
        }

        $cityProgramId = $professor->city_program_id;

        // 3️⃣ Filtrar proyectos según city_program del profesor líder
        $projects = Project::whereHas('projectStatus', function ($query) {
                $query->where('name', 'Pendiente de aprobación');
            })
            ->where(function ($query) use ($cityProgramId) {
                $query->whereHas('students', function ($sub) use ($cityProgramId) {
                    $sub->where('city_program_id', $cityProgramId);
                })
                ->orWhereHas('professors', function ($sub) use ($cityProgramId) {
                    $sub->where('city_program_id', $cityProgramId);
                });
            })
            ->with([
                'projectStatus',
                'thematicArea.investigationLine',
                'versions.contentVersions.content',
                'contentFrameworkProjects.contentFramework.framework',
                'students',
                'professors'
            ])
            ->get();

        return view('projects.evaluation.index', compact('projects'));
    }

   // app/Http/Controllers/ProjectEvaluationController.php

    public function show(Project $project)
    {
        // Cargar relaciones necesarias
        $project->load([
            'projectStatus',
            'thematicArea.investigationLine',
            'versions.contentVersions.content',
            'contentFrameworkProjects.contentFramework.framework',
            'students',
            'professors',
        ]);

        // Última versión del proyecto
        $latestVersion = $project->versions()->latest('created_at')->first();

        return view('projects.evaluation.show', compact('project', 'latestVersion'));
    }

    public function evaluate(Request $request, Project $project)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:Aprobado,Rechazado,Devuelto para corrección',
            'comments' => 'nullable|string',
        ]);

        $statusName = $validated['status'];

        // Buscar estado correspondiente
        $status = ProjectStatus::where('name', $statusName)->first();
        if (!$status) {
            return back()->with('error', 'No se encontró el estado seleccionado.');
        }

        // Actualizar estado del proyecto
        $project->update(['project_status_id' => $status->id]);

        // Si se devolvió para corrección, crear ContentVersion
        if ($statusName === 'Devuelto para corrección') {
            $latestVersion = $project->versions()->latest('created_at')->first();

            if ($latestVersion) {
                $commentContent = Content::where('name', 'Comentarios')
                    ->where('role', 'committee_leader')
                    ->first();

                if ($commentContent) {
                    ContentVersion::create([
                        'version_id' => $latestVersion->id,
                        'content_id' => $commentContent->id,
                        'value' => $validated['comments'] ?? 'Sin comentarios',
                    ]);
                }
            }
        }

        return redirect()
            ->route('projects.evaluation.index')
            ->with('success', "Evaluación del proyecto '{$project->title}' enviada correctamente.");
    }

}
