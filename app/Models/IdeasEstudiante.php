<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IdeasEstudiante extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ideas_estudiante';

    protected $fillable = [
        'titulo',
        'docente',
        'concepto',
        'viabilidad',
        'pertinencia',
        'disponibilidad_docentes',
        'calidad_titulo_objetivos',
        'observaciones',
        'numero_acta',
        'vobo',
        'user_id'
    ];

    protected $casts = [
        'viabilidad' => 'boolean',
        'pertinencia' => 'boolean',
        'disponibilidad_docentes' => 'boolean',
        'calidad_titulo_objetivos' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES (OPCIONAL PERO RECOMENDADO)
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}