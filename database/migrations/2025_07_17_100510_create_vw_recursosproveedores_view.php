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
            CREATE VIEW vw_recursosproveedores AS
            SELECT `tr`.`tipo_recurso_id` AS `tipo_recurso_id`,'productos' AS `tabla_referencia`,`pp`.`producto_id` AS `recurso_id`,`p`.`proveedor_id` AS `proveedor_id`,`p`.`nombre` AS `nombre`,`pp`.`stock` AS `stock_disponible`,`pp`.`unidad_medida_id` AS `unidad_medida_id`,`pp`.`precio_unitario` AS `precio_recurso_proveedor`,concat('[',`pp`.`precio_unitario`,'] ',`p`.`nombre`) AS `proveedor_precio_nombre` FROM (((`proveedoresproductos` `pp` JOIN `productos` `prod` on((`pp`.`producto_id` = `prod`.`producto_id`))) JOIN `proveedores` `p` on((`pp`.`proveedor_id` = `p`.`proveedor_id`))) JOIN `tiposrecursos` `tr` on((`tr`.`tabla_referencia` = 'productos'))) 
            
            UNION ALL 
            
            SELECT `tr`.`tipo_recurso_id` AS `tipo_recurso_id`,'servicios' AS `tabla_referencia`,
                `ps`.`servicio_id` AS `recurso_id`,`p`.`proveedor_id` AS `proveedor_id`,`p`.`nombre` AS `nombre`,0 AS `stock_disponible`,`ps`.`unidad_medida_id` AS `unidad_medida_id`,`ps`.`precio_unitario` AS `precio_recurso_proveedor`,concat('[',`ps`.`precio_unitario`,'] ',`p`.`nombre`) AS `proveedor_precio_nombre` 
            FROM (((`proveedoresservicios` `ps` 
            JOIN `servicios` `serv` on((`ps`.`servicio_id` = `serv`.`servicio_id`))) 
            JOIN `proveedores` `p` on((`ps`.`proveedor_id` = `p`.`proveedor_id`))) 
            JOIN `tiposrecursos` `tr` on((`tr`.`tabla_referencia` = 'servicios'))) 
            
            UNION ALL 
            
            SELECT `tr`.`tipo_recurso_id` AS `tipo_recurso_id`,
                'materiales' AS `tabla_referencia`,`pm`.`material_id` AS `recurso_id`,`p`.`proveedor_id` AS `proveedor_id`,`p`.`nombre` AS `nombre`,`pm`.`stock` AS `stock_disponible`,`pm`.`unidad_medida_id` AS `unidad_medida_id`,`pm`.`precio_unitario` AS `precio_recurso_proveedor`,concat('[',`pm`.`precio_unitario`,'] ',`p`.`nombre`) AS `proveedor_precio_nombre` 
            FROM (((`proveedoresmateriales` `pm` 
            JOIN `materiales` `mat` on((`pm`.`material_id` = `mat`.`material_id`))) 
            JOIN `proveedores` `p` on((`pm`.`proveedor_id` = `p`.`proveedor_id`))) 
            JOIN `tiposrecursos` `tr` on((`tr`.`tabla_referencia` = 'materiales'))) 
            
            UNION ALL 
            
            SELECT `tr`.`tipo_recurso_id` AS `tipo_recurso_id`,'equipos' AS `tabla_referencia`,
                `pe`.`equipo_id` AS `recurso_id`,`p`.`proveedor_id` AS `proveedor_id`,`p`.`nombre` AS `nombre`,`pe`.`stock` AS `stock_disponible`,`pe`.`unidad_medida_id` AS `unidad_medida_id`,`pe`.`precio_unitario` AS `precio_recurso_proveedor`,concat('[',`pe`.`precio_unitario`,'] ',`p`.`nombre`) AS `proveedor_precio_nombre` 
            FROM (((`proveedoresequipos` `pe` 
            JOIN `equipos` `eq` on((`pe`.`equipo_id` = `eq`.`equipo_id`))) 
            JOIN `proveedores` `p` on((`pe`.`proveedor_id` = `p`.`proveedor_id`))) 
            JOIN `tiposrecursos` `tr` on((`tr`.`tabla_referencia` = 'equipos')))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_recursosproveedores");
    }
};