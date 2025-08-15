<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('usuario_id');
            $table->string('nombre')->comment('El dato nombre del Usuarios');
            $table->string('contrasena', 350)->comment('El dato contrasena del Usuarios');
            $table->dateTime('fecha_ultimo_acceso')
                ->nullable()
                ->comment('El dato fecha_ultimo_acceso del Usuarios');
            $table->string('metodo_doble_factor')
                ->default('app')
                ->comment('El dato metodo_doble_factor del Usuarios');
            $table->char('doble_factor')
                ->nullable()
                ->default('')
                ->comment('El dato doble_factor del Usuarios');
            $table->integer('no_intentos')
                ->default(0)
                ->comment('El dato no_intentos del Usuarios');

            // Claves foráneas
            $table->unsignedBigInteger('role_id')->nullable()->comment('El dato role_id del Usuarios');
            $table->unsignedBigInteger('persona_id')->nullable()->comment('El dato persona_id del Usuarios');

            $table->string('IP')
                ->default('Sin IP')
                ->comment('El dato IP del Usuarios');
            $table->enum('estado', ['A', 'I', 'E'])
                ->default('A')
                ->nullable(false)
                ->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');

            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');

            // claves foráneas
            $table->foreign('role_id')
                ->references('role_id') // Ajusta según la clave primaria de la tabla "roles"
                ->on('roles')
                ->onDelete('restrict') // Si se borra el rol, los usuarios asociados también se eliminan
                ->onUpdate('cascade'); // Si el ID del rol cambia, se actualiza aquí

            $table->foreign('persona_id')
                ->references('persona_id') // Ajusta según la clave primaria de la tabla "personas"
                ->on('personas')
                ->onDelete('set null') // Si se borra la persona, los usuarios asociados también se eliminan
                ->onUpdate('cascade');

            $table->string('foto_url', 150)
                ->nullable()
                ->comment('URL de la foto del usuario');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
