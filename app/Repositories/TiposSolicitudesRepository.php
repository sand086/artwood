<?php

namespace App\Repositories;

use App\Models\TiposSolicitudes;
use Illuminate\Database\Eloquent\Builder;

class TiposSolicitudesRepository extends BaseRepository
{
    public function __construct(TiposSolicitudes $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(): Builder
    {
        return $this->model->select('tipo_solicitud_id', 'nombre', 'descripcion', 'estado', 'fecha_registro', 'fecha_actualizacion');
    }
}