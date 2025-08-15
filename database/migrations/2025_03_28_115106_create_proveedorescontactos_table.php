<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedorescontactos', function (Blueprint $table) {
            $table->id('proveedor_contacto_id');
            $table->unsignedBigInteger('proveedor_id')->comment('FK to proveedores table');
            $table->unsignedBigInteger('persona_id')->comment('FK to personas table');
            $table->string('cargo')->comment('El dato cargo del ProveedoresContactos');
            $table->string('telefono')->comment('El dato telefono del ProveedoresContactos');
            $table->string('correo_electronico')->comment('El dato correo_electronico del ProveedoresContactos');
            $table->string('observaciones')->nullable()->comment('El dato observaciones del ProveedoresContactos');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
            // Define Foreign Key Constraints
            $table->foreign('proveedor_id', 'fk_proveedorescontatos_proveedor_id')
                  ->references('proveedor_id') // Assumes 'proveedor_id' is the PK in 'proveedores'
                  ->on('proveedores')
                  ->onDelete('cascade') // Action on delete
                  ->onUpdate('cascade'); // Action on update

            $table->foreign('persona_id', 'fk_proveedorescontatos_persona_id')
                  ->references('persona_id') // Assumes 'persona_id' is the PK in 'personas'
                  ->on('personas')
                  ->onDelete('cascade') // Action on delete (consider 'restrict' or 'set null' if cascade is too destructive)
                  ->onUpdate('cascade'); // Action on update
        });
    }
    // $table->timestamps();

    public function down(): void
    {

        Schema::table('proveedorescontactos', function (Blueprint $table) {
            // Drop foreign keys first to avoid constraint errors
            // Laravel can often infer the constraint name from the column name
            $table->dropForeign('fk_proveedorescontatos_proveedor_id');
            $table->dropForeign('fk_proveedorescontatos_persona_id');
        });

        Schema::dropIfExists('proveedorescontactos');
    }
};