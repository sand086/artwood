<?php

namespace App\Repositories;

use App\Models\ProveedoresProductos;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class ProveedoresProductosRepository extends BaseRepository
{
    public function __construct(ProveedoresProductos $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->newQuery()->select('proveedor_producto_id', 'proveedor_id', 'producto_id', 'descripcion', 'detalle', 'estado', 'fecha_registro', 'fecha_actualizacion');
        $query = $this->model->newQuery()
                ->select(
                    'proveedor_producto_id', 'proveedor_id', 'productos.producto_id AS producto_id', 'proveedoresproductos.descripcion AS descripcion', 'proveedoresproductos.unidad_medida_id AS unidad_medida_id', 'proveedoresproductos.precio_unitario AS precio_unitario', 'proveedoresproductos.detalle AS detalle', 'stock', 'proveedoresproductos.estado AS estado', 'proveedoresproductos.fecha_registro AS fecha_registro', 'proveedoresproductos.fecha_actualizacion AS fecha_actualizacion',
                    'productos.nombre AS producto_nombre', 'unidadesmedidas.nombre AS unidad_medida_nombre' )
                ->leftJoin('productos', 'proveedoresproductos.producto_id', '=', 'productos.producto_id')
                ->leftJoin('unidadesmedidas', 'proveedoresproductos.unidad_medida_id', '=', 'unidadesmedidas.unidad_medida_id');

        if (!empty($filters['proveedor_id'])) {
            $query->where('proveedoresproductos.proveedor_id', $filters['proveedor_id']);
        }

        return $query;
    }

    /**
     * Método específico para obtener la consulta del DataTable usando la vista.
     *
     * @param array $filters
     * @return \Illuminate\Database\Query\Builder
     */
    public function queryDataTableFromView(array $filters = []): QueryBuilder
    {
        $query = DB::table('vw_proveedoresproductos'); // <-- Usa la vista aquí

        if (!empty($filters['proveedor_id'])) {
            $query->where('proveedor_id', $filters['proveedor_id']);
        }

        return $query;
    }
}
