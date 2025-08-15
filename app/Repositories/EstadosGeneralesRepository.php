<?php

namespace App\Repositories;

use App\Models\EstadosGenerales;
use Illuminate\Database\Eloquent\Builder;

class EstadosGeneralesRepository extends BaseRepository
{
    public function __construct(EstadosGenerales $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(): Builder
    {
        return $this->model->select('estado_general_id', 'nombre', 'categoria', 'estado', 'fecha_registro', 'fecha_actualizacion');
    }
}