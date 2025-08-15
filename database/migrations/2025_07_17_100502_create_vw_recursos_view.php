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
            CREATE VIEW vw_recursos AS
            SELECT `tr`.`tipo_recurso_id` AS `tipo_recurso_id`,`p`.`producto_id` AS `recurso_id`,
                `p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`unidad_medida_id` AS `unidad_medida_id`,`p`.`precio_unitario` AS `precio_unitario`,`tr`.`tabla_referencia` AS `tabla_referencia`,`p`.`estado` AS `estado` 
            FROM (`productos` `p` 
            JOIN `tiposrecursos` `tr` on((`tr`.`tabla_referencia` = 'productos'))) 
            
            UNION ALL 
            
            SELECT `tr`.`tipo_recurso_id` AS `tipo_recurso_id`,`s`.`servicio_id` AS `recurso_id`,
                `s`.`nombre` AS `nombre`,`s`.`descripcion` AS `descripcion`,`s`.`unidad_medida_id` AS `unidad_medida_id`,`s`.`precio` AS `precio_unitario`,`tr`.`tabla_referencia` AS `tabla_referencia`,`s`.`estado` AS `estado` 
            FROM (`servicios` `s` 
            JOIN `tiposrecursos` `tr` on((`tr`.`tabla_referencia` = 'servicios'))) 
            
            UNION ALL 
            
            SELECT `tr`.`tipo_recurso_id` AS `tipo_recurso_id`,`m`.`material_id` AS `recurso_id`,
                `m`.`nombre` AS `nombre`,`m`.`descripcion` AS `descripcion`,`m`.`unidad_medida_id` AS `unidad_medida_id`,`m`.`precio_unitario` AS `precio_unitario`,`tr`.`tabla_referencia` AS `tabla_referencia`,`m`.`estado` AS `estado` 
            FROM (`materiales` `m` 
            JOIN `tiposrecursos` `tr` on((`tr`.`tabla_referencia` = 'materiales'))) 
            
            UNION ALL 
            
            SELECT `tr`.`tipo_recurso_id` AS `tipo_recurso_id`,`e`.`equipo_id` AS `recurso_id`,
                `e`.`nombre` AS `nombre`,`e`.`descripcion` AS `descripcion`,`e`.`unidad_medida_id` AS `unidad_medida_id`,`e`.`precio_unitario` AS `precio_unitario`,`tr`.`tabla_referencia` AS `tabla_referencia`,`e`.`estado` AS `estado` 
            FROM (`equipos` `e` 
            JOIN `tiposrecursos` `tr` on((`tr`.`tabla_referencia` = 'equipos')))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_recursos");
    }
};