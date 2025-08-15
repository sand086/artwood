<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedoresservicios', function (Blueprint $table) {
            $table->id('proveedor_servicio_id');
            $table->unsignedBigInteger('proveedor_id')->comment('El ID del proveedor asociado desde la tabla proveedores');
            $table->unsignedBigInteger('servicio_id')->comment('El ID del servicio asociado desde la tabla servicios');
            $table->string('descripcion')->comment('El dato descripcion del ProveedoresServicios');
            $table->tinyInteger('tiempo', 3)->comment('El dato tiempo del Servicio');
            $table->unsignedBigInteger('unidad_medida_id')->comment('El ID de la unidad_medida asociado desde la tabla unidades_medidas');
            $table->decimal('precio',10,2)->comment('El dato precio del Servicios');
            $table->string('detalle', 2048)->nullable()->comment('El dato detalle del ProveedoresServicios');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            

            // Define Foreign Key Constraints
            // Constraint for proveedor_id referencing proveedores table
            $table->foreign('proveedor_id', 'fk_proveedoresservicios_proveedor_id')->references('proveedor_id')->on('proveedores')->onDelete('cascade')->onUpdate('cascade');

            // Constraint for servicio_id referencing servicios table
            $table->foreign('servicio_id', 'fk_proveedoresservicios_servicio_id')->references('servicio_id')->on('servicios')->onDelete('cascade')->onUpdate('cascade');     // Action on update

            // Constraint for unidad_medida_id referencing unidadesmedidas table
            $table->foreign('unidad_medida_id', 'fk_proveedoresservicios_unidad_medida_id')->references('unidad_medida_id')->on('unidadesmedidas')->onDelete('restrict')->onUpdate('restrict');
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        Schema::table('proveedoresservicios', function (Blueprint $table) {
            // Drop foreign keys using the conventional naming scheme Laravel uses
            // Or specify a custom name if you defined one during creation
            $table->dropForeign(['fk_proveedoresservicios_proveedor_id']);
            $table->dropForeign(['fk_proveedoresservicios_servicio_id']);
            $table->dropForeign(['fk_proveedoresservicios_unidad_medida_id']);
        });

        Schema::dropIfExists('proveedoresservicios');
    }
};