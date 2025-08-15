<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tokens_usuarios', function (Blueprint $table) {
            $table->id('token_usuario_id');

            // Clave foránea a la tabla usuarios
            $table->unsignedBigInteger('usuario_id')
                ->comment('Relacion a tabla usuarios');

            // Definir la clave foránea correctamente
            $table->foreign('usuario_id')
                ->references('usuario_id') // La clave primaria en la tabla usuarios
                ->on('usuarios') // La tabla a la que referencia
                ->onDelete('cascade') // Si el usuario se borra, se eliminan sus tokens
                ->onUpdate('cascade'); // Si se actualiza el ID del usuario, se actualiza aquí también

            $table->string('token', 400)->unique();

            $table->enum('estado', ['A', 'I', 'E'])
                ->default('A')
                ->nullable(false)
                ->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');

            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens_usuarios');
    }
};
