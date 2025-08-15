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
        // Asegúrate de que el nombre de la vista coincida con el usado en el repositorio
        DB::statement("
            CREATE VIEW vw_cotizacionesrecursos AS
            SELECT
                cr.cotizacion_recurso_id,
                cr.cotizacion_analisis_id,
                cr.tipo_recurso_id,
                cr.recurso_id,
                cr.proveedor_id,
                cr.unidad_medida_id,
                cr.precio_unitario,
                cr.porcentaje_ganancia,
                cr.precio_unitario_ganancia,
                cr.cantidad,
                cr.tiempo_entrega,
                cr.precio_total,
                cr.usuario_id,
                cr.estado AS estado,
                cr.fecha_registro AS fecha_registro,
                cr.fecha_actualizacion AS fecha_actualizacion,
                tr.nombre AS tipo_recurso_nombre,
                p.nombre AS proveedor_nombre,
                um.nombre AS unidad_medida_nombre,
                u.nombre AS usuario_nombre,
                CASE tr.tabla_referencia
                    WHEN 'productos' THEN (SELECT nombre FROM productos WHERE productos.producto_id = cr.recurso_id LIMIT 1)
                    WHEN 'servicios' THEN (SELECT nombre FROM servicios WHERE servicios.servicio_id = cr.recurso_id LIMIT 1)
                    WHEN 'materiales' THEN (SELECT nombre FROM materiales WHERE materiales.material_id = cr.recurso_id LIMIT 1)
                    WHEN 'equipos' THEN (SELECT nombre FROM equipos WHERE equipos.equipo_id = cr.recurso_id LIMIT 1)
                    WHEN 'gastos' THEN (SELECT nombre FROM gastos WHERE gastos.gasto_id = cr.recurso_id LIMIT 1)
                    ELSE NULL
                END AS recurso_nombre
            FROM cotizacionesrecursos cr
            LEFT JOIN tiposrecursos tr ON cr.tipo_recurso_id = tr.tipo_recurso_id
            LEFT JOIN proveedores p ON cr.proveedor_id = p.proveedor_id
            LEFT JOIN unidadesmedidas um ON cr.unidad_medida_id = um.unidad_medida_id
            LEFT JOIN usuarios u ON cr.usuario_id = u.usuario_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_cotizacionesrecursos");
    }
};