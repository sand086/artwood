<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\ProveedoresMateriales;
use App\Repositories\ProveedoresMaterialesRepository;

class ProveedoresMaterialesService
{
    protected ProveedoresMaterialesRepository $proveedoresmaterialesRepository;

    public function __construct(ProveedoresMaterialesRepository $proveedoresmaterialesRepository)
    {
        $this->proveedoresmaterialesRepository = $proveedoresmaterialesRepository;
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
        $query = $this->proveedoresmaterialesRepository->queryDataTableFromView($filters);

        $actionsCallback = function ($row) use ($actionsConfig, $module, $keyName) {
            return view('components.datatable-actions', compact('row', 'actionsConfig', 'module', 'keyName'))->render();
        };

        return DataTables::of($query)
            ->addColumn('action', $actionsCallback)
            ->rawColumns(['action'])
            ->filterColumn('material_nombre', function ($query, $keyword) {
                $query->where('material_nombre', 'like', "%{$keyword}%");
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
     * @return ProveedoresMateriales
     */
    public function create(array $data): ProveedoresMateriales
    {
        try {
            return $this->proveedoresmaterialesRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param ProveedoresMateriales $modelo
     * @param array $data
     * @return bool
     */
    public function update(ProveedoresMateriales $modelo, array $data): bool
    {
        try {
            return $this->proveedoresmaterialesRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param ProveedoresMateriales $modelo
     * @return bool|null
     */
    public function delete(ProveedoresMateriales $modelo)
    {
        try {
            return $this->proveedoresmaterialesRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}