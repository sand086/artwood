<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedoresequipos', function (Blueprint $table) {
            $table->id('proveedor_equipo_id');
            $table->unsignedBigInteger('proveedor_id')->comment('El ID del proveedor asociado desde la tabla proveedores');
            $table->unsignedBigInteger('equipo_id')->comment('El ID del equipo asociado desde la tabla equipos');
            $table->string('descripcion')->comment('El dato descripcion del Equipo del Proveedor');
            $table->unsignedBigInteger('unidad_medida_id')->comment('FK a la tabla unidadesmedidas');
            $table->decimal('precio_unitario',10,2)->comment('El dato precio unitario del Equipo del Proveedor');
            $table->string('detalle',2048)->comment('El dato detalle del Equipo del Proveedor');
            $table->unsignedInteger('stock')->default(0)->comment('El dato stock del Equipo del Proveedor');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');

            // Definición de las Claves Foráneas
            // Constraint para proveedor_id referenciando la tabla proveedores
            $table->foreign('proveedor_id', 'fk_proveedoresequipos_proveedor_id')
                  ->references('proveedor_id') // Asegúrate que 'proveedor_id' es la PK en 'proveedores'
                  ->on('proveedores')
                  ->onDelete('cascade') // Acción al eliminar (puede ser 'restrict', 'set null', etc.)
                  ->onUpdate('cascade'); // Acción al actualizar
            // Constraint para equipo_id referenciando la tabla equipos
            $table->foreign('equipo_id', 'fk_proveedoresequipos_equipo_id')
                  ->references('equipo_id') // Asegúrate que 'equipo_id' es la PK en 'equipos'
                  ->on('equipos')
                  ->onDelete('cascade') // Acción al eliminar
                  ->onUpdate('cascade'); // Acción al actualizar
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        Schema::table('proveedoresequipos', function (Blueprint $table) {
            // Eliminar las claves foráneas ANTES de eliminar la tabla
            // Laravel infiere el nombre de la restricción si solo pasas el nombre de la columna
            $table->dropForeign('fk_proveedoresequipos_proveedor_id');
            $table->dropForeign('fk_proveedoresequipos_equipo_id');
        });
        // Eliminar la tabla
        Schema::dropIfExists('proveedoresequipos');
    }
};