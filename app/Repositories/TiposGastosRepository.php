<?php

namespace App\Repositories;

use App\Models\TiposGastos;
use Illuminate\Database\Eloquent\Builder;

class TiposGastosRepository extends BaseRepository
{
    public function __construct(TiposGastos $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(): Builder
    {
        return $this->model->select('tipo_gasto_id', 'nombre', 'prioridad', 'estado', 'fecha_registro', 'fecha_actualizacion');
    }
}