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
            CREATE VIEW vw_contactos AS
            SELECT `p`.`persona_id` AS `persona_id`,
                `p`.`nombres` AS `nombres`,
                `p`.`apellidos` AS `apellidos`,
                `p`.`estado` AS `estado`,
                `p`.`telefono` AS `telefono`,
                concat(`p`.`nombres`,' ',`p`.`apellidos`) AS `nombre_completo`,
                `p`.`correo_electronico` AS `correo_electronico`,
                `e`.`empleado_id` AS `empleado_id`,
                GROUP_CONCAT((
                    CASE WHEN (`pr`.`proveedor_id` is not null) THEN 
                            concat('PROVEEDOR: ',coalesce(`pr`.`nombre`,`p`.`nombres`,'')) 
                        WHEN (`c`.`cliente_id` is not null) THEN 
                            concat('CLIENTE: ',coalesce(`c`.`nombre`,`p`.`nombres`,'')) 
                        WHEN (`e`.`empleado_id` is not null) THEN 
                            'EMPLEADO: SI' else NULL end) separator '<br>') AS `relaciones` 
            FROM (((((`personas` `p` 
            LEFT JOIN `clientescontactos` `cc` ON((`p`.`persona_id` = `cc`.`persona_id`))) 
            LEFT JOIN `clientes` `c` ON((`cc`.`cliente_id` = `c`.`cliente_id`))) 
            LEFT JOIN `proveedorescontactos` `pc` ON((`p`.`persona_id` = `pc`.`persona_id`))) LEFT JOIN `proveedores` `pr` ON((`pc`.`proveedor_id` = `pr`.`proveedor_id`))) 
            LEFT JOIN `empleados` `e` ON((`p`.`persona_id` = `e`.`persona_id`))) 
            GROUP BY `p`.`persona_id`,
                    `p`.`nombres`,
                    `p`.`apellidos`,
                    `p`.`estado`,
                    `e`.`empleado_id`,
                    `p`.`telefono`,
                    `p`.`correo_electronico`,
                    `e`.`empleado_id`
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_contactos");
    }
};