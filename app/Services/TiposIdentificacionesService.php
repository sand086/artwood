<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\TiposIdentificaciones;
use App\Repositories\TiposIdentificacionesRepository;

class TiposIdentificacionesService
{
    protected TiposIdentificacionesRepository $tiposidentificacionesRepository;

    public function __construct(TiposIdentificacionesRepository $tiposidentificacionesRepository)
    {
        $this->tiposidentificacionesRepository = $tiposidentificacionesRepository;
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
        $query = $this->tiposidentificacionesRepository->queryDataTable($filters);

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
     * @return TiposIdentificaciones
     */
    public function create(array $data): TiposIdentificaciones
    {
        try {
            return $this->tiposidentificacionesRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param TiposIdentificaciones $modelo
     * @param array $data
     * @return bool
     */
    public function update(TiposIdentificaciones $modelo, array $data): bool
    {
        try {
            return $this->tiposidentificacionesRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param TiposIdentificaciones $modelo
     * @return bool|null
     */
    public function delete(TiposIdentificaciones $modelo)
    {
        try {
            return $this->tiposidentificacionesRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}