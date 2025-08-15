<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\ProcesosActividades;
use App\Repositories\ProcesosActividadesRepository;

class ProcesosActividadesService
{
    protected ProcesosActividadesRepository $procesosactividadesRepository;

    public function __construct(ProcesosActividadesRepository $procesosactividadesRepository)
    {
        $this->procesosactividadesRepository = $procesosactividadesRepository;
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
        $query = $this->procesosactividadesRepository->queryDataTable($filters);

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
     * @return ProcesosActividades
     */
    public function create(array $data): ProcesosActividades
    {
        try {
            return $this->procesosactividadesRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param ProcesosActividades $modelo
     * @param array $data
     * @return bool
     */
    public function update(ProcesosActividades $modelo, array $data): bool
    {
        try {
            return $this->procesosactividadesRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param ProcesosActividades $modelo
     * @return bool|null
     */
    public function delete(ProcesosActividades $modelo)
    {
        try {
            return $this->procesosactividadesRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}