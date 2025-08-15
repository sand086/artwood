<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedoresmateriales', function (Blueprint $table) {
            $table->id('proveedor_material_id');
            $table->unsignedBigInteger('proveedor_id')->comment('El ID del proveedor asociado desde la tabla proveedores');
            $table->unsignedBigInteger('material_id')->comment('El ID del material asociado desde la tabla materiales');
            $table->string('descripcion')->comment('El dato descripcion del Material del Proveedor');
            $table->unsignedBigInteger('unidad_medida_id')->comment('FK a la tabla unidadesmedidas');
            $table->decimal('precio_unitario',10,2)->comment('El dato precio unitario del Material');
            $table->string('detalle', 2048)->comment('El dato detalle del Material del Proveedor');
            $table->unsignedInteger('stock')->default(0)->comment('El dato stock del Material del Proveedor');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');

            // Definición de las Claves Foráneas
            // Constraint para proveedor_id referenciando la tabla proveedores
            $table->foreign('proveedor_id', 'fk_proveedoresmateriales_proveedor_id')
                  ->references('proveedor_id') // Asegúrate que 'proveedor_id' es la PK en 'proveedores'
                  ->on('proveedores')
                  ->onDelete('cascade') // Acción al eliminar (puede ser 'restrict', 'set null', etc.)
                  ->onUpdate('cascade'); // Acción al actualizar
            // Constraint para material_id referenciando la tabla materiales
            $table->foreign('material_id', 'fk_proveedoresmateriales_material_id')
                  ->references('material_id') // Asegúrate que 'material_id' es la PK en 'materiales'
                  ->on('materiales')
                  ->onDelete('cascade') // Acción al eliminar
                  ->onUpdate('cascade'); // Acción al actualizar
            
            // Constraint
            $table->foreign('unidad_medida_id', 'fk_proveedoresmateriales_unidad_medida_id')
                ->references('unidad_medida_id')
                ->on('unidadesmedidas')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        Schema::table('proveedoresmateriales', function (Blueprint $table) {
            // Eliminar las claves foráneas ANTES de eliminar la tabla
            // Laravel infiere el nombre de la restricción si solo pasas el nombre de la columna
            $table->dropForeign('fk_proveedoresmateriales_proveedor_id');
            $table->dropForeign('fk_proveedoresmateriales_material_id');
            $table->dropForeign('fk_proveedoresmateriales_unidad_medida_id');
        });
        // Eliminar la tabla
        Schema::dropIfExists('proveedoresmateriales');
    }
};