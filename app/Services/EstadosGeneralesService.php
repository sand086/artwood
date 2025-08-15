<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\EstadosGenerales;
use App\Repositories\EstadosGeneralesRepository;

class EstadosGeneralesService
{
    protected EstadosGeneralesRepository $estadosgeneralesRepository;

    public function __construct(EstadosGeneralesRepository $estadosgeneralesRepository)
    {
        $this->estadosgeneralesRepository = $estadosgeneralesRepository;
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
    public function getDataTable(array $columns, array $actionsConfig, string $module, string $keyName)
    {
        $query = $this->estadosgeneralesRepository->queryDataTable();

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
     * @return EstadosGenerales
     */
    public function create(array $data): EstadosGenerales
    {
        try {
            return $this->estadosgeneralesRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param EstadosGenerales $modelo
     * @param array $data
     * @return bool
     */
    public function update(EstadosGenerales $modelo, array $data): bool
    {
        try {
            return $this->estadosgeneralesRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param EstadosGenerales $modelo
     * @return bool|null
     */
    public function delete(EstadosGenerales $modelo)
    {
        try {
            return $this->estadosgeneralesRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}