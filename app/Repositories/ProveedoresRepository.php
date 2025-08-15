<?php

namespace App\Repositories;

use App\Models\Proveedores;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class ProveedoresRepository extends BaseRepository
{
    public function __construct(Proveedores $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(): Builder
    {
        // return $this->model->newQuery()->select('proveedor_id', 'nombre', 'tipo', 'direccion', 'estado_pais_id', 'municipio_id', 'colonia_id', 'telefono', 'sitio_web', 'notas_adicionales', 'usuario_id', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'proveedor_id', 'proveedores.nombre AS nombre', 'proveedores.tipo', 'proveedores.rfc', 'proveedores.direccion', 'proveedores.codigo_postal', 'proveedores.estado_pais_id', 'proveedores.municipio_id', 'proveedores.colonia', 'proveedores.telefono', 'proveedores.sitio_web', 'proveedores.notas_adicionales', 'proveedores.usuario_id', 'proveedores.estado AS estado', 'proveedores.fecha_registro AS fecha_registro', 'proveedores.fecha_actualizacion AS fecha_actualizacion',
                    'estadospaises.nombre AS estado_pais_nombre', 'municipios.nombre AS municipio_nombre', 'usuarios.nombre AS usuario_nombre',
                )->leftJoin('estadospaises', 'proveedores.estado_pais_id', '=', 'estadospaises.estado_pais_id')
                ->leftJoin('municipios', 'proveedores.municipio_id', '=', 'municipios.municipio_id')
                ->leftJoin('usuarios', 'proveedores.usuario_id', '=', 'usuarios.usuario_id');

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
        $query = DB::table('vw_proveedores');

        return $query;
    }
}
