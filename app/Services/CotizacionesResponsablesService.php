<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\CotizacionesResponsables;
use App\Repositories\CotizacionesResponsablesRepository;

class CotizacionesResponsablesService
{
    protected CotizacionesResponsablesRepository $cotizacionesresponsablesRepository;

    public function __construct(CotizacionesResponsablesRepository $cotizacionesresponsablesRepository)
    {
        $this->cotizacionesresponsablesRepository = $cotizacionesresponsablesRepository;
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
        // $query = $this->cotizacionesresponsablesRepository->queryDataTable($filters);
        $query = $this->cotizacionesresponsablesRepository->queryDataTableFromView($filters);

        $actionsCallback = function ($row) use ($actionsConfig, $module, $keyName) {
            return view('components.datatable-actions', compact('row', 'actionsConfig', 'module', 'keyName'))->render();
        };

        return DataTables::of($query)
            ->addColumn('action', $actionsCallback)
            ->rawColumns(['action'])
            ->filterColumn('area_nombre', function ($query, $keyword) {
                $query->where('area_nombre', 'like', "%{$keyword}%");
            })
            ->filterColumn('empleado_nombre_completo', function ($query, $keyword) {
                $query->where('empleado_nombre_completo', 'like', "%{$keyword}%");
            })
            ->make(true);
    }

    /**
     * Crea un nuevo registro.
     *
     * @param array $data
     * @return CotizacionesResponsables
     */
    public function create(array $data): CotizacionesResponsables
    {
        try {
            return $this->cotizacionesresponsablesRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param CotizacionesResponsables $modelo
     * @param array $data
     * @return bool
     */
    public function update(CotizacionesResponsables $modelo, array $data): bool
    {
        try {
            return $this->cotizacionesresponsablesRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param CotizacionesResponsables $modelo
     * @return bool|null
     */
    public function delete(CotizacionesResponsables $modelo)
    {
        try {
            return $this->cotizacionesresponsablesRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}