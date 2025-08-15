<?php

namespace App\Repositories;

use App\Models\Personas;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PersonasRepository extends BaseRepository
{
    public function __construct(Personas $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->select('persona_id', 'nombres', 'apellidos', 'direccion', 'telefono', 'correo_electronico', 'tipo_identificacion_id', 'identificador', 'estado_pais_id', 'municipio_id', 'estado', 'fecha_registro', 'fecha_actualizacion');

        // $algo = Personas::select(
        //                     'personas.persona_id',
        //                     'personas.nombres',
        //                     'personas.apellidos',
        //                     'personas.direccion',
        //                     'personas.telefono',
        //                     'personas.correo_electronico',
        //                     'personas.tipo_identificacion_id',
        //                     'personas.identificador',
        //                     'personas.estado_pais_id',
        //                     'personas.municipio_id',
        //                     'personas.estado',
        //                     'personas.fecha_registro',
        //                     'personas.fecha_actualizacion',
        //                     DB::raw("GROUP_CONCAT(
        //                         CASE
        //                             WHEN proveedores.proveedor_id IS NOT NULL THEN CONCAT('PROVEEDOR: ', COALESCE(proveedores.nombre, personas.nombres, ''))
        //                             WHEN clientes.cliente_id IS NOT NULL THEN CONCAT('CLIENTE: ', COALESCE(clientes.nombre, personas.nombres, ''))
        //                             WHEN empleados.empleado_id IS NOT NULL THEN 'EMPLEADO: SI'
        //                             ELSE NULL
        //                         END SEPARATOR '<br>'
        //                     ) as relaciones")
        //                 )
        //                 ->leftJoin('proveedorescontactos', 'personas.persona_id', '=', 'proveedorescontactos.persona_id')
        //                 ->leftJoin('proveedores', 'proveedorescontactos.proveedor_id', '=', 'proveedores.proveedor_id')
        //                 ->leftJoin('clientescontactos', 'personas.persona_id', '=', 'clientescontactos.persona_id')
        //                 ->leftJoin('clientes', 'clientescontactos.cliente_id', '=', 'clientes.cliente_id')
        //                 ->leftJoin('empleados', 'personas.persona_id', '=', 'empleados.persona_id')
        //                 ->groupBy(
        //                     'personas.persona_id',
        //                     'personas.nombres',
        //                     'personas.apellidos',
        //                     'personas.direccion',
        //                     'personas.telefono',
        //                     'personas.correo_electronico',
        //                     'personas.tipo_identificacion_id',
        //                     'personas.identificador',
        //                     'personas.estado_pais_id',
        //                     'personas.municipio_id',
        //                     'personas.estado',
        //                     'personas.fecha_registro',
        //                     'personas.fecha_actualizacion'
        //                 )
        //                 ->get();

        $query = $this->model->newQuery()
                ->select(
                    'personas.persona_id',
                            'personas.nombres',
                            'personas.apellidos',
                            'personas.direccion',
                            'personas.telefono',
                            'personas.correo_electronico',
                            'personas.tipo_identificacion_id',
                            'personas.identificador',
                            'personas.estado_pais_id',
                            'personas.municipio_id',
                            'personas.estado',
                            'personas.fecha_registro',
                            'personas.fecha_actualizacion',
                            DB::raw("GROUP_CONCAT(
                                CASE
                                    WHEN proveedores.proveedor_id IS NOT NULL THEN CONCAT('PROVEEDOR: ', COALESCE(proveedores.nombre, personas.nombres, ''))
                                    WHEN clientes.cliente_id IS NOT NULL THEN CONCAT('CLIENTE: ', COALESCE(clientes.nombre, personas.nombres, ''))
                                    WHEN empleados.empleado_id IS NOT NULL THEN 'EMPLEADO: SI'
                                    ELSE NULL
                                END SEPARATOR '<br>'
                            ) as relaciones"),
                )->leftJoin('proveedorescontactos', 'personas.persona_id', '=', 'proveedorescontactos.persona_id')
                ->leftJoin('proveedores', 'proveedorescontactos.proveedor_id', '=', 'proveedores.proveedor_id')
                ->leftJoin('clientescontactos', 'personas.persona_id', '=', 'clientescontactos.persona_id')
                ->leftJoin('clientes', 'clientescontactos.cliente_id', '=', 'clientes.cliente_id')
                ->leftJoin('empleados', 'personas.persona_id', '=', 'empleados.persona_id')
                ->groupBy(
                    'personas.persona_id',
                    'personas.nombres',
                    'personas.apellidos',
                    'personas.direccion',
                    'personas.telefono',
                    'personas.correo_electronico',
                    'personas.tipo_identificacion_id',
                    'personas.identificador',
                    'personas.estado_pais_id',
                    'personas.municipio_id',
                    'personas.estado',
                    'personas.fecha_registro',
                    'personas.fecha_actualizacion'
                );

        if (!empty($filters['persona_id'])) {
            $query->where('personas.persona_id', $filters['persona_id']);
        }

        return $query;
    }
}