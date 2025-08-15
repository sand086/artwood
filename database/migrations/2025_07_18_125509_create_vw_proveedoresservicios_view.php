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
            CREATE VIEW vw_proveedoresservicios AS
            SELECT
                pserv.proveedor_servicio_id,
                pserv.proveedor_id,
                s.servicio_id AS servicio_id,
                pserv.descripcion AS descripcion,
                pserv.tiempo AS tiempo,
                pserv.unidad_medida_id AS unidad_medida_id,
                pserv.precio_unitario AS precio_unitario,
                pserv.detalle AS detalle,
                pserv.estado AS estado,
                pserv.fecha_registro AS fecha_registro,
                pserv.fecha_actualizacion AS fecha_actualizacion,
                s.nombre AS servicio_nombre,
                um.nombre AS unidad_medida_nombre
            FROM proveedoresservicios pserv
            LEFT JOIN servicios s ON pserv.servicio_id = s.servicio_id
            LEFT JOIN unidadesmedidas um ON pserv.unidad_medida_id = um.unidad_medida_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_proveedoresservicios");
    }
};