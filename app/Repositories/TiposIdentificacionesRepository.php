<?php

namespace App\Repositories;

use App\Models\TiposIdentificaciones;
use Illuminate\Database\Eloquent\Builder;

class TiposIdentificacionesRepository extends BaseRepository
{
    public function __construct(TiposIdentificaciones $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->select('tipo_identificacion_id', 'nombre', 'descripcion', 'estado', 'fecha_registro', 'fecha_actualizacion');
        return $this->model->newQuery()->select('tipo_identificacion_id', 'nombre', 'descripcion', 'estado', 'fecha_registro', 'fecha_actualizacion');

    }
}
