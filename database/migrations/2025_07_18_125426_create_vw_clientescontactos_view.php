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
            CREATE VIEW vw_clientescontactos AS
            SELECT
                cc.cliente_contacto_id,
                cc.cliente_id,
                cc.persona_id,
                cc.cargo,
                cc.telefono,
                cc.correo_electronico,
                cc.observaciones,
                cc.estado AS estado,
                cc.fecha_registro AS fecha_registro,
                cc.fecha_actualizacion AS fecha_actualizacion,
                CONCAT_WS(' ', p.nombres, p.apellidos) AS contacto_nombre_completo
            FROM clientescontactos cc
            LEFT JOIN clientes c ON cc.cliente_id = c.cliente_id
            LEFT JOIN personas p ON cc.persona_id = p.persona_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_clientescontactos");
    }
};