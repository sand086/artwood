<?php

namespace App\Repositories;

use App\Models\UnidadesMedidas;
use Illuminate\Database\Eloquent\Builder;

class UnidadesMedidasRepository extends BaseRepository
{
    public function __construct(UnidadesMedidas $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(): Builder
    {
        return $this->model->select('unidad_medida_id', 'nombre', 'categoria', 'simbolo', 'estado', 'fecha_registro', 'fecha_actualizacion');
    }
}