<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estadospaises', function (Blueprint $table) {
            $table->id('estado_pais_id');
            $table->string('nombre')->comment('El dato nombre del EstadosPaises');
            $table->unsignedBigInteger('pais_id')->comment('FK a la tabla paises');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
            // Definir la clave foránea para pais_id
            $table->foreign('pais_id', 'fk_estadospaises_pais_id') // Nombre opcional para la restricción
                  ->references('pais_id') // Columna referenciada en la tabla 'paises'
                  ->on('paises')          // Tabla referenciada
                  ->onDelete('restrict')  // Acción en caso de eliminación (restrict, cascade, set null)
                  ->onUpdate('cascade');
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        // Eliminar la clave foránea ANTES de eliminar la tabla
        Schema::table('estadospaises', function (Blueprint $table) {
            // Usar el nombre específico si se definió uno, sino Laravel puede inferirlo
            $table->dropForeign('fk_estadospaises_pais_id');
            // Alternativamente, si no se dio nombre específico:
            // $table->dropForeign(['pais_id']);
        });
        
        Schema::dropIfExists('estadospaises');
    }
};