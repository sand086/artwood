<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizacionesresponsables', function (Blueprint $table) {
            $table->id('cotizacion_responsable_id');
            $table->unsignedBigInteger('cotizacion_solicitud_id')->comment('El ID de la solicitud de cotización asociado desde la tabla cotizacionessolicitudes');
            $table->unsignedBigInteger('empleado_id')->comment('El ID del empleado responssaable asociada desde la tabla empleados');
            $table->unsignedBigInteger('area_id')->comment('El ID del area asociada desde la tabla areas');
            $table->string('responsabilidad')->comment('El dato responsabilidad del CotizacionesResponsables');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
            // Define Foreign Key Constraints
            $table->foreign('cotizacion_solicitud_id', 'fk_cotizacionesresponsables_cotizacion_solicitud_id')
                  ->references('cotizacion_solicitud_id') 
                  ->on('cotizacionessolicitudes') 
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('empleado_id', 'fk_cotizacionesresponsables_empleado_id')
                  ->references('empleado_id') 
                  ->on('empleados') 
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('area_id', 'fk_cotizacionesresponsables_area_id')
                  ->references('area_id') 
                  ->on('areas') 
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        // Drop foreign keys first to avoid constraint errors
        Schema::table('cotizacionesresponsables', function (Blueprint $table) {
            $table->dropForeign('fk_cotizacionesresponsables_cotizacion_solicitud_id');
            $table->dropForeign('fk_cotizacionesresponsables_empleado_id');
            $table->dropForeign('fk_cotizacionesresponsables_area_id');
        });
        // Drop the table
        Schema::dropIfExists('cotizacionesresponsables');
    }
};