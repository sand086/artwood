<?php

namespace App\Repositories;

use App\Models\Permisos;
use Illuminate\Database\Eloquent\Builder;

class PermisosRepository extends BaseRepository
{
    public function __construct(Permisos $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(): Builder
    {
        // return $this->model->select('permission_id', );
        return $this->model->newQuery()->select('permission_id', 'name', 'descripcion', 'guard_name', 'estado', 'fecha_registro', 'fecha_actualizacion')
            ->orderBy('name', 'asc');
    }
}
