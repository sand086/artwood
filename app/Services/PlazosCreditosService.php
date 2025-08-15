<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\PlazosCreditos;
use App\Repositories\PlazosCreditosRepository;

class PlazosCreditosService
{
    protected PlazosCreditosRepository $plazoscreditosRepository;

    public function __construct(PlazosCreditosRepository $plazoscreditosRepository)
    {
        $this->plazoscreditosRepository = $plazoscreditosRepository;
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
        $query = $this->plazoscreditosRepository->queryDataTable();

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
     * @return PlazosCreditos
     */
    public function create(array $data): PlazosCreditos
    {
        try {
            return $this->plazoscreditosRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param PlazosCreditos $modelo
     * @param array $data
     * @return bool
     */
    public function update(PlazosCreditos $modelo, array $data): bool
    {
        try {
            return $this->plazoscreditosRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param PlazosCreditos $modelo
     * @return bool|null
     */
    public function delete(PlazosCreditos $modelo)
    {
        try {
            return $this->plazoscreditosRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}