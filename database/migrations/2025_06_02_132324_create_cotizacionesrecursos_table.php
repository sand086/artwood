<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizacionesrecursos', function (Blueprint $table) {
            $table->id('cotizacion_recurso_id');
            $table->unsignedBigInteger('cotizacion_analisis_id')->comment('El dato ID del analisis de la cotizacion del Recurso de la Cotizacion');
            $table->unsignedBigInteger('tipo_recurso_id')->comment('El dato ID del tipo de recurso del Recurso de la Cotizacion');
            $table->unsignedBigInteger('recurso_id')->comment('El dato ID del recurso del Recurso de la Cotizacion');
            $table->unsignedBigInteger('proveedor_id')->nullable()->comment('El dato ID del proveedor del Recurso de la Cotizacion');
            $table->unsignedBigInteger('unidad_medida_id')->comment('El dato ID de la unidad de medida del Recurso de la Cotizacion');
            $table->decimal('precio_unitario',10,2)->default(0.00)->comment('El dato del precio o costo unitario del Recurso de la Cotizacion');
            $table->decimal('porcentaje_ganancia',4,2)->default(0.00)->comment('El dato del porcentaje de ganancia del Recurso aplicado al precio unitario');
             $table->decimal('precio_unitario_ganancia',10,2)->default(0.00)->comment('El dato del precio unitario con ganancia del Recurso de la Cotizacion');
            $table->unsignedInteger('cantidad')->comment('El dato la cantidad del Recurso de la Cotizacion');
            $table->decimal('precio_total',10,2)->comment('El dato del precio o costo total del Recurso de la Cotizacion');
            $table->tinyInteger('tiempo_entrega')->default('0')->comment('El dato del tiempo de entrega del Recurso');
            $table->unsignedBigInteger('usuario_id')->comment('El dato ID del usuario del Recurso de la Cotizacion');
            $table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');
            $table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            $table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');
            // Definición de las Claves Foráneas
            // Constraint para cotizacion_analisis_id referenciando la tabla cotizacionesanalisis
            $table->foreign('cotizacion_analisis_id')
                    ->references('cotizacion_analisis_id')
                    ->on('cotizacionesanalisis')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            // Constraint para tipo_recurso_id referenciando la tabla tiposrecursos
            $table->foreign('tipo_recurso_id')
                    ->references('tipo_recurso_id')
                    ->on('tiposrecursos')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            // Constraint para unidad_medida_id referenciando la tabla unidadesmedidas
            $table->foreign('unidad_medida_id')
                    ->references('unidad_medida_id')
                    ->on('unidadesmedidas')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            // Constraint para usuario_id referenciando la tabla usuarios
            $table->foreign('usuario_id')
                    ->references('usuario_id')
                    ->on('usuarios')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }
    // $table->timestamps();

    public function down(): void
    {
        Schema::table('cotizacionesrecursos', function (Blueprint $table) {
            // Eliminar las claves foráneas ANTES de eliminar la tabla
            $table->dropForeign('cotizacionesrecursos_cotizacion_analisis_id_foreign');
            $table->dropForeign('cotizacionesrecursos_tipo_recurso_id_foreign');
            $table->dropForeign('cotizacionesrecursos_unidad_medida_id_foreign');
            $table->dropForeign('cotizacionesrecursos_usuario_id_foreign');
        });
        // Eliminar la tabla
        Schema::dropIfExists('cotizacionesrecursos');
    }
};