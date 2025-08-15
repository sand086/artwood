<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('producto_id');
            $table->string('nombre')->comment('El dato nombre del Productos');
            $table->string('descripcion', 1048)->comment('El dato descripcion del Productos');
            $table->unsignedBigInteger('unidad_medida_id')->comment('FK a la tabla unidadesmedidas');
            $table->decimal('precio_unitario',10,2)->comment('El dato precio_unitario del Productos');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
            // Define Foreign Key Constraint
            $table->foreign('unidad_medida_id', 'fk_productos_unidad_medida_id')
                  ->references('unidad_medida_id') // PK column in 'unidadesmedidas'
                  ->on('unidadesmedidas')          // The referenced table
                  ->onDelete('restrict')         // Prevent deleting unit if products use it (or use 'cascade', 'set null')
                  ->onUpdate('cascade');          // Action on update
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            // Drop foreign key constraint BEFORE dropping the table
            // Laravel can usually infer the constraint name from the column name
            $table->dropForeign('fk_productos_unidad_medida_id');
        });

        Schema::dropIfExists('productos');
    }
};