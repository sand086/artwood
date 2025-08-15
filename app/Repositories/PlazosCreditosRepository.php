<?php

namespace App\Repositories;

use App\Models\PlazosCreditos;
use Illuminate\Database\Eloquent\Builder;

class PlazosCreditosRepository extends BaseRepository
{
    public function __construct(PlazosCreditos $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(): Builder
    {
        return $this->model->select('plazo_credito_id', 'nombre', 'estado', 'fecha_registro', 'fecha_actualizacion');
    }
}