<?php

namespace App\Services;

use App\Models\Usuarios;
use App\Repositories\UsuariosRepository;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class UsuariosService
{
    protected UsuariosRepository $usuariosRepository;

    public function __construct(UsuariosRepository $usuariosRepository)
    {
        $this->usuariosRepository = $usuariosRepository;
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
        $query = $this->usuariosRepository->queryDataTable();

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
     * @return Usuarios
     */
    public function create(array $data): Usuarios
    {
        try {
            return $this->usuariosRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param Usuarios $modelo
     * @param array $data
     * @return bool
     */
    public function update(Usuarios $modelo, array $data): bool
    {
        try {
            return $this->usuariosRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param Usuarios $modelo
     * @return bool|null
     */
    public function delete(Usuarios $modelo)
    {
        try {
            return $this->usuariosRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}