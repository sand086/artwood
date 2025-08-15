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
            CREATE VIEW vw_proveedoresmateriales AS
            SELECT
                pm.proveedor_material_id,
                pm.proveedor_id,
                m.material_id AS material_id,
                pm.descripcion AS descripcion,
                pm.unidad_medida_id AS unidad_medida_id,
                pm.precio_unitario AS precio_unitario,
                pm.detalle AS detalle,
                pm.stock AS stock,
                pm.estado AS estado,
                pm.fecha_registro AS fecha_registro,
                pm.fecha_actualizacion AS fecha_actualizacion,
                m.nombre AS material_nombre,
                um.nombre AS unidad_medida_nombre
            FROM proveedoresmateriales pm
            LEFT JOIN materiales m ON pm.material_id = m.material_id
            LEFT JOIN unidadesmedidas um ON pm.unidad_medida_id = um.unidad_medida_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_proveedoresmateriales");
    }
};