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
            CREATE VIEW vw_proveedoresequipos AS
            SELECT
                pe.proveedor_equipo_id,
                pe.proveedor_id,
                e.equipo_id AS equipo_id,
                pe.descripcion AS descripcion,
                pe.unidad_medida_id AS unidad_medida_id,
                pe.precio_unitario AS precio_unitario,
                pe.detalle AS detalle,
                pe.stock AS stock,
                pe.estado AS estado,
                pe.fecha_registro AS fecha_registro,
                pe.fecha_actualizacion AS fecha_actualizacion,
                e.nombre AS equipo_nombre,
                um.nombre AS unidad_medida_nombre
            FROM proveedoresequipos pe
            LEFT JOIN equipos e ON pe.equipo_id = e.equipo_id
            LEFT JOIN unidadesmedidas um ON pe.unidad_medida_id = um.unidad_medida_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_proveedoresequipos");
    }
};