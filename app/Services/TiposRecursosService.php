<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\TiposRecursos;
use App\Repositories\TiposRecursosRepository;

class TiposRecursosService
{
    protected TiposRecursosRepository $tiposrecursosRepository;

    public function __construct(TiposRecursosRepository $tiposrecursosRepository)
    {
        $this->tiposrecursosRepository = $tiposrecursosRepository;
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
        $query = $this->tiposrecursosRepository->queryDataTable($filters);

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
     * @return TiposRecursos
     */
    public function create(array $data): TiposRecursos
    {
        try {
            return $this->tiposrecursosRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param TiposRecursos $modelo
     * @param array $data
     * @return bool
     */
    public function update(TiposRecursos $modelo, array $data): bool
    {
        try {
            return $this->tiposrecursosRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param TiposRecursos $modelo
     * @return bool|null
     */
    public function delete(TiposRecursos $modelo)
    {
        try {
            return $this->tiposrecursosRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}