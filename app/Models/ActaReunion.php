<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActaReunion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'actas_reunion';

    protected $fillable = [
        /*
        |--------------------------------------------------------------------------
        | RELACIONES
        |--------------------------------------------------------------------------
        */

        'project_id',
        'elaborado_por',

        /*
        |--------------------------------------------------------------------------
        | INFORMACIÓN GENERAL
        |--------------------------------------------------------------------------
        */

        'tema_agenda_propuesta',
        'investigador_nombre',
        'grupo_investigacion',
        'programa_academico',
        'fecha_realizacion',
        'medio_ubicacion',
        'hora_inicial',
        'hora_finaliza',
        'orden_dia',

        /*
        |--------------------------------------------------------------------------
        | ASISTENTES
        |--------------------------------------------------------------------------
        */

        'asistentes_listado',
        'docentes_asistentes',
        'estudiantes_asistentes',

        /*
        |--------------------------------------------------------------------------
        | DESARROLLO DE LA REUNIÓN
        |--------------------------------------------------------------------------
        */

        'desarrollo_reunion',

        /*
        |--------------------------------------------------------------------------
        | PLAN DE ACCIÓN
        |--------------------------------------------------------------------------
        */

        'actividades',
        'responsable',
        'fecha_limite',
        'evidencia',

        /*
        |--------------------------------------------------------------------------
        | EFICACIA DE LA REUNIÓN
        |--------------------------------------------------------------------------
        */

        'eficacia_reunion',

        /*
        |--------------------------------------------------------------------------
        | PRÓXIMA REUNIÓN
        |--------------------------------------------------------------------------
        */

        'proxima_reunion_fecha',
        'proxima_reunion_lugar',
        'proxima_reunion_hora',

        /*
        |--------------------------------------------------------------------------
        | FIRMAS
        |--------------------------------------------------------------------------
        */

        'preparado_por',
        'aprobado_por',
        'revisado_por',
        'aprobado_por_director',
    ];

    protected $casts = [
        'fecha_realizacion' => 'date',
        'fecha_limite' => 'date',
        'proxima_reunion_fecha' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function elaboradoPor()
    {
        return $this->belongsTo(User::class, 'elaborado_por');
    }
}