<?php

namespace App\Repositories;

use App\Models\ProveedoresContactos;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class ProveedoresContactosRepository extends BaseRepository
{
    public function __construct(ProveedoresContactos $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // Aquí puedes agregar la lógica para construir la consulta base
        $query = $this->model->newQuery()
                ->select(
                    'proveedor_contacto_id', 'proveedor_id', 'personas.persona_id AS persona_id', 'cargo', 'proveedorescontactos.telefono AS telefono', 'proveedorescontactos.correo_electronico', 'observaciones', 'proveedorescontactos.estado AS estado', 'proveedorescontactos.fecha_registro AS fecha_registro', 'proveedorescontactos.fecha_actualizacion AS fecha_actualizacion',
                    'personas.nombres AS persona_nombres', 'personas.apellidos AS persona_apellidos'
                )->leftJoin('personas', 'proveedorescontactos.persona_id', '=', 'personas.persona_id');

        if (!empty($filters['proveedor_id'])) {
            $query->where('proveedorescontactos.proveedor_id', $filters['proveedor_id']); // Asegúrate de prefijar si haces joins
        }

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
        $query = DB::table('vw_proveedorescontactos');

        if (!empty($filters['proveedor_id'])) {
            $query->where('proveedor_id', $filters['proveedor_id']);
        }

        return $query;
    }
}
