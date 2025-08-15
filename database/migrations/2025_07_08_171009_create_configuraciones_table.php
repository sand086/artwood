<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuraciones', function (Blueprint $table) {
            $table->id('configuracion_id');
            $table->string('nombre', 256)->comment('El dato nombre de la Configuracion');
            $table->string('clave', 256)->unique()->comment('El dato clave de la Configuracion');
            $table->string('valor', 2048)->comment('El dato valor de la Configuracion');
            $table->enum('tipo_dato', ['string','text','integer','decimal','date'])->comment('El dato tipo de dato de la Configuracion');
            $table->datetime('fecha_inicio_vigencia')->comment('El dato fecha inicio vigencia de la Configuracion');
            $table->datetime('fecha_fin_vigencia')->comment('El dato fecha fin vigencia de la Configuracion');
            $table->string('descripcion', 2048)->comment('El dato descripcion de la Configuracion');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        Schema::dropIfExists('configuraciones');
    }
};