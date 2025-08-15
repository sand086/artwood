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
            CREATE VIEW vw_proveedorescontactos AS
            SELECT
                pc.proveedor_contacto_id,
                pc.proveedor_id,
                pc.persona_id,
                pc.cargo,
                pc.telefono,
                pc.correo_electronico,
                pc.observaciones,
                pc.estado AS estado,
                pc.fecha_registro AS fecha_registro,
                pc.fecha_actualizacion AS fecha_actualizacion,
                CONCAT_WS(' ', p.nombres, p.apellidos) AS contacto_nombre_completo
            FROM proveedorescontactos pc
            LEFT JOIN personas p ON pc.persona_id = p.persona_id
            LEFT JOIN proveedores pr ON pc.proveedor_id = pr.proveedor_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_proveedorescontactos");
    }
};