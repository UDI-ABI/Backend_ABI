<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * MÓDULO: Ficha de Propuesta de Tema al Banco de Proyectos Docentes — Estudiante 3
 *
 * TODO: Ajustar $fillable con los campos reales del formato físico.
 * TODO: Agregar relaciones con Professor, Program, InvestigationLine, ThematicArea.
 */
class FichaPropuesta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fichas_propuesta';

    protected $fillable = [
        // TODO: Completar con todos los campos del formato físico
        'professor_id',
        'programa_id',
        'titulo_propuesta',
        'descripcion',
        'objetivos',
        'linea_investigacion_id',
        'area_tematica_id',
        'fecha_propuesta',
        'estado',
    ];

    protected $casts = [
        'fecha_propuesta' => 'date',
    ];

    // TODO: Descomentar y ajustar relaciones según el diseño final
    // public function professor()
    // {
    //     return $this->belongsTo(Professor::class);
    // }

    // public function programa()
    // {
    //     return $this->belongsTo(Program::class, 'programa_id');
    // }

    // public function lineaInvestigacion()
    // {
    //     return $this->belongsTo(InvestigationLine::class, 'linea_investigacion_id');
    // }

    // public function areaTematica()
    // {
    //     return $this->belongsTo(ThematicArea::class, 'area_tematica_id');
    // }
}
