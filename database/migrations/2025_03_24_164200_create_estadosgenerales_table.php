<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estadosgenerales', function (Blueprint $table) {
            $table->id('estado_general_id');
            $table->string('nombre')->comment('El dato nombre del Estado General');
            $table->enum('categoria', ['SOLICITUD', 'COTIZACION', 'PRESUPUESTO'])->comment('El dato categoria del Estado General');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        Schema::dropIfExists('estadosgenerales');
    }
};