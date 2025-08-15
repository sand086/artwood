<?php

namespace App\Repositories;

use App\Models\Productos;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class ProductosRepository extends BaseRepository
{
    public function __construct(Productos $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(): Builder
    {
        // return $this->model->select('producto_id', 'nombre', 'descripcion', 'unidad_medida_id', 'precio_unitario', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'productos.producto_id', 'productos.nombre AS nombre', 'productos.descripcion', 'productos.unidad_medida_id', 'productos.precio_unitario', 'productos.estado AS estado', 'productos.fecha_registro AS fecha_registro', 'productos.fecha_actualizacion AS fecha_actualizacion',
                    'unidadesmedidas.nombre AS unidad_medida_nombre',
                    DB::raw("GROUP_CONCAT(
                                CASE
                                    WHEN proveedores.proveedor_id IS NOT NULL THEN COALESCE(proveedores.nombre, '')
                                    ELSE NULL
                                END SEPARATOR '<br>'
                            ) as proveedores")
                )->leftJoin('unidadesmedidas', 'productos.unidad_medida_id', '=', 'unidadesmedidas.unidad_medida_id')
                ->leftJoin('proveedoresproductos', function($join) {
                    $join->on('productos.producto_id', '=', 'proveedoresproductos.producto_id')
                        ->where('proveedoresproductos.estado', '=', 'A');
                })
                ->leftJoin('proveedores', function($join) {
                    $join->on('proveedoresproductos.proveedor_id', '=', 'proveedores.proveedor_id')
                        ->where('proveedores.estado', '=', 'A');
                })
                ->groupBy(
                    'productos.producto_id', 
                    'productos.nombre', 
                    'productos.descripcion', 
                    'productos.unidad_medida_id', 
                    'productos.precio_unitario', 
                    'productos.estado', 
                    'productos.fecha_registro', 
                    'productos.fecha_actualizacion',
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
        $query = DB::table('vw_productos');

        return $query;
    }
}