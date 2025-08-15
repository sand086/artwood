<?php

namespace App\Repositories;

use App\Models\Gastos;
use Illuminate\Database\Eloquent\Builder;

class GastosRepository extends BaseRepository
{
    public function __construct(Gastos $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {

        // return $this->model->newQuery()->select('gasto_id', 'nombre', 'tipo_gasto_id', 'unidad_medida_id', 'valor_unidad', 'cantidad', 'valor_total', 'usuario_id', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'gasto_id', 'gastos.nombre AS nombre', 'gastos.tipo_gasto_id', 'gastos.unidad_medida_id', 'valor_unidad', 'cantidad', 'valor_total', 'gastos.usuario_id','gastos.estado AS estado', 'gastos.fecha_registro AS fecha_registro', 'gastos.fecha_actualizacion AS fecha_actualizacion', 'tiposgastos.nombre AS tipo_gasto_nombre', 'unidadesmedidas.nombre AS unidad_medida_nombre', 'usuarios.nombre AS usuario_nombre'
                )->leftJoin('tiposgastos', 'gastos.tipo_gasto_id', '=', 'tiposgastos.tipo_gasto_id')
                ->leftJoin('unidadesmedidas', 'gastos.unidad_medida_id', '=', 'unidadesmedidas.unidad_medida_id')
                ->leftJoin('usuarios', 'gastos.usuario_id', '=', 'usuarios.usuario_id');

        // if (!empty($filters['proveedor_id'])) {
        //     $query->where('proveedoresproductos.proveedor_id', $filters['proveedor_id']);
        // }

        return $query;

    }
}
