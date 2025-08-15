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
            CREATE VIEW vw_proveedores AS
            SELECT
                pr.proveedor_id,
                pr.nombre AS nombre,
                pr.tipo,
                pr.rfc,
                pr.direccion,
                pr.codigo_postal,
                pr.estado_pais_id,
                pr.municipio_id,
                pr.colonia,
                pr.telefono,
                pr.sitio_web,
                pr.notas_adicionales,
                pr.usuario_id,
                pr.estado AS estado,
                pr.fecha_registro AS fecha_registro,
                pr.fecha_actualizacion AS fecha_actualizacion,
                ep.nombre AS estado_pais_nombre,
                m.nombre AS municipio_nombre,
                u.nombre AS usuario_nombre
            FROM proveedores pr
            LEFT JOIN estadospaises ep ON pr.estado_pais_id = ep.estado_pais_id
            LEFT JOIN municipios m ON pr.municipio_id = m.municipio_id
            LEFT JOIN usuarios u ON pr.usuario_id = u.usuario_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_proveedores");
    }
};