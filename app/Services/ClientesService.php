<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\Clientes;
use App\Repositories\ClientesRepository;

class ClientesService
{
    protected ClientesRepository $clientesRepository;

    public function __construct(ClientesRepository $clientesRepository)
    {
        $this->clientesRepository = $clientesRepository;
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
        $query = $this->clientesRepository->queryDataTableFromView($filters);

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
            ->filterColumn('tipo_cliente_nombre', function ($query, $keyword) {
                $query->where('tipo_cliente_nombre', 'like', "%{$keyword}%");
            })
            ->make(true);
    }

    /**
     * Crea un nuevo registro.
     *
     * @param array $data
     * @return Clientes
     */
    public function create(array $data): Clientes
    {
        try {
            $data['rfc'] = $this->validateRfc($data['rfc'] ?? null);
            return $this->clientesRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param Clientes $modelo
     * @param array $data
     * @return bool
     */
    public function update(Clientes $modelo, array $data): bool
    {
        try {
            return $this->clientesRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param Clientes $modelo
     * @return bool|null
     */
    public function delete(Clientes $modelo)
    {
        try {
            return $this->clientesRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Sanitize RFC value.
     *
     * @param string|null $rfc
     * @return string
     */
    protected function validateRfc(?string $rfc): string
    {
        return empty(trim($rfc)) ? '00000000' : $rfc;
    }
}