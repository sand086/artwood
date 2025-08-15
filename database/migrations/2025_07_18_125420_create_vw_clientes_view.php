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
            CREATE VIEW vw_clientes AS
            SELECT
                c.cliente_id,
                c.nombre AS nombre,
                c.tipo_cliente_id,
                c.clase,
                c.rfc,
                c.direccion,
                c.codigo_postal,
                c.colonia,
                c.estado_pais_id,
                c.municipio_id,
                c.telefono,
                c.sitio_web,
                c.notas_adicionales,
                c.usuario_id,
                c.estado AS estado,
                c.fecha_registro AS fecha_registro,
                c.fecha_actualizacion AS fecha_actualizacion,
                ep.nombre AS estado_pais_nombre,
                m.nombre AS municipio_nombre,
                u.nombre AS usuario_nombre,
                tc.nombre AS tipo_cliente_nombre
            FROM clientes c
            LEFT JOIN estadospaises ep ON c.estado_pais_id = ep.estado_pais_id
            LEFT JOIN municipios m ON c.municipio_id = m.municipio_id
            LEFT JOIN tiposclientes tc ON c.tipo_cliente_id = tc.tipo_cliente_id
            LEFT JOIN usuarios u ON c.usuario_id = u.usuario_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_clientes");
    }
};