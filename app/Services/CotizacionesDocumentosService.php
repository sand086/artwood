<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\CotizacionesDocumentos;
use App\Repositories\CotizacionesDocumentosRepository;

class CotizacionesDocumentosService
{
    protected CotizacionesDocumentosRepository $cotizacionesdocumentosRepository;

    public function __construct(CotizacionesDocumentosRepository $cotizacionesdocumentosRepository)
    {
        $this->cotizacionesdocumentosRepository = $cotizacionesdocumentosRepository;
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
        $query = $this->cotizacionesdocumentosRepository->queryDataTable($filters);

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
     * @return CotizacionesDocumentos
     */
    public function create(array $data): CotizacionesDocumentos
    {
        try {
            return $this->cotizacionesdocumentosRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param CotizacionesDocumentos $modelo
     * @param array $data
     * @return bool
     */
    public function update(CotizacionesDocumentos $modelo, array $data): bool
    {
        try {
            return $this->cotizacionesdocumentosRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param CotizacionesDocumentos $modelo
     * @return bool|null
     */
    public function delete(CotizacionesDocumentos $modelo)
    {
        try {
            return $this->cotizacionesdocumentosRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }
}