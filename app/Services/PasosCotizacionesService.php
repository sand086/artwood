<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\PasosCotizaciones;
use App\Repositories\PasosCotizacionesRepository;

class PasosCotizacionesService
{
    protected PasosCotizacionesRepository $pasoscotizacionesRepository;

    public function __construct(PasosCotizacionesRepository $pasoscotizacionesRepository)
    {
        $this->pasoscotizacionesRepository = $pasoscotizacionesRepository;
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
        $query = $this->pasoscotizacionesRepository->queryDataTable($filters);

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
     * @return PasosCotizaciones
     */
    public function create(array $data): PasosCotizaciones
    {
        try {
            return $this->pasoscotizacionesRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param PasosCotizaciones $modelo
     * @param array $data
     * @return bool
     */
    public function update(PasosCotizaciones $modelo, array $data): bool
    {
        try {
            return $this->pasoscotizacionesRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param PasosCotizaciones $modelo
     * @return bool|null
     */
    public function delete(PasosCotizaciones $modelo)
    {
        try {
            return $this->pasoscotizacionesRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}