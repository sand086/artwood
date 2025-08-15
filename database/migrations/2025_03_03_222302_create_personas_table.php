<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id('persona_id');
            $table->string('nombres', 150)->comment('El dato nombres de la Personas');
            $table->string('apellidos', 150)->comment('El dato apellidos de la Personas');
            $table->unsignedBigInteger('tipo_identificacion_id')->default(1)->comment('El ID del tipo de identificador asociado al registro');
            $table->string('identificador', 50)->nullable()->comment('El dato identificador de la Persona');
            $table->string('telefono', 30)->comment('El dato telefono de la Personas');
            $table->string('correo_electronico', 150)->comment('El dato correo electronico de la Personas');
            $table->string('direccion', 255)->comment('El dato direccion de la Personas');
            $table->string('colonia', 255)->nullable()->comment('El dato colonia de la Personas');
            $table->unsignedBigInteger('estado_pais_id')->nullable()->comment('El ID del Estado Pais asociado al registro');
            $table->unsignedBigInteger('municipio_id')->nullable()->comment('El dato del ID Municipio asociado al registro');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
            // Define Foreign Key Constraints
            $table->foreign('tipo_identificacion_id', 'fk_personas_tipo_identificacion_id')
                  ->references('tipo_identificacion_id') 
                  ->on('tiposidentificaciones') 
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('estado_pais_id', 'fk_personas_estado_pais_id')
                  ->references('estado_pais_id') 
                  ->on('estadospaises') 
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('municipio_id', 'fk_personas_municipio_id')
                  ->references('municipio_id') 
                  ->on('municipios') 
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        // Define Foreign Key Constraints
        // Schema::table('personas', function (Blueprint $table) {
        //     $table->foreign('tipo_identificacion_id', 'fk_personas_tipo_identificacion_id')
        //           ->references('tipo_identificacion_id') 
        //           ->on('tiposidentificaciones') 
        //           ->onDelete('restrict')
        //           ->onUpdate('cascade');
        // });
    }
    // $table->timestamps();

    public function down(): void
    {
        // Drop foreign keys first to avoid constraint errors
        Schema::table('personas', function (Blueprint $table) {
            $table->dropForeign('fk_personas_estado_pais_id');
            $table->dropForeign('fk_personas_municipio_id');
            $table->dropForeign('fk_personas_tipo_identificacion_id');
        });
        // Drop the personas table
        Schema::dropIfExists('personas');
    }
};