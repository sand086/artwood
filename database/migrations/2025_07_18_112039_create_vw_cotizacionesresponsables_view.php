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
            CREATE VIEW vw_cotizacionesresponsables AS
            SELECT
                cr.cotizacion_responsable_id,
                cr.cotizacion_solicitud_id,
                cr.empleado_id,
                cr.area_id,
                cr.responsabilidad,
                cr.estado AS estado,
                cr.fecha_registro AS fecha_registro,
                cr.fecha_actualizacion AS fecha_actualizacion,
                a.nombre AS area_nombre,
                CONCAT_WS(' ', p.nombres, p.apellidos) AS empleado_nombre_completo
            FROM cotizacionesresponsables cr
            LEFT JOIN empleados e ON cr.empleado_id = e.empleado_id
            LEFT JOIN personas p ON e.persona_id = p.persona_id
            LEFT JOIN areas a ON cr.area_id = a.area_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_cotizacionesresponsables");
    }
};