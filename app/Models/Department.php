<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments'; // Especifica el nombre de la tabla en la base de datos

    protected $primaryKey = 'id'; // Especifica el nombre de la clave primaria en la tabla

    protected $fillable = ['name']; // Especifica los campos que se pueden asignar de forma masiva

    // Relación con el modelo Ciudad
    public function cities()
    {
        return $this->hasMany(City::class, 'id'); // Indica el nombre del modelo Ciudad y el nombre de la clave externa
    }

    // Método para obtener las ciudades por departamento
    public function ciudadesPorDepartamento(Request $request)
    {
        // Validar que se haya proporcionado un ID de departamento
        $request->validate([
            'id' => 'required|exists:departamento,id'
        ]);

        // Obtener el ID del departamento enviado desde la solicitud
        $departamentoId = $request->input('id');

        // Obtener las ciudades relacionadas con el departamento
        $ciudades = City::where('id', $departamentoId)->pluck('city', 'id')->toArray();

        // Devolver las ciudades en formato JSON
        return response()->json($ciudades);
    } 
}
