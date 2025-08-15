<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizacionesanalisis', function (Blueprint $table) {
            $table->id('cotizacion_analisis_id');
            $table->unsignedBigInteger('cotizacion_solicitud_id')->comment('El dato ID de la solicitud de cotizacion');
            $table->unsignedBigInteger('tipo_proyecto_id')->comment('El dato ID del tipo de proyecto');
            $table->string('descripcion_solicitud', 2048)->comment('El dato descripcion de la solicitud del proyecto');
            $table->tinyInteger('tiempo_total')->default(0)->comment('El dato del tiempo total estimado en dias de la ejecucion del proyecto');
            $table->decimal('costo_subtotal',10,2)->default(0)->comment('El dato del costo subtotal del proyecto');
            $table->decimal('impuesto_iva',4,2)->default(0)->comment('El dato del impuesto iva del proyecto');
            $table->decimal('costo_total',10,2)->default(0)->comment('El dato del costo total del proyecto');
            $table->tinyInteger('control_version')->default(1)->comment('El dato control de version');
            $table->unsignedBigInteger('usuario_id')->comment('El dato DI del usuario');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
            // Define Foreign Key Constraints
            $table->foreign('cotizacion_solicitud_id', 'fk_cotizacionesanalisis_cotizacion_solicitud_id')
                ->references('cotizacion_solicitud_id') 
                ->on('cotizacionessolicitudes') 
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreign('usuario_id', 'fk_cotizacionesanalisis_usuario_id')
                ->references('usuario_id') 
                ->on('usuarios') 
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreign('tipo_proyecto_id', 'fk_cotizacionesanalisis_tipo_proyecto_id')
                ->references('tipo_proyecto_id') 
                ->on('tiposproyectos') 
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
        
    }
    // $table->timestamps();

    public function down(): void
    {
        // Drop foreign keys first to avoid constraint errors
        Schema::table('cotizacionesanalisis', function (Blueprint $table) {
            $table->dropForeign('fk_cotizacionesanalisis_cotizacion_solicitud_id');
            $table->dropForeign('fk_cotizacionesanalisis_usuario_id');
            $table->dropForeign('fk_cotizacionesanalisis_tipo_proyecto_id');
        });
        // Drop the table
        Schema::dropIfExists('cotizacionesanalisis');
    }
};