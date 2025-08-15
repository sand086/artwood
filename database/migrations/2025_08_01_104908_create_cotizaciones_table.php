<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id('cotizacion_id');
            $table->unsignedBigInteger('cotizacion_solicitud_id')->comment('El dato ID de la Solicitud de la Cotizacion');
            $table->unsignedBigInteger('cliente_contacto_id')->nullable()->comment('El dato ID del Contacto del Cliente de la Cotizacion');
            $table->unsignedBigInteger('empleado_responsable_id')->nullable()->comment('El dato ID del Empleado Responsable de la Cotizacion');
            $table->unsignedBigInteger('plantilla_id')->nullable()->comment('El dato ID de la Plantilla de la Cotizaciones');
            $table->tinyInteger('control_version')->default(1)->comment('El dato control_version de la Cotizacion');
            $table->string('condiciones_comerciales', 4096)->nullable()->comment('El dato condiciones_comerciales del Cotizaciones');
            $table->text('datos_adicionales')->nullable()->comment('El dato datos_adicionales del Cotizaciones');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');

            $table->foreign('cotizacion_solicitud_id', 'fk_cotizacion_solicitud_id_id')
                    ->references('cotizacion_solicitud_id')
                    ->on('cotizacionessolicitudes')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('cliente_contacto_id', 'fk_cotizaciones_cliente_contacto_id')
                    ->references('cliente_contacto_id')
                    ->on('clientescontactos')
                    ->onDelete('set null')
                    ->onUpdate('set null');
            $table->foreign('empleado_responsable_id', 'fk_cotizaciones_empleado_responsable_id')
                    ->references('empleado_id')
                    ->on('empleados')
                    ->onDelete('set null')
                    ->onUpdate('set null');
            $table->foreign('plantilla_id', 'fk_cotizaciones_plantilla_id')
                    ->references('plantilla_id')
                    ->on('plantillas')
                    ->onDelete('set null')
                    ->onUpdate('set null');
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        Schema::table('cotizaciones', function (Blueprint $table) {
            // Eliminar las claves foráneas ANTES de eliminar la tabla
            $table->dropForeign('fk_cotizacion_solicitud_id_id');
            $table->dropForeign('fk_cotizaciones_cliente_contacto_id');
            $table->dropForeign('fk_cotizaciones_empleado_responsable_id');
            $table->dropForeign('fk_cotizaciones_plantilla_id');
        });
        // Eliminar la tabla
        Schema::dropIfExists('cotizaciones');
    }
};