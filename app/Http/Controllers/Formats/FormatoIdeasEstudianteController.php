<?php

namespace App\Http\Controllers\Formats;

use App\Http\Controllers\Controller;
use App\Models\IdeasEstudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormatoIdeasEstudianteController extends Controller
{
    public function index()
    {
        $ideas = IdeasEstudiante::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('formats.ideas-estudiante.index', compact('ideas'));
    }

    public function create()
    {
        return view('formats.ideas-estudiante.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'docente' => 'nullable|string|max:255',
            'concepto' => 'nullable|in:aprobada,no_aprobada',

            'observaciones' => 'nullable|string',
            'numero_acta' => 'nullable|string|max:100',
            'vobo' => 'nullable|string|max:100',
        ]);

        $validated['viabilidad'] = $request->has('viabilidad');
        $validated['pertinencia'] = $request->has('pertinencia');
        $validated['disponibilidad_docentes'] = $request->has('disponibilidad_docentes');
        $validated['calidad_titulo_objetivos'] = $request->has('calidad_titulo_objetivos');

        $validated['user_id'] = Auth::id();

        IdeasEstudiante::create($validated);

        return redirect()->route('formatos.ideas-estudiante.index')
            ->with('success', 'Idea registrada correctamente.');
    }

    public function show(IdeasEstudiante $ideasEstudiante)
    {
        return view('formats.ideas-estudiante.show', compact('ideasEstudiante'));
    }

    public function edit(IdeasEstudiante $ideasEstudiante)
    {
        return view('formats.ideas-estudiante.edit', compact('ideasEstudiante'));
    }

    public function update(Request $request, IdeasEstudiante $ideasEstudiante)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'docente' => 'nullable|string|max:255',
            'concepto' => 'nullable|in:aprobada,no_aprobada',

            'observaciones' => 'nullable|string',
            'numero_acta' => 'nullable|string|max:100',
            'vobo' => 'nullable|string|max:100',
        ]);

        $validated['viabilidad'] = $request->has('viabilidad');
        $validated['pertinencia'] = $request->has('pertinencia');
        $validated['disponibilidad_docentes'] = $request->has('disponibilidad_docentes');
        $validated['calidad_titulo_objetivos'] = $request->has('calidad_titulo_objetivos');

        $ideasEstudiante->update($validated);

        return redirect()->route('formatos.ideas-estudiante.index')
            ->with('success', 'Idea actualizada correctamente.');
    }

    public function destroy(IdeasEstudiante $ideasEstudiante)
    {
        $ideasEstudiante->delete();

        return redirect()->route('formatos.ideas-estudiante.index')
            ->with('success', 'Idea eliminada.');
    }
}