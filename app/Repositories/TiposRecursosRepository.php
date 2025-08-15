<?php

namespace App\Repositories;

use App\Models\TiposRecursos;
use Illuminate\Database\Eloquent\Builder;

class TiposRecursosRepository extends BaseRepository
{
    public function __construct(TiposRecursos $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->select('tipo_recurso_id', 'nombre', 'descripcion', 'estado', 'fecha_registro', 'fecha_actualizacion');
        return $this->model->newQuery()->select('tipo_recurso_id', 'nombre', 'tabla_referencia', 'descripcion', 'estado', 'fecha_registro', 'fecha_actualizacion');

    }
}
