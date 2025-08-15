<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('cliente_id');
            $table->string('nombre')->comment('El dato nombre del Cliente');
            $table->unsignedBigInteger('tipo_cliente_id')->default(1)->comment('El ID del tipo de cliente asociado desde la tabla tiposclientes');
            $table->enum('clase', ['CLIENTE', 'PROSPECTO'])->default('CLIENTE')->comment('El dato de la clase del cliente: CLIENTE o PROSPECTO');
            $table->string('rfc', 16)->default('PENDIENTE')->comment('El dato RFC del Cliente');
            $table->string('direccion')->comment('El dato direccion del Cliente');
            $table->string('codigo_postal', 8)->default('00000000')->comment('El dato del codigo postal de la direccion del Cliente');
            $table->string('colonia', 255)->nullable()->comment('El dato colonia del Cliente');
            $table->unsignedBigInteger('municipio_id')->nullable()->comment('El ID del municipio asociado desde la tabla municipios');
            $table->unsignedBigInteger('estado_pais_id')->nullable()->comment('El ID del estado_pais asociado desde la tabla estados_paises');
            $table->string('telefono')->comment('El dato telefono del Cliente');
            $table->string('sitio_web')->nullable()->comment('El dato sitio_web del Cliente');
            $table->string('notas_adicionales')->nullable()->comment('El dato notas_adicionales del Cliente');
            $table->unsignedBigInteger('usuario_id')->comment('El ID del usuario asociado desde la tabla usuarios');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
            // Define Foreign Key Constraints
            $table->foreign('tipo_cliente_id', 'fk_clientes_tipo_cliente_id')
                  ->references('tipo_cliente_id')
                  ->on('tiposclientes')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            
            $table->foreign('municipio_id', 'fk_clientes_municipio_id')
                  ->references('municipio_id')
                  ->on('municipios')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('estado_pais_id', 'fk_clientes_estado_pais_id')
                  ->references('estado_pais_id')
                  ->on('estadospaises')
                  ->onDelete('restrict') 
                  ->onUpdate('cascade');

            $table->foreign('usuario_id', 'fk_clientes_usuario_id')
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
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign('fk_clientes_tipo_cliente_id');
            $table->dropForeign('fk_clientes_municipio_id');
            $table->dropForeign('fk_clientes_estado_pais_id');
            $table->dropForeign('fk_clientes_usuario_id');
        });

        Schema::dropIfExists('clientes');
    }
};