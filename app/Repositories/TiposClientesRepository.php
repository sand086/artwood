<?php

namespace App\Repositories;

use App\Models\TiposClientes;
use Illuminate\Database\Eloquent\Builder;

class TiposClientesRepository extends BaseRepository
{
    public function __construct(TiposClientes $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->select('tipo_cliente_id', 'nombre', 'descripcion', 'estado', 'fecha_registro', 'fecha_actualizacion');
        return $this->model->newQuery()->select('tipo_cliente_id', 'nombre', 'descripcion', 'estado', 'fecha_registro', 'fecha_actualizacion');

    }
}
