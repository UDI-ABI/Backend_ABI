<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Student;
use App\Models\ProjectStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class BankApprovedIdeasAssignController extends Controller
{
    /**
     * Muestra la pantalla para seleccionar compañeros antes de tomar una idea aprobada.
     */
    public function select(Project $project)
    {
        $student = Student::where('user_id', Auth::id())
            ->whereNull('deleted_at')
            ->firstOrFail();

        // Validar que el proyecto sea elegible
        if ($project->projectStatus?->name !== 'Aprobado') {
            abort(403, 'Solo puedes seleccionar ideas que estén en estado Aprobado.');
        }

        // Verificar que el estudiante no esté bloqueado por otro proyecto
        $currentStatus = $student->projects()->latest()->first()?->projectStatus?->name;

        if (in_array($currentStatus, ['Asignado', 'Aprobado'])) {
            abort(403, 'Ya tienes un proyecto activo. No puedes seleccionar uno nuevo.');
        }

        // Si tenía proyectos en “Devuelto para corrección” → moverlos a Rechazado
        if ($currentStatus === 'Devuelto para corrección') {
            $student->projects()->update(['project_status_id' =>
                ProjectStatus::where('name', 'Rechazado')->first()->id
            ]);
        }

        // Obtener compañeros elegibles (solo mismo city_program)
        $availableStudents = Student::query()
            ->where('city_program_id', $student->city_program_id)
            ->where('id', '!=', $student->id)
            ->where(function ($q) {
                $q->whereDoesntHave('projects') // nunca ha tenido proyecto
                  ->orWhereHas('projects.projectStatus', fn($s) =>
                        $s->whereIn('name', ['Rechazado', 'Devuelto para corrección'])
                    );
            })
            ->orderBy('last_name')
            ->orderBy('name')
            ->get();

        return view('projects.student.select', compact('project', 'availableStudents'));
    }

    /**
     * Procesa la asignación del proyecto al estudiante y su equipo.
     */
    public function assign(Request $request, Project $project)
    {
        $student = Student::where('user_id', Auth::id())
            ->whereNull('deleted_at')
            ->firstOrFail();

        $validated = $request->validate([
            'teammate_ids' => ['nullable', 'array', 'max:2'],
            'teammate_ids.*' => [
                'integer',
                Rule::exists('students', 'id')
                    ->where(fn ($q) => $q->where('city_program_id', $student->city_program_id))
            ],
        ]);

        // Validar nuevamente que el proyecto esté disponible
        if ($project->projectStatus?->name !== 'Aprobado') {
            abort(403, 'Este proyecto ya no está disponible para asignación.');
        }

        DB::beginTransaction();

        try {
            // Cambiar el estado del proyecto a “Asignado”
            $assignedStatusId = ProjectStatus::where('name', 'Asignado')->first()->id;
            $project->update(['project_status_id' => $assignedStatusId]);

            // Vincular estudiantes
            $studentIds = collect($validated['teammate_ids'] ?? [])
                ->push($student->id) // siempre incluir al creador
                ->unique()
                ->values()
                ->all();

            $project->students()->syncWithoutDetaching($studentIds);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Error al asignar el proyecto. Intenta de nuevo.');
        }

        return redirect()
            ->route('projects.index')
            ->with('success', 'Proyecto asignado exitosamente. Ahora es tuyo para ejecutar.');
    }
}
