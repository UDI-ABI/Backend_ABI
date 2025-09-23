<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departamentos = Department::all();
        return view('departments.index', compact('deprtaments'));
    }

    public function create()
    {
        return view('deparaments.create');
        
    }
    
    public function obtenerCiudades($departamentoId)
    {
        $ciudades = City::where('id', $departamentoId)->pluck('city', 'id')->toArray();
        return response()->json($ciudades);
    }

    public function ciudadesPorDepartamento($id)
    {
        // Obtener las ciudades relacionadas con el departamento
        $departamento = Department::findOrFail($id);
        $ciudades = $departamento->ciudades()->pluck('city', 'id')->toArray();
    
        // Devolver las ciudades en formato JSON
        return response()->json($ciudades);
    }
    
    public function nuevoMetodoCiudades($id)
    {
        $ciudades = City::where('id', $id)->pluck('city', 'id')->toArray();
        return response()->json($ciudades);
    }
    

    public function store(Request $request)
    {
        Department::create($request->all());
        return redirect()->route('departments.index')->with('success', 'Departamento creado correctamente');
    }

    public function show($id)
    {
        $departamento = Department::findOrFail($id);
        return view('departments.show', compact('department'));
    }

    public function edit($id)
    {
        $departamento = Department::findOrFail($id);
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $departamento = Department::findOrFail($id);
        $departamento->update($request->all());
        return redirect()->route('departments.index')->with('success', 'Departamento actualizado correctamente');
    }

    public function destroy($id)
    {
        $departamento = Department::findOrFail($id);
        $departamento->delete();
        return redirect()->route('departments.index')->with('success', 'Departamento eliminado correctamente');
    }
}
