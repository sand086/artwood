<?php

namespace App\Repositories;

use App\Models\Clientes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class ClientesRepository extends BaseRepository
{
    public function __construct(Clientes $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->newQuery()->select('cliente_id', 'nombre', 'tipo_cliente_id', 'direccion', 'colonia_id', 'municipio_id', 'estado_pais_id', 'telefono', 'sitio_web', 'notas_adicionales', 'usuario_id', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'cliente_id', 'clientes.nombre AS nombre', 'clientes.tipo_cliente_id', 'clientes.clase', 'rfc', 'clientes.direccion', 'clientes.codigo_postal', 'clientes.colonia', 'clientes.estado_pais_id', 'clientes.municipio_id', 'clientes.telefono', 'clientes.sitio_web', 'clientes.notas_adicionales', 'clientes.usuario_id', 'clientes.estado AS estado', 'clientes.fecha_registro AS fecha_registro', 'clientes.fecha_actualizacion AS fecha_actualizacion',
                    'estadospaises.nombre AS estado_pais_nombre', 'municipios.nombre AS municipio_nombre', 'usuarios.nombre AS usuario_nombre', 'tiposclientes.nombre AS tipo_cliente_nombre'
                )->leftJoin('estadospaises', 'clientes.estado_pais_id', '=', 'estadospaises.estado_pais_id')
                ->leftJoin('municipios', 'clientes.municipio_id', '=', 'municipios.municipio_id')
                ->leftJoin('tiposclientes', 'clientes.tipo_cliente_id', '=', 'tiposclientes.tipo_cliente_id')
                ->leftJoin('usuarios', 'clientes.usuario_id', '=', 'usuarios.usuario_id');

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
        $query = DB::table('vw_clientes');

        return $query;
    }
}
