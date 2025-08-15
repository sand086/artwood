<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id('equipo_id');
            $table->string('nombre')->comment('El dato nombre del Equipo');
            $table->string('descripcion', 1048)->comment('El dato descripcion del Equipo');
            $table->unsignedBigInteger('unidad_medida_id')->comment('FK a la tabla unidadesmedidas');
            $table->decimal('precio_unitario',10,2)->comment('El dato precio unitario del Equipo');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
            // Define Foreign Key Constraint
            $table->foreign('unidad_medida_id', 'fk_equipos_unidad_medida_id')
                  ->references('unidad_medida_id') // PK column in 'unidadesmedidas'
                  ->on('unidadesmedidas')          // The referenced table
                  ->onDelete('restrict')         // Prevent deleting unit if equipos use it (or use 'cascade', 'set null')
                  ->onUpdate('cascade');          // Action on update
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        // Drop foreign key constraint BEFORE dropping the table
        Schema::table('equipos', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign('fk_equipos_unidad_medida_id');
        });
        // Drop the equipos table
        Schema::dropIfExists('equipos');
    }
};