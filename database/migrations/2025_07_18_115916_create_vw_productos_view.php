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
            CREATE VIEW vw_productos AS
            SELECT
                p.producto_id,
                p.nombre AS nombre,
                p.descripcion,
                p.unidad_medida_id,
                p.precio_unitario,
                p.estado AS estado,
                p.fecha_registro AS fecha_registro,
                p.fecha_actualizacion AS fecha_actualizacion,
                um.nombre AS unidad_medida_nombre,
                GROUP_CONCAT(
                    CASE
                        WHEN prov.proveedor_id IS NOT NULL THEN COALESCE(prov.nombre, '')
                        ELSE NULL
                    END SEPARATOR '<br>'
                ) AS proveedores
            FROM productos p
            LEFT JOIN unidadesmedidas um ON p.unidad_medida_id = um.unidad_medida_id
            LEFT JOIN proveedoresproductos pp ON p.producto_id = pp.producto_id AND pp.estado = 'A'
            LEFT JOIN proveedores prov ON pp.proveedor_id = prov.proveedor_id AND prov.estado = 'A'
            GROUP BY
                p.producto_id,
                p.nombre,
                p.descripcion,
                p.unidad_medida_id,
                p.precio_unitario,
                p.estado,
                p.fecha_registro,
                p.fecha_actualizacion,
                um.nombre
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_productos");
    }
};