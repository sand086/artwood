<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\Cotizaciones;
use App\Repositories\CotizacionesRepository;

class CotizacionesService
{
    protected CotizacionesRepository $cotizacionesRepository;

    public function __construct(CotizacionesRepository $cotizacionesRepository)
    {
        $this->cotizacionesRepository = $cotizacionesRepository;
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
        $query = $this->cotizacionesRepository->queryDataTable($filters);

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
     * @return Cotizaciones
     */
    public function create(array $data): Cotizaciones
    {
        try {
            return $this->cotizacionesRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param Cotizaciones $modelo
     * @param array $data
     * @return bool
     */
    public function update(Cotizaciones $modelo, array $data): bool
    {
        try {
            return $this->cotizacionesRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param Cotizaciones $modelo
     * @return bool|null
     */
    public function delete(Cotizaciones $modelo)
    {
        try {
            return $this->cotizacionesRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}