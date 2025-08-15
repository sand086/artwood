<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiposrecursos', function (Blueprint $table) {
            $table->id('tipo_recurso_id');
            $table->string('nombre')->comment('El dato nombre del Tipo Recurso');
            $table->string('descripcion', 1024)->comment('El dato descripcion del Tipo Recurso');
            $table->string('tabla_referencia', 100)->nullable()->comment('El dato nombre de la tabla de referencia del Tipo Recurso');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiposrecursos');
    }
};