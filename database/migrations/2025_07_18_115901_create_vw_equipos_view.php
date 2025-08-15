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
            CREATE VIEW vw_equipos AS
            SELECT
                e.equipo_id,
                e.nombre AS nombre,
                e.descripcion,
                e.unidad_medida_id,
                e.precio_unitario,
                e.estado AS estado,
                e.fecha_registro AS fecha_registro,
                e.fecha_actualizacion AS fecha_actualizacion,
                um.nombre AS unidad_medida_nombre,
                GROUP_CONCAT(
                    CASE
                        WHEN p.proveedor_id IS NOT NULL THEN COALESCE(p.nombre, '')
                        ELSE NULL
                    END SEPARATOR '<br>'
                ) AS proveedores
            FROM equipos e
            LEFT JOIN unidadesmedidas um ON e.unidad_medida_id = um.unidad_medida_id
            LEFT JOIN proveedoresequipos pe ON e.equipo_id = pe.equipo_id AND pe.estado = 'A'
            LEFT JOIN proveedores p ON pe.proveedor_id = p.proveedor_id AND p.estado = 'A'
            GROUP BY
                e.equipo_id,
                e.nombre,
                e.descripcion,
                e.unidad_medida_id,
                e.precio_unitario,
                e.estado,
                e.fecha_registro,
                e.fecha_actualizacion,
                um.nombre
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_equipos");
    }
};