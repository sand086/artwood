<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientescontactos', function (Blueprint $table) {
            $table->id('cliente_contacto_id');
            $table->unsignedBigInteger('cliente_id')->comment('FK a la tabla Clientes');
            $table->unsignedBigInteger('persona_id')->comment('FK a la tabla Personas');
            $table->string('cargo')->nullable()->comment('El dato cargo del Contacto');
            $table->string('telefono')->comment('El dato telefono del Contacto');
            $table->string('correo_electronico')->comment('El dato correo_electronico del Contacto');
            $table->string('observaciones')->nullable()->comment('El dato observaciones del Contacto');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
            // Define Foreign Key Constraints
            $table->foreign('cliente_id', 'fk_clientescontactos_cliente_id')
                  ->references('cliente_id')
                  ->on('clientes')
                  ->onDelete('cascade') // Action on delete
                  ->onUpdate('cascade'); // Action on update

            $table->foreign('persona_id', 'fk_clientescontactos_persona_id')
                  ->references('persona_id') // Assumes 'persona_id' is the PK in 'personas'
                  ->on('personas')
                  ->onDelete('cascade') // Action on delete (consider 'restrict' or 'set null' if cascade is too destructive)
                  ->onUpdate('cascade'); // Action on update
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        Schema::table('clientescontactos', function (Blueprint $table) {
            // Drop foreign keys first to avoid constraint errors
            // Laravel can often infer the constraint name from the column name
            $table->dropForeign('fk_clientescontactos_cliente_id');
            $table->dropForeign('fk_clientescontactos_persona_id');
        });

        Schema::dropIfExists('clientescontactos');
    }
};