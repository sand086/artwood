<?php

namespace App\Repositories;

use App\Models\Materiales;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class MaterialesRepository extends BaseRepository
{
    public function __construct(Materiales $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->newQuery()->select('material_id', 'nombre', 'descripcion', 'unidad_medida_id', 'precio_unitario', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'materiales.material_id', 'materiales.nombre AS nombre', 'materiales.descripcion', 'materiales.unidad_medida_id', 'materiales.precio_unitario', 'materiales.estado AS estado', 'materiales.fecha_registro AS fecha_registro', 'materiales.fecha_actualizacion AS fecha_actualizacion',
                    'unidadesmedidas.nombre AS unidad_medida_nombre',
                    DB::raw("GROUP_CONCAT(
                                CASE
                                    WHEN proveedores.proveedor_id IS NOT NULL THEN COALESCE(proveedores.nombre, '')
                                    ELSE NULL
                                END SEPARATOR '<br>'
                            ) as proveedores")
                )->leftJoin('unidadesmedidas', 'materiales.unidad_medida_id', '=', 'unidadesmedidas.unidad_medida_id')
                ->leftJoin('proveedoresmateriales', function($join) {
                    $join->on('materiales.material_id', '=', 'proveedoresmateriales.material_id')
                        ->where('proveedoresmateriales.estado', '=', 'A');
                })
                ->leftJoin('proveedores', function($join) {
                    $join->on('proveedoresmateriales.proveedor_id', '=', 'proveedores.proveedor_id')
                        ->where('proveedores.estado', '=', 'A');
                })
                ->groupBy(
                    'materiales.material_id', 
                    'materiales.nombre', 
                    'materiales.descripcion', 
                    'materiales.unidad_medida_id', 
                    'materiales.precio_unitario', 
                    'materiales.estado', 
                    'materiales.fecha_registro', 
                    'materiales.fecha_actualizacion',
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
        $query = DB::table('vw_materiales');

        return $query;
    }
}
