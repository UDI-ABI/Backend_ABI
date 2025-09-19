<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{

    public function getCiudades(Request $request)
{
    $departamento_id = $request->input('id');
    $ciudades = City::where('id', $departamento_id)->pluck('city', 'id')->toArray();
    return response()->json($ciudades);
}

public function obtenerCiudadesPorDepartamento($id)
{
    $ciudades = City::where('id', $id)->get();
    return response()->json($ciudades);
}
public function obtenerCiudades($departamentoId)
{
    $ciudades = City::where('id', $departamentoId)->pluck('city', 'id')->toArray();
    return response()->json($ciudades);
}

    public function index()
    {
        $ciudades = City::all();
        return view('city.index', compact('cities'));
    }

    public function create()
    {
        return view('city.create');
    }

    public function store(Request $request)
    {
        City::create($request->all());
        return redirect()->route('city.index')->with('success', 'Ciudad creada correctamente');
    }

    public function show($id)
    {
        $ciudad = City::findOrFail($id);
        return view('city.show', compact('city'));
    }

    public function edit($id)
    {
        $ciudad = City::findOrFail($id);
        return view('city.edit', compact('city'));
    }

    public function update(Request $request, $id)
    {
        $ciudad = City::findOrFail($id);
        $ciudad->update($request->all());
        return redirect()->route('city.index')->with('success', 'Ciudad actualizada correctamente');
    }

    public function destroy($id)
    {
        $ciudad = City::findOrFail($id);
        $ciudad->delete();
        return redirect()->route('city.index')->with('success', 'Ciudad eliminada correctamente');
    }
}
