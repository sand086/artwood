<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\ClientesContactos;
use App\Repositories\ClientesContactosRepository;

class ClientesContactosService
{
    protected ClientesContactosRepository $clientescontactosRepository;

    public function __construct(ClientesContactosRepository $clientescontactosRepository)
    {
        $this->clientescontactosRepository = $clientescontactosRepository;
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
        $query = $this->clientescontactosRepository->queryDataTableFromView($filters);

        $actionsCallback = function ($row) use ($actionsConfig, $module, $keyName) {
            return view('components.datatable-actions', compact('row', 'actionsConfig', 'module', 'keyName'))->render();
        };

        return DataTables::of($query)
            ->addColumn('action', $actionsCallback)
            ->rawColumns(['action'])
            ->filterColumn('contacto_nombre_completo', function ($query, $keyword) {
                // La vista ya tiene la columna concatenada
                $query->where('contacto_nombre_completo', 'like', "%{$keyword}%");
            })
            ->make(true);
    }

    /**
     * Crea un nuevo registro.
     *
     * @param array $data
     * @return ClientesContactos
     */
    public function create(array $data): ClientesContactos
    {
        try {
            return $this->clientescontactosRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param ClientesContactos $modelo
     * @param array $data
     * @return bool
     */
    public function update(ClientesContactos $modelo, array $data): bool
    {
        try {
            return $this->clientescontactosRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param ClientesContactos $modelo
     * @return bool|null
     */
    public function delete(ClientesContactos $modelo)
    {
        try {
            return $this->clientescontactosRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}