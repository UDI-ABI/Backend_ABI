<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $table = 'cities'; // Especifica el nombre de la tabla en la base de datos

    protected $primaryKey = 'id'; // Especifica el nombre de la clave primaria en la tabla

    protected $fillable = ['name']; // Especifica los campos que se pueden asignar de forma masiva



    
    // Relación con el modelo Departamento
    public function department()
    {
        return $this->belongsTo(Department::class, 'id'); // Indica el nombre del modelo Departamento y el nombre de la clave externa
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'city_program');
    }

}