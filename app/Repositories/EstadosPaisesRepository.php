<?php

namespace App\Repositories;

use App\Models\EstadosPaises;
use Illuminate\Database\Eloquent\Builder;

class EstadosPaisesRepository extends BaseRepository
{
    public function __construct(EstadosPaises $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(): Builder
    {
        return $this->model->select('estado_pais_id', 'nombre', 'pais_id', 'estado', 'fecha_registro', 'fecha_actualizacion');
    }
}