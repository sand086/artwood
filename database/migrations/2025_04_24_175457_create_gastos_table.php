<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->id('gasto_id');
            $table->string('nombre')->comment('El dato nombre del Gastos');
            $table->unsignedBigInteger('tipo_gasto_id')->comment('El ID del tipo de gasto asociado desde la tabla tipogastos');
            $table->unsignedBigInteger('unidad_medida_id')->comment('El ID de la unidad de medida asociado desde la tabla unidadesmedidas');
            $table->decimal('valor_unidad', 10, 2)->comment('El dato valor de la unidad del Gastos');
            $table->integer('cantidad')->comment('El dato cantidad del Gastos');
            $table->decimal('valor_total', 10, 2)->comment('El dato valor total del Gastos');
            $table->unsignedBigInteger('usuario_id')->comment('El ID del usuario asociado desde la tabla usuarios');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
            // Define Foreign Key Constraints
            $table->foreign('unidad_medida_id', 'fk_gastos_unidad_medida_id')
                  ->references('unidad_medida_id') 
                  ->on('unidadesmedidas') 
                  ->onDelete('restrict')
                  ->onUpdate('cascade');          
            $table->foreign('tipo_gasto_id', 'fk_gastos_tipo_gasto_id')
                  ->references('tipo_gasto_id') 
                  ->on('tiposgastos')  
                  ->onDelete('restrict')
                  ->onUpdate('cascade'); 
            $table->foreign('usuario_id', 'fk_gastos_usuario_id')   
                  ->references('usuario_id') 
                  ->on('usuarios')  
                  ->onDelete('restrict') 
                  ->onUpdate('cascade'); 
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        // Drop foreign keys first to avoid constraint errors
        Schema::table('gastos', function (Blueprint $table) {
            $table->dropForeign('fk_gastos_unidad_medida_id');
            $table->dropForeign('fk_gastos_tipo_gasto_id');
            $table->dropForeign('fk_gastos_usuario_id');
        });
        // Drop the table
        Schema::dropIfExists('gastos');
    }
};