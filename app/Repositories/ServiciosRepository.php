<?php

namespace App\Repositories;

use App\Models\Servicios;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class ServiciosRepository extends BaseRepository
{
    public function __construct(Servicios $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(): Builder
    {
        // return $this->model->select('servicio_id', 'nombre', 'descripcion', 'tiempo', 'unidad_medida_id', 'precio', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'servicios.servicio_id', 'servicios.nombre AS nombre', 'servicios.descripcion', 'servicios.tiempo', 'servicios.unidad_medida_id', 'servicios.precio', 'servicios.estado AS estado', 'servicios.fecha_registro AS fecha_registro', 'servicios.fecha_actualizacion AS fecha_actualizacion',
                    'unidadesmedidas.nombre AS unidad_medida_nombre',
                    DB::raw("GROUP_CONCAT(
                                CASE
                                    WHEN proveedores.proveedor_id IS NOT NULL THEN COALESCE(proveedores.nombre, '')
                                    ELSE NULL
                                END SEPARATOR '<br>'
                            ) as proveedores")
                )->leftJoin('unidadesmedidas', 'servicios.unidad_medida_id', '=', 'unidadesmedidas.unidad_medida_id')
                ->leftJoin('proveedoresservicios', function($join) {
                    $join->on('servicios.servicio_id', '=', 'proveedoresservicios.servicio_id')
                        ->where('proveedoresservicios.estado', '=', 'A');
                })
                ->leftJoin('proveedores', function($join) {
                    $join->on('proveedoresservicios.proveedor_id', '=', 'proveedores.proveedor_id')
                        ->where('proveedores.estado', '=', 'A');
                })
                ->groupBy(
                    'servicios.servicio_id', 
                    'servicios.nombre', 
                    'servicios.descripcion',
                    'servicios.tiempo', 
                    'servicios.unidad_medida_id', 
                    'servicios.precio', 
                    'servicios.estado', 
                    'servicios.fecha_registro', 
                    'servicios.fecha_actualizacion',
                    'unidadesmedidas.nombre'
                );

        return $query;
    }

    /**
     * Nuevo método específico para obtener la consulta del DataTable usando la vista.
     *
     * @param array $filters
     * @return \Illuminate\Database\Query\Builder
     */
    public function queryDataTableFromView(array $filters = []): QueryBuilder
    {
        $query = DB::table('vw_servicios');

        return $query;
    }
}