<?php

namespace App\Repositories;

use App\Models\ProveedoresMateriales;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class ProveedoresMaterialesRepository extends BaseRepository
{
    public function __construct(ProveedoresMateriales $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->newQuery()->select('proveedor_material_id', 'proveedor_id', 'material_id', 'descripcion', 'detalle', 'stock', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'proveedor_material_id', 'proveedor_id', 'materiales.material_id AS material_id', 'proveedoresmateriales.descripcion AS descripcion', 'proveedoresmateriales.unidad_medida_id AS unidad_medida_id', 'proveedoresmateriales.precio_unitario AS precio_unitario', 'proveedoresmateriales.detalle AS detalle', 'proveedoresmateriales.stock AS stock', 'proveedoresmateriales.estado AS estado', 'proveedoresmateriales.fecha_registro AS fecha_registro', 'proveedoresmateriales.fecha_actualizacion AS fecha_actualizacion',
                    'materiales.nombre AS material_nombre', 'unidadesmedidas.nombre AS unidad_medida_nombre'
                )->leftJoin('materiales', 'proveedoresmateriales.material_id', '=', 'materiales.material_id')
                ->leftJoin('unidadesmedidas', 'proveedoresmateriales.unidad_medida_id', '=', 'unidadesmedidas.unidad_medida_id');

        if (!empty($filters['proveedor_id'])) {
            $query->where('proveedoresmateriales.proveedor_id', $filters['proveedor_id']);
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
        $query = DB::table('vw_proveedoresmateriales'); // <-- Usa la vista aquí

        if (!empty($filters['proveedor_id'])) {
            $query->where('proveedor_id', $filters['proveedor_id']);
        }

        return $query;
    }
}
