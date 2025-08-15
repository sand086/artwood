<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\ProveedoresServicios;
use App\Repositories\ProveedoresServiciosRepository;

class ProveedoresServiciosService
{
    protected ProveedoresServiciosRepository $proveedoresserviciosRepository;

    public function __construct(ProveedoresServiciosRepository $proveedoresserviciosRepository)
    {
        $this->proveedoresserviciosRepository = $proveedoresserviciosRepository;
    }

    /**
     * Genera la data para la DataTable.
     *
     * @param array $columns
     * @param array $actionsConfig
     * @param string $module
     * @param string $keyName
     * @param array $filters
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDataTable(array $columns, array $actionsConfig, string $module, string $keyName, array $filters = [])
    {
        $query = $this->proveedoresserviciosRepository->queryDataTableFromView($filters);

        $actionsCallback = function ($row) use ($actionsConfig, $module, $keyName) {
            return view('components.datatable-actions', compact('row', 'actionsConfig', 'module', 'keyName'))->render();
        };

        return DataTables::of($query)
            ->addColumn('action', $actionsCallback)
            ->rawColumns(['action'])
            ->filterColumn('servicio_nombre', function ($query, $keyword) {
                $query->where('servicio_nombre', 'like', "%{$keyword}%");
            })
            ->filterColumn('unidad_medida_nombre', function ($query, $keyword) {
                $query->where('unidad_medida_nombre', 'like', "%{$keyword}%");
            })
            ->make(true);
    }

    /**
     * Crea un nuevo registro.
     *
     * @param array $data
     * @return ProveedoresServicios
     */
    public function create(array $data): ProveedoresServicios
    {
        try {
            return $this->proveedoresserviciosRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param ProveedoresServicios $modelo
     * @param array $data
     * @return bool
     */
    public function update(ProveedoresServicios $modelo, array $data): bool
    {
        try {
            return $this->proveedoresserviciosRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param ProveedoresServicios $modelo
     * @return bool|null
     */
    public function delete(ProveedoresServicios $modelo)
    {
        try {
            return $this->proveedoresserviciosRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}