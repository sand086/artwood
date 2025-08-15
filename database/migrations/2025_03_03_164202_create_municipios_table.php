<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('municipios', function (Blueprint $table) {
            $table->id('municipio_id');
            $table->string('nombre')->comment('El dato nombre del Municipios');
            $table->string('codigo_postal')->comment('El dato codigo_postal del Municipios');
            $table->unsignedBigInteger('estado_pais_id')->comment('FK a la tabla estadospaises'); 

            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
            // Define Foreign Key Constraint for estado_pais_id
            $table->foreign('estado_pais_id', 'fk_municipios_estado_pais_id') // Optional: Define a specific constraint name
                  ->references('estado_pais_id') // The primary key column in the referenced table
                  ->on('estadospaises')          // The referenced table
                  ->onDelete('restrict')         // Action on delete (e.g., restrict, cascade, set null)
                  ->onUpdate('cascade');
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        // Drop foreign key constraint BEFORE dropping the table
        Schema::table('municipios', function (Blueprint $table) {
            // Use the specific name if defined, otherwise let Laravel infer
            $table->dropForeign('fk_municipios_estado_pais_id'); 
            // Alternatively, if no specific name was given during creation:
            // $table->dropForeign(['estado_pais_id']); 
        });
        
        Schema::dropIfExists('municipios');
    }
};