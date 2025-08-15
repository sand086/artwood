<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\ProveedoresEquipos;
use App\Repositories\ProveedoresEquiposRepository;

class ProveedoresEquiposService
{
    protected ProveedoresEquiposRepository $proveedoresequiposRepository;

    public function __construct(ProveedoresEquiposRepository $proveedoresequiposRepository)
    {
        $this->proveedoresequiposRepository = $proveedoresequiposRepository;
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
        $query = $this->proveedoresequiposRepository->queryDataTableFromView($filters);

        $actionsCallback = function ($row) use ($actionsConfig, $module, $keyName) {
            return view('components.datatable-actions', compact('row', 'actionsConfig', 'module', 'keyName'))->render();
        };

        return DataTables::of($query)
            ->addColumn('action', $actionsCallback)
            ->rawColumns(['action'])
            ->filterColumn('equipo_nombre', function ($query, $keyword) {
                $query->where('equipo_nombre', 'like', "%{$keyword}%");
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
     * @return ProveedoresEquipos
     */
    public function create(array $data): ProveedoresEquipos
    {
        try {
            return $this->proveedoresequiposRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param ProveedoresEquipos $modelo
     * @param array $data
     * @return bool
     */
    public function update(ProveedoresEquipos $modelo, array $data): bool
    {
        try {
            return $this->proveedoresequiposRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param ProveedoresEquipos $modelo
     * @return bool|null
     */
    public function delete(ProveedoresEquipos $modelo)
    {
        try {
            return $this->proveedoresequiposRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}