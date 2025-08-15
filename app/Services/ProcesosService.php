<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\Procesos;
use App\Repositories\ProcesosRepository;

class ProcesosService
{
    protected ProcesosRepository $procesosRepository;

    public function __construct(ProcesosRepository $procesosRepository)
    {
        $this->procesosRepository = $procesosRepository;
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
    public function getDataTable(array $columns, array $actionsConfig, string $module, string $keyName, array $filters = [])
    {
        $query = $this->procesosRepository->queryDataTable($filters);

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
     * @return Procesos
     */
    public function create(array $data): Procesos
    {
        try {
            return $this->procesosRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param Procesos $modelo
     * @param array $data
     * @return bool
     */
    public function update(Procesos $modelo, array $data): bool
    {
        try {
            return $this->procesosRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param Procesos $modelo
     * @return bool|null
     */
    public function delete(Procesos $modelo)
    {
        try {
            return $this->procesosRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}