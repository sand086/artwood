<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id('servicio_id');
            $table->string('nombre')->comment('El dato nombre del Servicio');
            $table->string('descripcion', 1048)->comment('El dato descripcion del Servicio');
            $table->tinyInteger('tiempo', 3)->comment('El dato tiempo del Servicio');
            $table->unsignedBigInteger('unidad_medida_id')->comment('El ID de la unidad_medida asociado desde la tabla unidades_medidas');
            $table->decimal('precio',10,2)->comment('El dato precio del Servicios');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
            // Define Foreign Key Constraint
            $table->foreign('unidad_medida_id', 'fk_servicios_unidad_medida_id')
                  ->references('unidad_medida_id') // Assumes 'unidad_medida_id' is the PK in 'unidadesmedidas'
                  ->on('unidadesmedidas')
                  ->onDelete('restrict') // Prevent deleting unit if services use it (or use 'cascade', 'set null')
                  ->onUpdate('cascade'); // Action on update
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        Schema::table('servicios', function (Blueprint $table) {
            // Drop foreign keys first to avoid constraint errors
            // Laravel can infer the constraint name from the column name
            $table->dropForeign('fk_servicios_unidad_medida_id');
        });

        Schema::dropIfExists('servicios');
    }
};