<?php

namespace App\Repositories;

use App\Models\ProveedoresEquipos;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class ProveedoresEquiposRepository extends BaseRepository
{
    public function __construct(ProveedoresEquipos $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->newQuery()->select('proveedor_equipo_id', 'proveedor_id', 'equipo_id', 'descripcion', 'detalle', 'stock', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'proveedor_equipo_id', 'proveedor_id', 'equipos.equipo_id AS equipo_id', 'proveedoresequipos.descripcion AS descripcion', 'proveedoresequipos.unidad_medida_id AS unidad_medida_id', 'proveedoresequipos.precio_unitario AS precio_unitario', 'proveedoresequipos.detalle AS detalle', 'proveedoresequipos.stock AS stock', 'proveedoresequipos.estado AS estado', 'proveedoresequipos.fecha_registro AS fecha_registro', 'proveedoresequipos.fecha_actualizacion AS fecha_actualizacion',
                    'equipos.nombre AS equipo_nombre', 'unidadesmedidas.nombre AS unidad_medida_nombre'
                )->leftJoin('equipos', 'proveedoresequipos.equipo_id', '=', 'equipos.equipo_id')
                ->leftJoin('unidadesmedidas', 'proveedoresequipos.unidad_medida_id', '=', 'unidadesmedidas.unidad_medida_id');

        if (!empty($filters['proveedor_id'])) {
            $query->where('proveedoresequipos.proveedor_id', $filters['proveedor_id']);
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
        $query = DB::table('vw_proveedoresequipos'); // <-- Usa la vista aquí

        if (!empty($filters['proveedor_id'])) {
            $query->where('proveedor_id', $filters['proveedor_id']);
        }

        return $query;
    }
}
