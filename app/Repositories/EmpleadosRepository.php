<?php

namespace App\Repositories;

use App\Models\Empleados;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class EmpleadosRepository extends BaseRepository
{
    public function __construct(Empleados $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(): Builder
    {
        // return $this->model->select('empleado_id', 'persona_id', 'cargo', 'usuario_id', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'empleado_id', 'empleados.usuario_id', 'empleados.persona_id', 'cargo', 'empleados.estado AS estado', 'empleados.fecha_registro AS fecha_registro', 'empleados.fecha_actualizacion AS fecha_actualizacion', 'usuarios.nombre AS usuario_nombre',
                    DB::raw("CONCAT_WS(' ', personas.nombres, personas.apellidos) AS persona_nombre_completo")
                )->leftJoin('usuarios', 'empleados.usuario_id', '=', 'usuarios.usuario_id')
                ->leftJoin('personas', 'empleados.persona_id', '=', 'personas.persona_id');

        return $query;
    }

    /**
     * Nuevo método específico para obtener la consulta del DataTable usando la vista.
     *
     * @param array $filters
     * @return \Illuminate\Database\Query\Builder
     */
    public function queryDataTableFromView(array $filters = []): QueryBuilder
    {
        $query = DB::table('vw_empleados');

        return $query;
    }
}