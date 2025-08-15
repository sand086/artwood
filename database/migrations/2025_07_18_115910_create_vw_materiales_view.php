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
            CREATE VIEW vw_materiales AS
            SELECT
                m.material_id,
                m.nombre AS nombre,
                m.descripcion,
                m.unidad_medida_id,
                m.precio_unitario,
                m.estado AS estado,
                m.fecha_registro AS fecha_registro,
                m.fecha_actualizacion AS fecha_actualizacion,
                um.nombre AS unidad_medida_nombre,
                GROUP_CONCAT(
                    CASE
                        WHEN p.proveedor_id IS NOT NULL THEN COALESCE(p.nombre, '')
                        ELSE NULL
                    END SEPARATOR '<br>'
                ) AS proveedores
            FROM materiales m
            LEFT JOIN unidadesmedidas um ON m.unidad_medida_id = um.unidad_medida_id
            LEFT JOIN proveedoresmateriales pm ON m.material_id = pm.material_id AND pm.estado = 'A'
            LEFT JOIN proveedores p ON pm.proveedor_id = p.proveedor_id AND p.estado = 'A'
            GROUP BY
                m.material_id,
                m.nombre,
                m.descripcion,
                m.unidad_medida_id,
                m.precio_unitario,
                m.estado,
                m.fecha_registro,
                m.fecha_actualizacion,
                um.nombre
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_materiales");
    }
};