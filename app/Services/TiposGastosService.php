<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\TiposGastos;
use App\Repositories\TiposGastosRepository;

class TiposGastosService
{
    protected TiposGastosRepository $tiposgastosRepository;

    public function __construct(TiposGastosRepository $tiposgastosRepository)
    {
        $this->tiposgastosRepository = $tiposgastosRepository;
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
        $query = $this->tiposgastosRepository->queryDataTable();

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
     * @return TiposGastos
     */
    public function create(array $data): TiposGastos
    {
        try {
            return $this->tiposgastosRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param TiposGastos $modelo
     * @param array $data
     * @return bool
     */
    public function update(TiposGastos $modelo, array $data): bool
    {
        try {
            return $this->tiposgastosRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param TiposGastos $modelo
     * @return bool|null
     */
    public function delete(TiposGastos $modelo)
    {
        try {
            return $this->tiposgastosRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}