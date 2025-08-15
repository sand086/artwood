<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizacionesdocumentos', function (Blueprint $table) {
            $table->id('cotizacion_documento_id');
            $table->string('cotizacion_solicitud_id')->comment('El dato cotizacion_solicitud_id del CotizacionesDocumentos');
            $table->string('nombre_documento_original')->comment('El dato nombre_documento_original del CotizacionesDocumentos');
            $table->string('nombre_documento_sistema')->comment('El dato nombre_documento_sistema del CotizacionesDocumentos');
            $table->string('descripcion', 2048)->nullable()->comment('El dato descripcion del CotizacionesDocumentos');
            $table->string('ruta_almacenamiento')->comment('El dato ruta_almacenamiento del CotizacionesDocumentos');
            $table->string('tipo_mime',100)->comment('El dato tipo_mime del CotizacionesDocumentos');
            $table->integer('tamano_bytes')->comment('El dato tamano_bytes del CotizacionesDocumentos');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable()->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        Schema::dropIfExists('cotizacionesdocumentos');
    }
};