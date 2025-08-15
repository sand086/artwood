<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedoresproductos', function (Blueprint $table) {
            $table->id('proveedor_producto_id');
            $table->unsignedBigInteger('proveedor_id')->comment('El ID del proveedor asociado desde la tabla proveedores');
            $table->unsignedBigInteger('producto_id')->comment('El ID del producto asociado desde la tabla productos');
            $table->string('descripcion')->comment('El dato descripcion del Productos');
            $table->unsignedBigInteger('unidad_medida_id')->comment('El ID del unidad de medida asociado desde la tabla unidadesmedidas');
            $table->decimal('precio_unitario',10,2)->comment('El dato precio_unitario del Productos');
            $table->string('detalle', 2048)->nullable()->comment('El dato detalle del Productos');
            $table->unsignedInteger('stock')->default(0)->comment('El dato stock del Producto');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');

            // Definición de las Claves Foráneas
            // Constraint para proveedor_id referenciando la tabla proveedores
            $table->foreign('proveedor_id', 'fk_proveedoresproductos_proveedor_id')
                  ->references('proveedor_id') // Asegúrate que 'proveedor_id' es la PK en 'proveedores'
                  ->on('proveedores')
                  ->onDelete('cascade') // Acción al eliminar (puede ser 'restrict', 'set null', etc.)
                  ->onUpdate('cascade'); // Acción al actualizar

            // Constraint para producto_id referenciando la tabla productos
            $table->foreign('producto_id', 'fk_proveedoresproductos_producto_id')
                  ->references('producto_id') // Asegúrate que 'producto_id' es la PK en 'productos'
                  ->on('productos')
                  ->onDelete('cascade') // Acción al eliminar
                  ->onUpdate('cascade'); // Acción al actualizar
            
            // Constraint para unidad_medida_id referenciando la tabla unidadesmedidas
            $table->foreign('unidad_medida_id', 'fk_proveedoresproductos_unidad_medida_id')
                  ->references('unidad_medida_id')
                  ->on('unidadesmedidas')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        Schema::table('proveedoresproductos', function (Blueprint $table) {
            // Eliminar las claves foráneas ANTES de eliminar la tabla
            // Laravel infiere el nombre de la restricción si solo pasas el nombre de la columna
            $table->dropForeign('fk_proveedoresproductos_proveedor_id');
            $table->dropForeign('fk_proveedoresproductos_producto_id');
            $table->dropForeign('fk_proveedoresproductos_unidad_medida_id');
        });

        Schema::dropIfExists('proveedoresproductos');
    }
};