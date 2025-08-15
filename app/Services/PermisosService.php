<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\Permisos;
use App\Repositories\PermisosRepository;

class PermisosService
{
    protected PermisosRepository $permisosRepository;

    public function __construct(PermisosRepository $permisosRepository)
    {
        $this->permisosRepository = $permisosRepository;
    }

    /**
     * Genera la data para la DataTable.
     *
     * @param array $columns
     * @param array $actionsConfig
     * @param string $module
     * @param string $keyName
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDataTable(array $columns, array $actionsConfig, string $module, string $keyName)
    {
        $query = $this->permisosRepository->queryDataTable();

        $actionsCallback = function ($row) use ($actionsConfig, $module, $keyName) {
            return view('components.datatable-actions', compact('row', 'actionsConfig', 'module', 'keyName'))->render();
        };

        return DataTables::of($query)
            ->addColumn('action', $actionsCallback)
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Crea un nuevo registro.
     *
     * @param array $data
     * @return Permisos
     */
    public function create(array $data): Permisos
    {
        try {
            return $this->permisosRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param Permisos $modelo
     * @param array $data
     * @return bool
     */
    public function update(Permisos $modelo, array $data): bool
    {
        try {
            return $this->permisosRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param Permisos $modelo
     * @return bool|null
     */
    public function delete(Permisos $modelo)
    {
        try {
            return $this->permisosRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}