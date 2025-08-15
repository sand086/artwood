<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\CotizacionesRecursos;
use App\Repositories\CotizacionesRecursosRepository;

class CotizacionesRecursosService
{
    protected CotizacionesRecursosRepository $cotizacionesrecursosRepository;

    public function __construct(CotizacionesRecursosRepository $cotizacionesrecursosRepository)
    {
        $this->cotizacionesrecursosRepository = $cotizacionesrecursosRepository;
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
        // $query = $this->cotizacionesrecursosRepository->queryDataTable($filters);
        $query = $this->cotizacionesrecursosRepository->queryDataTableFromView($filters);

        $actionsCallback = function ($row) use ($actionsConfig, $module, $keyName) {
            return view('components.datatable-actions', compact('row', 'actionsConfig', 'module', 'keyName'))->render();
        };

        return DataTables::of($query)
            ->addColumn('action', $actionsCallback)
            ->rawColumns(['action'])
            ->filterColumn('tipo_recurso_nombre', function ($query, $keyword) {
                $query->where('tipo_recurso_nombre', 'like', "%{$keyword}%");
            })
            ->filterColumn('proveedor_nombre', function ($query, $keyword) {
                $query->where('proveedor_nombre', 'like', "%{$keyword}%");
            })
            ->filterColumn('unidad_medida_nombre', function ($query, $keyword) {
                $query->where('unidad_medida_nombre', 'like', "%{$keyword}%");
            })
            ->filterColumn('usuario_nombre', function ($query, $keyword) {
                $query->where('usuario_nombre', 'like', "%{$keyword}%");
            })
            ->filterColumn('recurso_nombre', function ($query, $keyword) {
                $query->where('recurso_nombre', 'like', "%{$keyword}%");
            })
            ->make(true);
    }

    /**
     * Crea un nuevo registro.
     *
     * @param array $data
     * @return CotizacionesRecursos
     */
    public function create(array $data): CotizacionesRecursos
    {
        try {
            return $this->cotizacionesrecursosRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param CotizacionesRecursos $modelo
     * @param array $data
     * @return bool
     */
    public function update(CotizacionesRecursos $modelo, array $data): bool
    {
        try {
            return $this->cotizacionesrecursosRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param CotizacionesRecursos $modelo
     * @return bool|null
     */
    public function delete(CotizacionesRecursos $modelo)
    {
        try {
            return $this->cotizacionesrecursosRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}