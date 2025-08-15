<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\Productos;
use App\Repositories\ProductosRepository;

class ProductosService
{
    protected ProductosRepository $productosRepository;

    public function __construct(ProductosRepository $productosRepository)
    {
        $this->productosRepository = $productosRepository;
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
        $query = $this->productosRepository->queryDataTableFromView($filters);

        $actionsCallback = function ($row) use ($actionsConfig, $module, $keyName) {
            return view('components.datatable-actions', compact('row', 'actionsConfig', 'module', 'keyName'))->render();
        };

        return DataTables::of($query)
            ->addColumn('action', $actionsCallback)
            ->rawColumns(['action'])
            ->filterColumn('unidad_medida_nombre', function ($query, $keyword) {
                $query->where('unidad_medida_nombre', 'like', "%{$keyword}%");
            })
            ->filterColumn('proveedores', function ($query, $keyword) {
                $query->where('proveedores', 'like', "%{$keyword}%");
            })
            ->make(true);
    }

    /**
     * Crea un nuevo registro.
     *
     * @param array $data
     * @return Productos
     */
    public function create(array $data): Productos
    {
        try {
            return $this->productosRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param Productos $modelo
     * @param array $data
     * @return bool
     */
    public function update(Productos $modelo, array $data): bool
    {
        try {
            return $this->productosRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param Productos $modelo
     * @return bool|null
     */
    public function delete(Productos $modelo)
    {
        try {
            return $this->productosRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}