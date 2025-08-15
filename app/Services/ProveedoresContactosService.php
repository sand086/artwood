<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\ProveedoresContactos;
use App\Repositories\ProveedoresContactosRepository;

class ProveedoresContactosService
{
    protected ProveedoresContactosRepository $proveedorescontactosRepository;

    public function __construct(ProveedoresContactosRepository $proveedorescontactosRepository)
    {
        $this->proveedorescontactosRepository = $proveedorescontactosRepository;
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
        $query = $this->proveedorescontactosRepository->queryDataTableFromView($filters);

        $actionsCallback = function ($row) use ($actionsConfig, $module, $keyName) {
            return view('components.datatable-actions', compact('row', 'actionsConfig', 'module', 'keyName'))->render();
        };

        return DataTables::of($query)
            ->addColumn('action', $actionsCallback)
            ->rawColumns(['action'])
            ->filterColumn('contacto_nombre_completo', function ($query, $keyword) {
                $query->where('contacto_nombre_completo', 'like', "%{$keyword}%");
            })
            ->make(true);
    }

    /**
     * Crea un nuevo registro.
     *
     * @param array $data
     * @return ProveedoresContactos
     */
    public function create(array $data): ProveedoresContactos
    {
        try {
            return $this->proveedorescontactosRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param ProveedoresContactos $modelo
     * @param array $data
     * @return bool
     */
    public function update(ProveedoresContactos $modelo, array $data): bool
    {
        try {
            return $this->proveedorescontactosRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param ProveedoresContactos $modelo
     * @return bool|null
     */
    public function delete(ProveedoresContactos $modelo)
    {
        try {
            return $this->proveedorescontactosRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}