<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plantillas', function (Blueprint $table) {
            $table->id('plantilla_id');
            $table->string('nombre')->comment('El dato nombre de la Plantilla');
            $table->string('clave')->unique()->comment('El dato clave de la Plantilla');
            $table->string('modulo')->comment('El dato modulo de la Plantilla');
            $table->enum('tipo', ['PDF', 'EMAIL', 'CONTRATO'])->comment('El dato tipo de la Plantilla');
            $table->enum('formato', ['PDF', 'EXCEL', 'WORD'])->comment('El dato formato del documento a generar');
            $table->enum('origen_datos', ['TABLA', 'CONSULTA', 'FUNCION'])->comment('El dato origen de datos de la Plantilla');
            $table->string('fuente_datos')->nullable()->comment('El dato fuente tabla: nombre; consulta: SQL base64; funcion: nombre_registrado de datos de la Plantilla');
            $table->text('html')->comment('El dato contenido html de la Plantilla');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        Schema::dropIfExists('plantillas');
    }
};