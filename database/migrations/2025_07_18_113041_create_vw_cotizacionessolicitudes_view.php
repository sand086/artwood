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
            CREATE VIEW vw_cotizacionessolicitudes AS
            SELECT
                csol.cotizacion_solicitud_id,
                csol.cliente_id,
                csol.tipo_solicitud_id,
                csol.fuente_id,
                csol.consecutivo,
                csol.nombre_proyecto,
                csol.descripcion,
                csol.fecha_estimada,
                csol.control_version,
                csol.usuario_id,
                csol.estado_id AS estado_id,
                csol.fecha_registro AS fecha_registro,
                csol.fecha_actualizacion AS fecha_actualizacion,
                cli.nombre AS cliente_nombre,
                tsol.nombre AS tipo_solicitud_nombre,
                fu.nombre AS fuente_nombre,
                eg.nombre AS estado_nombre,
                u.nombre AS usuario_nombre,
                cana.cotizacion_analisis_id
            FROM cotizacionessolicitudes csol
            LEFT JOIN cotizacionesanalisis cana ON csol.cotizacion_solicitud_id = cana.cotizacion_solicitud_id
            LEFT JOIN tipossolicitudes tsol ON csol.tipo_solicitud_id = tsol.tipo_solicitud_id
            LEFT JOIN clientes cli ON csol.cliente_id = cli.cliente_id
            LEFT JOIN fuentes fu ON csol.fuente_id = fu.fuente_id
            LEFT JOIN estadosgenerales eg ON csol.estado_id = eg.estado_general_id
            LEFT JOIN usuarios u ON csol.usuario_id = u.usuario_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_cotizacionessolicitudes");
    }
};