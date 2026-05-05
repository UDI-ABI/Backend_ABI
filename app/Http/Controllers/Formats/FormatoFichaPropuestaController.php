<?php

namespace App\Http\Controllers\Formats;

use App\Http\Controllers\Controller;
use App\Models\FichaPropuesta;
use Illuminate\Http\Request;

/**
 * MÓDULO: Ficha de Propuesta de Tema al Banco de Proyectos Docentes
 * RESPONSABLE: Estudiante 3
 *
 * TODO: Completar todos los métodos con la lógica de negocio correspondiente.
 * TODO: Analizar el formato físico para definir los campos exactos.
 * TODO: Vincular con el banco de proyectos aprobados (BankApprovedIdeasForProfessorsController).
 */
class FormatoFichaPropuestaController extends Controller
{
    public function index()
    {
        // TODO: Filtrar fichas por el profesor autenticado o por programa
        $fichas = FichaPropuesta::latest()->paginate(10);

        return view('formats.ficha-propuesta.index', compact('fichas'));
    }

    public function create()
    {
        // TODO: Pasar al view datos de programas, líneas de investigación, áreas temáticas
        return view('formats.ficha-propuesta.create');
    }

    public function store(Request $request)
    {
        // TODO: Validar y persistir la ficha
        $validated = $request->validate([
            // TODO: Ajustar según los campos del formato físico
            'titulo_propuesta'       => 'required|string|max:255',
            'descripcion'            => 'required|string',
            'objetivos'              => 'required|string',
            'fecha_propuesta'        => 'required|date',
            'linea_investigacion_id' => 'required|exists:investigation_lines,id',
            'area_tematica_id'       => 'required|exists:thematic_areas,id',
        ]);

        // TODO: Asociar el professor_id y programa_id del usuario autenticado
        FichaPropuesta::create($validated);

        return redirect()->route('formatos.ficha-propuesta.index')
            ->with('success', 'Ficha de propuesta creada exitosamente.');
    }

    public function show(FichaPropuesta $fichaPropuesta)
    {
        return view('formats.ficha-propuesta.show', compact('fichaPropuesta'));
    }

    public function edit(FichaPropuesta $fichaPropuesta)
    {
        return view('formats.ficha-propuesta.edit', compact('fichaPropuesta'));
    }

    public function update(Request $request, FichaPropuesta $fichaPropuesta)
    {
        $validated = $request->validate([
            'titulo_propuesta'       => 'required|string|max:255',
            'descripcion'            => 'required|string',
            'objetivos'              => 'required|string',
            'fecha_propuesta'        => 'required|date',
            'linea_investigacion_id' => 'required|exists:investigation_lines,id',
            'area_tematica_id'       => 'required|exists:thematic_areas,id',
        ]);

        $fichaPropuesta->update($validated);

        return redirect()->route('formatos.ficha-propuesta.index')
            ->with('success', 'Ficha de propuesta actualizada.');
    }

    public function destroy(FichaPropuesta $fichaPropuesta)
    {
        $fichaPropuesta->delete();

        return redirect()->route('formatos.ficha-propuesta.index')
            ->with('success', 'Ficha de propuesta eliminada.');
    }
}
