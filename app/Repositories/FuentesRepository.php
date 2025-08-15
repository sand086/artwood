<?php

namespace App\Repositories;

use App\Models\Fuentes;
use Illuminate\Database\Eloquent\Builder;

class FuentesRepository extends BaseRepository
{
    public function __construct(Fuentes $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->select('fuente_id', 'nombre', 'descripcion', 'estado', 'fecha_registro', 'fecha_actualizacion');
        return $this->model->newQuery()->select('fuente_id', 'nombre', 'descripcion', 'estado', 'fecha_registro', 'fecha_actualizacion');

    }
}
