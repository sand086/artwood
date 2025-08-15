<?php

namespace App\Repositories;

use App\Models\ProveedoresServicios;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class ProveedoresServiciosRepository extends BaseRepository
{
    public function __construct(ProveedoresServicios $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->newQuery()->select('proveedor_servicio_id', 'proveedor_id', 'servicio_id', 'descripcion', 'detalle', 'estado', 'fecha_registro', 'fecha_actualizacion');
        $query = $this->model->newQuery()
                ->select(
                    'proveedor_servicio_id', 'proveedor_id', 'servicios.servicio_id AS servicio_id', 'proveedoresservicios.descripcion AS descripcion', 'proveedoresservicios.tiempo AS tiempo', 'proveedoresservicios.unidad_medida_id AS unidad_medida_id', 'proveedoresservicios.precio_unitario AS precio_unitario', 'proveedoresservicios.detalle AS detalle', 'proveedoresservicios.estado AS estado', 'proveedoresservicios.fecha_registro AS fecha_registro', 'proveedoresservicios.fecha_actualizacion AS fecha_actualizacion',
                    'servicios.nombre AS servicio_nombre', 'unidadesmedidas.nombre AS unidad_medida_nombre'
                )->leftJoin('servicios', 'proveedoresservicios.servicio_id', '=', 'servicios.servicio_id')
                ->leftJoin('unidadesmedidas', 'proveedoresservicios.unidad_medida_id', '=', 'unidadesmedidas.unidad_medida_id');

        if (!empty($filters['proveedor_id'])) {
            $query->where('proveedoresservicios.proveedor_id', $filters['proveedor_id']);
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
        $query = DB::table('vw_proveedoresservicios'); // <-- Usa la vista aquí

        if (!empty($filters['proveedor_id'])) {
            $query->where('proveedor_id', $filters['proveedor_id']);
        }

        return $query;
    }
}
