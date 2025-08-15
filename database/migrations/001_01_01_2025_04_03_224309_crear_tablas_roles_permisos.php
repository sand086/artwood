<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('permisos', function (Blueprint $table) {
            $table->id('permission_id');
            $table->string('name')->comment('El nombre del permiso');
            $table->string('guard_name')->comment('El guard name del permiso');
            // Campos adicionales
            $table->string('descripcion')->nullable()->comment('Descripción del permiso');
            $table->char('estado', 1)->default('A')->comment('A: Activo, I: Inactivo, E: Eliminado');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');

            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });
        Schema::create('roles', function (Blueprint $table) {
            $table->id('role_id');
            $table->string('name')->comment('El nombre del rol');
            $table->string('guard_name')->comment('El guard name del rol');
            // Campos adicionales
            $table->string('descripcion')->nullable()->comment('Descripción del rol');
            $table->char('estado', 1)->default('A')->comment('A: Activo, I: Inactivo, E: Eliminado');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');

            $table->unique(['name', 'guard_name']);
        });
        Schema::create('modelo_tiene_permisos', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->index(['model_id', 'model_type'], 'idx_modelo_permiso');
            $table->foreign('permission_id')->references('permission_id')->on('permisos')->onDelete('cascade');
            $table->primary(['permission_id', 'model_id', 'model_type'], 'pk_modelo_permiso');
        });
        Schema::create('modelo_tiene_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->index(['model_id', 'model_type'], 'idx_modelo_rol');
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade');
            $table->primary(['role_id', 'model_id', 'model_type'], 'pk_modelo_rol');
        });
        Schema::create('rol_tiene_permisos', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');
            $table->foreign('permission_id')->references('permission_id')->on('permisos')->onDelete('cascade');
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade');
            $table->primary(['permission_id', 'role_id'], 'pk_role_permission');
        });
    }

    public function down(): void {
        Schema::dropIfExists('rol_tiene_permisos');
        Schema::dropIfExists('modelo_tiene_roles');
        Schema::dropIfExists('modelo_tiene_permisos');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permisos');
    }
};