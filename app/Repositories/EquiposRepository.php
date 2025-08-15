<?php

namespace App\Repositories;

use App\Models\Equipos;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class EquiposRepository extends BaseRepository
{
    public function __construct(Equipos $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->newQuery()->select('equipo_id', 'nombre', 'descripcion', 'unidad_medida_id', 'precio_unitario', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'equipos.equipo_id', 
                    'equipos.nombre AS nombre', 
                    'equipos.descripcion', 
                    'equipos.unidad_medida_id', 
                    'equipos.precio_unitario', 
                    'equipos.estado AS estado', 
                    'equipos.fecha_registro AS fecha_registro', 
                    'equipos.fecha_actualizacion AS fecha_actualizacion',
                    'unidadesmedidas.nombre AS unidad_medida_nombre',
                    DB::raw("GROUP_CONCAT(
                                CASE
                                    WHEN proveedores.proveedor_id IS NOT NULL THEN COALESCE(proveedores.nombre, '')
                                    ELSE NULL
                                END SEPARATOR '<br>'
                            ) as proveedores")
                )->leftJoin('unidadesmedidas', 'equipos.unidad_medida_id', '=', 'unidadesmedidas.unidad_medida_id')
                ->leftJoin('proveedoresequipos', function($join) {
                    $join->on('equipos.equipo_id', '=', 'proveedoresequipos.equipo_id')
                        ->where('proveedoresequipos.estado', '=', 'A');
                })
                ->leftJoin('proveedores', function($join) {
                    $join->on('proveedoresequipos.proveedor_id', '=', 'proveedores.proveedor_id')
                        ->where('proveedores.estado', '=', 'A');
                })
                ->groupBy(
                    'equipos.equipo_id', 
                    'equipos.nombre', 
                    'equipos.descripcion', 
                    'equipos.unidad_medida_id', 
                    'equipos.precio_unitario', 
                    'equipos.estado', 
                    'equipos.fecha_registro', 
                    'equipos.fecha_actualizacion',
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
        $query = DB::table('vw_equipos');

        return $query;
    }
}
