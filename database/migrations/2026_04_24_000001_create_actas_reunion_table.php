<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * MÓDULO: Acta de Reunión — Estudiante 1
 *
 * Formato real basado en:
 * FOR-INV-004 Acta de Reunión
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actas_reunion', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELACIONES
            |--------------------------------------------------------------------------
            */

            // Relación opcional con proyecto
            $table->foreignId('project_id')
                ->nullable()
                ->constrained('projects')
                ->nullOnDelete();

            // Usuario que elabora el acta
            $table->foreignId('elaborado_por')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN GENERAL
            |--------------------------------------------------------------------------
            */

            $table->text('tema_agenda_propuesta')->nullable();

            $table->string('investigador_nombre')->nullable();
            $table->string('grupo_investigacion')->nullable();
            $table->string('programa_academico')->nullable();

            $table->date('fecha_realizacion')->nullable();

            $table->string('medio_ubicacion')->nullable();

            $table->time('hora_inicial')->nullable();
            $table->time('hora_finaliza')->nullable();

            $table->text('orden_dia')->nullable();

            /*
            |--------------------------------------------------------------------------
            | ASISTENTES
            |--------------------------------------------------------------------------
            */

            $table->text('asistentes_listado')->nullable();

            $table->text('docentes_asistentes')->nullable();

            $table->text('estudiantes_asistentes')->nullable();

            /*
            |--------------------------------------------------------------------------
            | DESARROLLO DE LA REUNIÓN
            |--------------------------------------------------------------------------
            */

            $table->longText('desarrollo_reunion')->nullable();

            /*
            |--------------------------------------------------------------------------
            | PLAN DE ACCIÓN
            |--------------------------------------------------------------------------
            */

            $table->text('actividades')->nullable();
            $table->string('responsable')->nullable();
            $table->date('fecha_limite')->nullable();
            $table->text('evidencia')->nullable();

            /*
            |--------------------------------------------------------------------------
            | EFICACIA DE LA REUNIÓN
            |--------------------------------------------------------------------------
            */

            $table->integer('eficacia_reunion')->nullable();

            /*
            |--------------------------------------------------------------------------
            | PRÓXIMA REUNIÓN
            |--------------------------------------------------------------------------
            */

            $table->date('proxima_reunion_fecha')->nullable();
            $table->string('proxima_reunion_lugar')->nullable();
            $table->time('proxima_reunion_hora')->nullable();

            /*
            |--------------------------------------------------------------------------
            | FIRMAS
            |--------------------------------------------------------------------------
            */

            $table->string('preparado_por')->nullable();
            $table->string('aprobado_por')->nullable();
            $table->string('revisado_por')->nullable();
            $table->string('aprobado_por_director')->nullable();

            /*
            |--------------------------------------------------------------------------
            | SISTEMA
            |--------------------------------------------------------------------------
            */

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actas_reunion');
    }
};