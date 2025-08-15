<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procesosactividades', function (Blueprint $table) {
            $table->id('proceso_actividad_id');
            $table->string('nombre')->comment('El dato nombre de la Actividad');
            $table->string('descripcion', 1024)->comment('El dato descripcion de la Actividad');
            $table->unsignedBigInteger('proceso_id')->comment('El ID del proceso asociado desde la tabla procesos');
            $table->unsignedBigInteger('area_id')->comment('El ID del area responsable asociado desde la tabla areas');
            $table->unsignedBigInteger('unidad_medida_id')->comment('El ID del usuario asociado desde la tabla unidadesmedidas');
            $table->integer('tiempo_estimado')->comment('El dato tiempo estimado de la Actividad');
            $table->decimal('costo_estimado', 10, 2)->comment('El dato costo estimado de la Actividad');
            $table->string('riesgos', 2048)->nullable()->comment('El dato riesgos de la Actividad');
            $table->string('observaciones', 2048)->nullable()->comment('El dato observaciones de la Actividad');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
            // Define Foreign Key Constraints
            $table->foreign('proceso_id', 'fk_procesosactividades_proceso_id')
                  ->references('proceso_id') 
                  ->on('procesos') 
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('area_id', 'fk_procesosactividades_area_id')
                  ->references('area_id') 
                  ->on('areas') 
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('unidad_medida_id', 'fk_procesosactividades_unidad_medida_id')
                  ->references('unidad_medida_id') 
                  ->on('unidadesmedidas') 
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        // Drop foreign keys first to avoid constraint errors
        Schema::table('procesosactividades', function (Blueprint $table) {
            $table->dropForeign('fk_procesosactividades_proceso_id');
            $table->dropForeign('fk_procesosactividades_area_id');
            $table->dropForeign('fk_procesosactividades_unidad_medida_id');
        });
        // Drop the table
        Schema::dropIfExists('procesosactividades');
    }
};