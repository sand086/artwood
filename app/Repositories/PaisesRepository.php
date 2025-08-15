<?php

namespace App\Repositories;

use App\Models\Paises;
use Illuminate\Database\Eloquent\Builder;

class PaisesRepository extends BaseRepository
{
    public function __construct(Paises $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(): Builder
    {
        return $this->model->select('pais_id', 'nombre', 'codigo_iso', 'estado', 'fecha_registro', 'fecha_actualizacion');
    }
}