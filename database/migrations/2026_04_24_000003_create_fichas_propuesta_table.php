<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * MÓDULO: Ficha de Propuesta de Tema al Banco de Proyectos Docentes — Estudiante 3
 *
 * TODO: Completar las columnas con los campos reales del formato físico.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fichas_propuesta', function (Blueprint $table) {
            $table->id();

            // Relaciones — ajustar según el diseño definitivo
            $table->foreignId('professor_id')->nullable()->constrained('professors')->nullOnDelete();
            $table->foreignId('programa_id')->nullable()->constrained('programs')->nullOnDelete();
            $table->foreignId('linea_investigacion_id')->nullable()->constrained('investigation_lines')->nullOnDelete();
            $table->foreignId('area_tematica_id')->nullable()->constrained('thematic_areas')->nullOnDelete();

            // --- TODO: Ajustar columnas según el formato físico ---
            $table->string('titulo_propuesta');
            $table->text('descripcion');
            $table->text('objetivos');
            $table->date('fecha_propuesta');
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada'])->default('pendiente');
            // --- Fin columnas placeholder ---

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fichas_propuesta');
    }
};
