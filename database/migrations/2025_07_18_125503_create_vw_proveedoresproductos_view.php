<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW vw_proveedoresproductos AS
            SELECT
                pp.proveedor_producto_id,
                pp.proveedor_id,
                prod.producto_id AS producto_id,
                pp.descripcion AS descripcion,
                pp.unidad_medida_id AS unidad_medida_id,
                pp.precio_unitario AS precio_unitario,
                pp.detalle AS detalle,
                pp.stock AS stock,
                pp.estado AS estado,
                pp.fecha_registro AS fecha_registro,
                pp.fecha_actualizacion AS fecha_actualizacion,
                prod.nombre AS producto_nombre,
                um.nombre AS unidad_medida_nombre
            FROM proveedoresproductos pp
            LEFT JOIN productos prod ON pp.producto_id = prod.producto_id
            LEFT JOIN unidadesmedidas um ON pp.unidad_medida_id = um.unidad_medida_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_proveedoresproductos");
    }
};