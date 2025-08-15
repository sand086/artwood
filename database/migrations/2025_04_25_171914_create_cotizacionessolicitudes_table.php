<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizacionessolicitudes', function (Blueprint $table) {
            $table->id('cotizacion_solicitud_id');
            $table->unsignedBigInteger('tipo_solicitud_id')->comment('El ID del tipo solicitud asociado desde la tabla tiposolicitudes');
            $table->unsignedBigInteger('cliente_id')->comment('El ID del cliente asociado desde la tabla clientes');
            $table->unsignedBigInteger('fuente_id')->default(4)->comment('El ID de la fuente asociado desde la tabla fuentes');
            $table->string('consecutivo', 8)->unique()->nullable()->comment('El dato del consecutivo de la Solicitud');
            $table->string('nombre_proyecto')->comment('El dato nombre_proyecto de la Solicitud de Cotizacion');
            $table->string('descripcion', 2048)->comment('El dato descripcion de la Solicitud de Cotizacion');
            $table->timestamp('fecha_estimada')->comment('El dato fecha_estimada de la Solicitud de Cotizacion');
            $table->tinyInteger('control_version')->default(1)->comment('El dato control_version de la Solicitud de Cotizacion');
            $table->unsignedBigInteger('usuario_id')->comment('El ID del usuario asociado desde la tabla usuarios');
            $table->unsignedBigInteger('estado_id')->default(1)->comment('El ID del estado asociado desde la tabla estados');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha_creacion de la Solicitud de Cotizacion');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');

            // Define Foreign Key Constraints
            $table->foreign('tipo_solicitud_id', 'fk_cotizacionessolicitudes_tipo_solicitud_id')
                  ->references('tipo_solicitud_id') 
                  ->on('tipossolicitudes') 
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('cliente_id', 'fk_cotizacionessolicitudes_cliente_id')
                  ->references('cliente_id') 
                  ->on('clientes') 
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('fuente_id', 'fk_cotizacionessolicitudes_fuente_id')
                  ->references('fuente_id') 
                  ->on('fuentes') 
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('usuario_id', 'fk_cotizacionessolicitudes_usuario_id')
                  ->references('usuario_id') 
                  ->on('usuarios') 
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('estado_id', 'fk_cotizacionessolicitudes_estado_id')
                  ->references('estado_general_id') 
                  ->on('estadosgenerales') 
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        // Drop foreign keys first to avoid constraint errors
        Schema::table('cotizacionessolicitudes', function (Blueprint $table) {
            $table->dropForeign('fk_cotizacionessolicitudes_tipo_solicitud_id');
            $table->dropForeign('fk_cotizacionessolicitudes_cliente_id');
            $table->dropForeign('fk_cotizacionessolicitudes_fuente_id');
            $table->dropForeign('fk_cotizacionessolicitudes_usuario_id');
            $table->dropForeign('fk_cotizacionessolicitudes_estado_id');
        });
        // Drop the table
        Schema::dropIfExists('cotizacionessolicitudes');
    }
};