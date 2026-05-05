<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ideas_estudiante', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | INFORMACIÓN BÁSICA
            |--------------------------------------------------------------------------
            */

            $table->string('titulo');
            $table->string('docente')->nullable();

            /*
            |--------------------------------------------------------------------------
            | CONCEPTO DE EVALUACIÓN
            |--------------------------------------------------------------------------
            */

            $table->enum('concepto', ['aprobada', 'no_aprobada'])->nullable();

            /*
            |--------------------------------------------------------------------------
            | CRITERIOS DE EVALUACIÓN
            |--------------------------------------------------------------------------
            */

            $table->boolean('viabilidad')->default(false);
            $table->boolean('pertinencia')->default(false);
            $table->boolean('disponibilidad_docentes')->default(false);
            $table->boolean('calidad_titulo_objetivos')->default(false);

            /*
            |--------------------------------------------------------------------------
            | REGISTRO Y SEGUIMIENTO
            |--------------------------------------------------------------------------
            */

            $table->text('observaciones')->nullable();
            $table->string('numero_acta')->nullable();
            $table->string('vobo')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ideas_estudiante');
    }
};
