<?php

namespace App\Repositories;

use App\Models\Areas;
use Illuminate\Database\Eloquent\Builder;

class AreasRepository extends BaseRepository
{
    public function __construct(Areas $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        return $this->model->newQuery()->select('area_id', 'nombre', 'descripcion', 'estado', 'fecha_registro', 'fecha_actualizacion');

    }
}
