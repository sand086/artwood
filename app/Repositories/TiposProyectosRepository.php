<?php

namespace App\Repositories;

use App\Models\TiposProyectos;
use Illuminate\Database\Eloquent\Builder;

class TiposProyectosRepository extends BaseRepository
{
    public function __construct(TiposProyectos $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->select('tipo_proyecto_id', 'nombre', 'descripcion', 'estado', 'fecha_registro', 'fecha_actualizacion');
        return $this->model->newQuery()->select('tipo_proyecto_id', 'nombre', 'descripcion', 'estado', 'fecha_registro', 'fecha_actualizacion');

    }
}
