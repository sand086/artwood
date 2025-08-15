<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\UnidadesMedidas;
use App\Repositories\UnidadesMedidasRepository;

class UnidadesMedidasService
{
    protected UnidadesMedidasRepository $unidadesmedidasRepository;

    public function __construct(UnidadesMedidasRepository $unidadesmedidasRepository)
    {
        $this->unidadesmedidasRepository = $unidadesmedidasRepository;
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
        $query = $this->unidadesmedidasRepository->queryDataTable();

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
     * @return UnidadesMedidas
     */
    public function create(array $data): UnidadesMedidas
    {
        try {
            return $this->unidadesmedidasRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param UnidadesMedidas $modelo
     * @param array $data
     * @return bool
     */
    public function update(UnidadesMedidas $modelo, array $data): bool
    {
        try {
            return $this->unidadesmedidasRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param UnidadesMedidas $modelo
     * @return bool|null
     */
    public function delete(UnidadesMedidas $modelo)
    {
        try {
            return $this->unidadesmedidasRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}