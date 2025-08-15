<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id('proveedor_id');
            $table->string('nombre')->comment('El dato nombre del Proveedor');
            $table->enum('tipo', ['EMPRESA', 'PERSONA'])->default('PERSONA')->comment('El dato del tipo de proveedor: EMPRESA o PERSONA');
            $table->string('rfc', 16)->default('PENDIENTE')->comment('El dato RFC del Proveedor');
            $table->string('direccion')->comment('El dato direccion del Proveedor');
            $table->string('codigo_postal', 8)->default('00000000')->comment('El dato del codigo postal de la direccion del Proveedor');
            $table->string('colonia', 255)->nullable()->comment('El dato colonia del Proveedor');
            $table->unsignedBigInteger('municipio_id')->nullable()->comment('El ID del municipio asociado desde la tabla municipios');
            $table->unsignedBigInteger('estado_pais_id')->nullable()->comment('El ID del estado_pais asociado desde la tabla estados_paises');
            $table->string('telefono', 50)->comment('El dato telefono del Proveedor');
            $table->string('sitio_web', 150)->nullable()->comment('El dato sitio_web del Proveedor');
            $table->string('notas_adicionales', 2048)->nullable()->comment('El dato notas_adicionales del Proveedor');
            $table->unsignedBigInteger('usuario_id')->comment('El ID del usuario asociado desde la tabla usuarios');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
            // Define Foreign Key Constraints
            $table->foreign('municipio_id', 'fk_proveedores_municipio_id')
                  ->references('municipio_id')
                  ->on('municipios')
                  ->onDelete('restrict') // Prevent deleting municipio if providers are linked
                  ->onUpdate('cascade');

            $table->foreign('estado_pais_id', 'fk_proveedores_estado_pais_id')
                  ->references('estado_pais_id')
                  ->on('estadospaises')
                  ->onDelete('restrict') // Prevent deleting state if providers are linked
                  ->onUpdate('cascade');

            $table->foreign('usuario_id', 'fk_proveedores_usuario_id')
                  ->references('usuario_id')
                  ->on('usuarios')
                  ->onDelete('restrict') // Prevent deleting user if they created providers (or set null/cascade if appropriate)
                  ->onUpdate('cascade');
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        // Drop foreign keys before dropping the table
        Schema::table('proveedores', function (Blueprint $table) {
            $table->dropForeign('fk_proveedores_municipio_id');
            $table->dropForeign('fk_proveedores_estado_pais_id');
            $table->dropForeign('fk_proveedores_usuario_id');
        });

        Schema::dropIfExists('proveedores');
    }
};