<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasoscotizaciones', function (Blueprint $table) {
            $table->id('paso_cotizacion_id');
            $table->string('nombre')->comment('El dato nombre del Paso Cotizacion');
            $table->string('descripcion')->comment('El dato descripcion del Paso Cotizacion');
            // $table->string('tipo_cliente_id')->comment('El dato tipo_cliente_id del PasosCotizaciones');
            $table->unsignedBigInteger('tipo_cliente_id')->comment('El ID del tipo del cliente asociado desde la tabla tiposclientes');
            $table->string('orden')->comment('El dato orden del Paso Cotizacion');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
            // Define Foreign Key Constraints
            $table->foreign('tipo_cliente_id', 'fk_pasoscotizaciones_tipo_cliente_id')
                  ->references('tipo_cliente_id')
                  ->on('tiposclientes')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        Schema::table('pasoscotizaciones', function (Blueprint $table) {
            // Drop foreign keys first to avoid constraint errors
            // Laravel can often infer the constraint name from the column name
            $table->dropForeign('fk_pasoscotizaciones_tipo_cliente_id');
        });

        Schema::dropIfExists('pasoscotizaciones');
    }
};