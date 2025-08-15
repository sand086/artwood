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
            CREATE VIEW vw_cotizacionesanalisis AS
            SELECT
                ca.cotizacion_solicitud_id,
                ca.tipo_proyecto_id,
                ca.cotizacion_analisis_id,
                ca.descripcion_solicitud,
                ca.tiempo_total,
                ca.costo_subtotal,
                ca.impuesto_iva,
                ca.costo_total,
                ca.control_version,
                ca.usuario_id,
                ca.estado,
                ca.fecha_registro AS fecha_registro,
                ca.fecha_actualizacion AS fecha_actualizacion,
                u.nombre AS usuario_nombre,
                cs.nombre_proyecto,
                cs.consecutivo,
                tp.nombre AS tipo_proyecto_nombre, 
                c.cotizacion_id, 
                c.plantilla_id
            FROM cotizacionesanalisis ca
            LEFT JOIN cotizacionessolicitudes cs ON ca.cotizacion_solicitud_id = cs.cotizacion_solicitud_id
            LEFT JOIN tiposproyectos tp ON ca.tipo_proyecto_id = tp.tipo_proyecto_id
            LEFT JOIN usuarios u ON ca.usuario_id = u.usuario_id
            LEFT JOIN cotizaciones c ON cs.cotizacion_solicitud_id = c.cotizacion_solicitud_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_cotizacionesanalisis");
    }
};