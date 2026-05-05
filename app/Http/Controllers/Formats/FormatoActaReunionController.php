<?php

namespace App\Http\Controllers\Formats;

use App\Http\Controllers\Controller;
use App\Models\ActaReunion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormatoActaReunionController extends Controller
{
    public function index()
    {
        $actas = ActaReunion::latest()->paginate(10);

        return view('formats.acta-reunion.index', compact('actas'));
    }

    public function create()
    {
        return view('formats.acta-reunion.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN GENERAL
            |--------------------------------------------------------------------------
            */

            'tema_agenda_propuesta' => 'required|string',
            'investigador_nombre' => 'required|string|max:255',
            'grupo_investigacion' => 'required|string|max:255',
            'programa_academico' => 'required|string|max:255',
            'fecha_realizacion' => 'required|date',
            'medio_ubicacion' => 'required|string|max:255',
            'hora_inicial' => 'nullable',
            'hora_finaliza' => 'nullable',
            'orden_dia' => 'nullable|string',

            /*
            |--------------------------------------------------------------------------
            | ASISTENTES
            |--------------------------------------------------------------------------
            */

            'asistentes_listado' => 'nullable|string',
            'docentes_asistentes' => 'nullable|string',
            'estudiantes_asistentes' => 'nullable|string',

            /*
            |--------------------------------------------------------------------------
            | DESARROLLO DE LA REUNIÓN
            |--------------------------------------------------------------------------
            */

            'desarrollo_reunion' => 'nullable|string',

            /*
            |--------------------------------------------------------------------------
            | PLAN DE ACCIÓN
            |--------------------------------------------------------------------------
            */

            'actividades' => 'nullable|string',
            'responsable' => 'nullable|string|max:255',
            'fecha_limite' => 'nullable|date',
            'evidencia' => 'nullable|string',

            /*
            |--------------------------------------------------------------------------
            | EFICACIA DE LA REUNIÓN
            |--------------------------------------------------------------------------
            */

            'eficacia_reunion' => 'nullable|integer|min:0|max:100',

            /*
            |--------------------------------------------------------------------------
            | PRÓXIMA REUNIÓN
            |--------------------------------------------------------------------------
            */

            'proxima_reunion_fecha' => 'nullable|date',
            'proxima_reunion_lugar' => 'nullable|string|max:255',
            'proxima_reunion_hora' => 'nullable',

            /*
            |--------------------------------------------------------------------------
            | FIRMAS
            |--------------------------------------------------------------------------
            */

            'preparado_por' => 'nullable|string|max:255',
            'aprobado_por' => 'nullable|string|max:255',
            'revisado_por' => 'nullable|string|max:255',
            'aprobado_por_director' => 'nullable|string|max:255',
        ]);

        // Guardar usuario autenticado automáticamente
        $validated['elaborado_por'] = Auth::id();

        ActaReunion::create($validated);

        return redirect()
            ->route('formatos.acta-reunion.index')
            ->with('success', 'Acta de reunión creada exitosamente.');
    }

    public function show(ActaReunion $actaReunion)
    {
        return view('formats.acta-reunion.show', compact('actaReunion'));
    }

    public function edit(ActaReunion $actaReunion)
    {
        return view('formats.acta-reunion.edit', compact('actaReunion'));
    }

    public function update(Request $request, ActaReunion $actaReunion)
    {
        $validated = $request->validate([
            'tema_agenda_propuesta' => 'required|string',
            'investigador_nombre' => 'required|string|max:255',
            'grupo_investigacion' => 'required|string|max:255',
            'programa_academico' => 'required|string|max:255',
            'fecha_realizacion' => 'required|date',
            'medio_ubicacion' => 'required|string|max:255',
            'eficacia_reunion' => 'nullable|integer|min:0|max:100',
        ]);

        $actaReunion->update($validated);

        return redirect()
            ->route('formatos.acta-reunion.index')
            ->with('success', 'Acta de reunión actualizada correctamente.');
    }

    public function destroy(ActaReunion $actaReunion)
    {
        $actaReunion->delete();

        return redirect()
            ->route('formatos.acta-reunion.index')
            ->with('success', 'Acta de reunión eliminada correctamente.');
    }
    public function exportPdf(ActaReunion $actaReunion)
{
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'formats.acta-reunion.pdf',
        compact('actaReunion')
    );

    return $pdf->download('acta_reunion_' . $actaReunion->id . '.pdf');
}
}