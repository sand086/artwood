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
            CREATE VIEW vw_servicios AS
            SELECT
                s.servicio_id,
                s.nombre AS nombre,
                s.descripcion,
                s.tiempo,
                s.unidad_medida_id,
                s.precio,
                s.estado AS estado,
                s.fecha_registro AS fecha_registro,
                s.fecha_actualizacion AS fecha_actualizacion,
                um.nombre AS unidad_medida_nombre,
                GROUP_CONCAT(
                    CASE
                        WHEN p.proveedor_id IS NOT NULL THEN COALESCE(p.nombre, '')
                        ELSE NULL
                    END SEPARATOR '<br>'
                ) AS proveedores
            FROM servicios s
            LEFT JOIN unidadesmedidas um ON s.unidad_medida_id = um.unidad_medida_id
            LEFT JOIN proveedoresservicios ps ON s.servicio_id = ps.servicio_id AND ps.estado = 'A'
            LEFT JOIN proveedores p ON ps.proveedor_id = p.proveedor_id AND p.estado = 'A'
            GROUP BY
                s.servicio_id,
                s.nombre,
                s.descripcion,
                s.tiempo,
                s.unidad_medida_id,
                s.precio,
                s.estado,
                s.fecha_registro,
                s.fecha_actualizacion,
                um.nombre
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_servicios");
    }
};