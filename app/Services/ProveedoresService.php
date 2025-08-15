<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\Proveedores;
use App\Repositories\ProveedoresRepository;

class ProveedoresService
{
    protected ProveedoresRepository $proveedoresRepository;

    public function __construct(ProveedoresRepository $proveedoresRepository)
    {
        $this->proveedoresRepository = $proveedoresRepository;
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
        $query = $this->proveedoresRepository->queryDataTableFromView($filters);

        $actionsCallback = function ($row) use ($actionsConfig, $module, $keyName) {
            return view('components.datatable-actions', compact('row', 'actionsConfig', 'module', 'keyName'))->render();
        };

        return DataTables::of($query)
            ->addColumn('action', $actionsCallback)
            ->rawColumns(['action'])
            ->filterColumn('estado_pais_nombre', function ($query, $keyword) {
                $query->where('estado_pais_nombre', 'like', "%{$keyword}%");
            })
            ->filterColumn('municipio_nombre', function ($query, $keyword) {
                $query->where('municipio_nombre', 'like', "%{$keyword}%");
            })
            ->filterColumn('usuario_nombre', function ($query, $keyword) {
                $query->where('usuario_nombre', 'like', "%{$keyword}%");
            })
            ->make(true);
    }

    /**
     * Crea un nuevo registro.
     *
     * @param array $data
     * @return Proveedores
     */
    public function create(array $data): Proveedores
    {
        try {
            // Si el codigo_postal llega como una cadena vacía, asigna el valor por defecto
            if (empty($data['codigo_postal'])) {
                $data['codigo_postal'] = '00000000';
            }
            return $this->proveedoresRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param Proveedores $modelo
     * @param array $data
     * @return bool
     */
    public function update(Proveedores $modelo, array $data): bool
    {
        try {
            // Si el codigo_postal llega como una cadena vacía, asigna el valor por defecto
            if (empty($data['codigo_postal'])) {
                $data['codigo_postal'] = '00000000';
            }
            return $this->proveedoresRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param Proveedores $modelo
     * @return bool|null
     */
    public function delete(Proveedores $modelo)
    {
        try {
            return $this->proveedoresRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}