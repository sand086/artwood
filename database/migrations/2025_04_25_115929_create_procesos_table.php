<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procesos', function (Blueprint $table) {
            $table->id('proceso_id');
            $table->string('nombre')->comment('El dato nombre del Procesos');
            $table->string('descripcion', 1024)->comment('El dato descripcion del Procesos');
            $table->decimal('presupuesto_estimado', 10, 2)->comment('El dato presupuesto estimado del Procesos');
            $table->timestamp('fecha_estimada')->nullable()->comment('El dato fecha estimada del Procesos');
            $table->string('comentarios', 2048)->nullable()->comment('El dato comentarios del Procesos');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        Schema::dropIfExists('procesos');
    }
};