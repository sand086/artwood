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
            CREATE VIEW vw_empleados AS
            SELECT `e`.`empleado_id` AS `empleado_id`,
                `e`.`cargo` AS `cargo`,
                `e`.`persona_id` AS `persona_id`,
                `e`.`usuario_id` AS `usuario_id`,
                `p`.`nombres` AS `nombres`,
                `p`.`apellidos` AS `apellidos`,
                CONCAT(`p`.`nombres`,' ',`p`.`apellidos`) AS `nombre_completo`,
                `e`.`estado` AS `estado`,
                `e`.`fecha_registro` AS `fecha_registro`,
                `e`.`fecha_actualizacion` AS `fecha_actualizacion`,
                `u`.`nombre` AS `usuario_nombre` 
            FROM ((`empleados` `e` 
            JOIN `personas` `p` on((`e`.`persona_id` = `p`.`persona_id`))) 
            JOIN `usuarios` `u` on((`e`.`usuario_id` = `u`.`usuario_id`)))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_empleados");
    }
};