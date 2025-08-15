<?php

namespace App\Repositories;

use App\Models\Roles;
use Illuminate\Database\Eloquent\Builder;

class RolesRepository extends BaseRepository
{
    public function __construct(Roles $model)
    {
        parent::__construct($model);
    }

    /**
     * Retorna una consulta para DataTable con los campos principales de Roles.
     *
     * @return Builder
     */
    public function queryDataTable(): Builder
    {
        return $this->model->newQuery()
            ->select(
                'roles.role_id',
                'roles.name',
                'roles.guard_name',
                'roles.descripcion',
                'roles.estado',
                'roles.fecha_registro',
                'roles.fecha_actualizacion'
            )
            ->orderBy('roles.name', 'asc');
    }
}
