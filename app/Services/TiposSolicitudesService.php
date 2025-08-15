<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\TiposSolicitudes;
use App\Repositories\TiposSolicitudesRepository;

class TiposSolicitudesService
{
    protected TiposSolicitudesRepository $tipossolicitudesRepository;

    public function __construct(TiposSolicitudesRepository $tipossolicitudesRepository)
    {
        $this->tipossolicitudesRepository = $tipossolicitudesRepository;
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
        $query = $this->tipossolicitudesRepository->queryDataTable();

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
     * @return TiposSolicitudes
     */
    public function create(array $data): TiposSolicitudes
    {
        try {
            return $this->tipossolicitudesRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param TiposSolicitudes $modelo
     * @param array $data
     * @return bool
     */
    public function update(TiposSolicitudes $modelo, array $data): bool
    {
        try {
            return $this->tipossolicitudesRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param TiposSolicitudes $modelo
     * @return bool|null
     */
    public function delete(TiposSolicitudes $modelo)
    {
        try {
            return $this->tipossolicitudesRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}