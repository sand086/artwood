<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Define las categorías permitidas EXACTAMENTE como quieres que se almacenen
        $categoriasPermitidas = [
            'MASA',
            'VOLUMEN',
            'LONGITUD',
            'CANTIDAD',
            'SUPERFICIE',
            'TIEMPO',
            // Añade otras si son necesarias
        ];

        Schema::create('unidadesmedidas', function (Blueprint $table) use ($categoriasPermitidas) {
            $table->id('unidad_medida_id');
            $table->string('nombre')->comment('El dato nombre de la Unidad de Medida');
            $table->enum('categoria', $categoriasPermitidas)->nullable()->comment('Categoría de la unidad de medida');
            $table->string('simbolo', 5)->comment('El dato simbolo de la Unidad de Medida');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');

            $table->index('categoria');
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unidadesmedidas');
    }
};