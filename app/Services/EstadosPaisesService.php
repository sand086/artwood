<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\EstadosPaises;
use App\Repositories\EstadosPaisesRepository;

class EstadosPaisesService
{
    protected EstadosPaisesRepository $estadospaisesRepository;

    public function __construct(EstadosPaisesRepository $estadospaisesRepository)
    {
        $this->estadospaisesRepository = $estadospaisesRepository;
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
        $query = $this->estadospaisesRepository->queryDataTable();

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
     * @return EstadosPaises
     */
    public function create(array $data): EstadosPaises
    {
        try {
            return $this->estadospaisesRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param EstadosPaises $modelo
     * @param array $data
     * @return bool
     */
    public function update(EstadosPaises $modelo, array $data): bool
    {
        try {
            return $this->estadospaisesRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param EstadosPaises $modelo
     * @return bool|null
     */
    public function delete(EstadosPaises $modelo)
    {
        try {
            return $this->estadospaisesRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}