<?php

namespace App\Repositories;

use App\Models\Procesos;
use Illuminate\Database\Eloquent\Builder;

class ProcesosRepository extends BaseRepository
{
    public function __construct(Procesos $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->select('proceso_id', 'nombre', 'descripcion', 'presupuesto_estimado', 'fecha_estimada', 'comentarios', 'estado', 'fecha_registro', 'fecha_actualizacion');
        return $this->model->newQuery()->select('proceso_id', 'nombre', 'descripcion', 'presupuesto_estimado', 'fecha_estimada', 'comentarios', 'estado', 'fecha_registro', 'fecha_actualizacion');

    }
}
