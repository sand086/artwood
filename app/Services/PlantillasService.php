<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\Plantillas;
use App\Repositories\PlantillasRepository;

class PlantillasService
{
    protected PlantillasRepository $plantillasRepository;

    public function __construct(PlantillasRepository $plantillasRepository)
    {
        $this->plantillasRepository = $plantillasRepository;
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
        $query = $this->plantillasRepository->queryDataTable($filters);

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
     * @return Plantillas
     */
    public function create(array $data): Plantillas
    {
        try {
            return $this->plantillasRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param Plantillas $modelo
     * @param array $data
     * @return bool
     */
    public function update(Plantillas $modelo, array $data): bool
    {
        try {
            return $this->plantillasRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param Plantillas $modelo
     * @return bool|null
     */
    public function delete(Plantillas $modelo)
    {
        try {
            return $this->plantillasRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}