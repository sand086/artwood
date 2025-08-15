<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plazoscreditos', function (Blueprint $table) {
            $table->id('plazo_credito_id');
            $table->string('nombre')->comment('El dato nombre del PlazosCreditos');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        Schema::dropIfExists('plazoscreditos');
    }
};