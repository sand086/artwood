<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id('empleado_id');
            $table->unsignedBigInteger('persona_id')->comment('FK a la tabla personas'); 
            $table->string('cargo')->comment('El dato cargo del Empleados');
            $table->unsignedBigInteger('usuario_id')->nullable()->comment('FK a la tabla usuarios');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            
            // Define Foreign Key Constraints
            $table->foreign('persona_id', 'fk_empleados_persona_id')
                  ->references('persona_id') // PK column in 'personas'
                  ->on('personas')          // The referenced table
                  ->onDelete('cascade')     // If the person is deleted, delete the employee record
                  ->onUpdate('cascade');     // If the person_id changes, update it here

            $table->foreign('usuario_id', 'fk_empleados_usuario_id')
                  ->references('usuario_id') // PK column in 'usuarios'
                  ->on('usuarios')          // The referenced table
                  ->onDelete('set null')    // If the user is deleted, set employee's usuario_id to NULL
                  ->onUpdate('cascade');
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        Schema::table('empleados', function (Blueprint $table) {
            // Drop foreign key constraints BEFORE dropping the table
            // Laravel can usually infer the constraint name from the column name
            $table->dropForeign('fk_empleados_persona_id');
            $table->dropForeign('fk_empleados_usuario_id');
        });

        Schema::dropIfExists('empleados');
    }
};