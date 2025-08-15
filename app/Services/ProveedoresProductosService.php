<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\ProveedoresProductos;
use App\Repositories\ProveedoresProductosRepository;

class ProveedoresProductosService
{
    protected ProveedoresProductosRepository $proveedoresproductosRepository;

    public function __construct(ProveedoresProductosRepository $proveedoresproductosRepository)
    {
        $this->proveedoresproductosRepository = $proveedoresproductosRepository;
    }

    /**
     * Genera la data para la DataTable.
     *
     * @param array $columns
     * @param array $actionsConfig
     * @param string $module
     * @param string $keyName
     * @param array $filters
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDataTable(array $columns, array $actionsConfig, string $module, string $keyName, array $filters = [])
    {
        $query = $this->proveedoresproductosRepository->queryDataTableFromView($filters);

        $actionsCallback = function ($row) use ($actionsConfig, $module, $keyName) {
            return view('components.datatable-actions', compact('row', 'actionsConfig', 'module', 'keyName'))->render();
        };

        return DataTables::of($query)
            ->addColumn('action', $actionsCallback)
            ->rawColumns(['action'])
            ->filterColumn('producto_nombre', function ($query, $keyword) {
                $query->where('producto_nombre', 'like', "%{$keyword}%");
            })
            ->filterColumn('unidad_medida_nombre', function ($query, $keyword) {
                $query->where('unidad_medida_nombre', 'like', "%{$keyword}%");
            })
            ->make(true);
    }

    /**
     * Crea un nuevo registro.
     *
     * @param array $data
     * @return ProveedoresProductos
     */
    public function create(array $data): ProveedoresProductos
    {
        try {
            return $this->proveedoresproductosRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param ProveedoresProductos $modelo
     * @param array $data
     * @return bool
     */
    public function update(ProveedoresProductos $modelo, array $data): bool
    {
        try {
            return $this->proveedoresproductosRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param ProveedoresProductos $modelo
     * @return bool|null
     */
    public function delete(ProveedoresProductos $modelo)
    {
        try {
            return $this->proveedoresproductosRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}