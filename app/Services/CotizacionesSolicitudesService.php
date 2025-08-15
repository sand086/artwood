<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\CotizacionesSolicitudes;
use App\Repositories\CotizacionesSolicitudesRepository;

class CotizacionesSolicitudesService
{
    protected CotizacionesSolicitudesRepository $cotizacionessolicitudesRepository;

    public function __construct(CotizacionesSolicitudesRepository $cotizacionessolicitudesRepository)
    {
        $this->cotizacionessolicitudesRepository = $cotizacionessolicitudesRepository;
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
        // $query = $this->cotizacionessolicitudesRepository->queryDataTable($filters);
        $query = $this->cotizacionessolicitudesRepository->queryDataTableFromView($filters);

        $actionsCallback = function ($row) use ($actionsConfig, $module, $keyName) {
            return view('components.datatable-actions', compact('row', 'actionsConfig', 'module', 'keyName'))->render();
        };

        return DataTables::of($query)
            ->addColumn('action', $actionsCallback)
            ->rawColumns(['action'])
            ->filterColumn('cliente_nombre', function ($query, $keyword) {
                $query->where('cliente_nombre', 'like', "%{$keyword}%");
            })
            ->filterColumn('tipo_solicitud_nombre', function ($query, $keyword) {
                $query->where('tipo_solicitud_nombre', 'like', "%{$keyword}%");
            })
            ->filterColumn('fuente_nombre', function ($query, $keyword) {
                $query->where('fuente_nombre', 'like', "%{$keyword}%");
            })
            ->filterColumn('estado_nombre', function ($query, $keyword) {
                $query->where('estado_nombre', 'like', "%{$keyword}%");
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
     * @return CotizacionesSolicitudes
     */
    public function create(array $data): CotizacionesSolicitudes
    {
        DB::beginTransaction();
        try {
            // return $this->cotizacionessolicitudesRepository->create($data);
            $data['consecutivo'] = $this->generarConsecutivo();

            // Llama al repositorio para crear el registro con el consecutivo asignado
            $cotizacion = $this->cotizacionessolicitudesRepository->create($data);

            DB::commit();

            return $cotizacion;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param CotizacionesSolicitudes $modelo
     * @param array $data
     * @return bool
     */
    public function update(CotizacionesSolicitudes $modelo, array $data): bool
    {
        try {
            return $this->cotizacionessolicitudesRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param CotizacionesSolicitudes $modelo
     * @return bool|null
     */
    public function delete(CotizacionesSolicitudes $modelo)
    {
        try {
            return $this->cotizacionessolicitudesRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Genera el siguiente número consecutivo para el año actual.
     * @return string
     */
    private function generarConsecutivo(): string
    {
        // Obtiene el año actual
        $currentYear = now()->year;

        // Busca el último consecutivo creado este año
        $lastConsecutivo = $this->cotizacionessolicitudesRepository->findLastConsecutivoForYear($currentYear);
        
        $consecutiveNumber = 1;

        if ($lastConsecutivo) {
            // Extrae los últimos 4 dígitos del consecutivo
            $lastNumber = (int) substr($lastConsecutivo, -4);
            $consecutiveNumber = $lastNumber + 1;
        }

        // Formatea el número a 4 dígitos y lo concatena con el año
        return $currentYear . str_pad($consecutiveNumber, 4, '0', STR_PAD_LEFT);
    }
}