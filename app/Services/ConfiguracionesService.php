<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

use App\Models\Configuraciones;
use App\Repositories\ConfiguracionesRepository;

class ConfiguracionesService
{
    protected ConfiguracionesRepository $configuracionesRepository;
    protected const CACHE_KEY_PREFIX = 'CONFIG_';

    public function __construct(ConfiguracionesRepository $configuracionesRepository)
    {
        $this->configuracionesRepository = $configuracionesRepository;
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
        $query = $this->configuracionesRepository->queryDataTable($filters);

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
     * @return Configuraciones
     */
    public function create(array $data): Configuraciones
    {
        try {
            return $this->configuracionesRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param Configuraciones $modelo
     * @param array $data
     * @return bool
     */
    public function update(Configuraciones $modelo, array $data): bool
    {
        try {
            $updated = $this->configuracionesRepository->update($modelo, $data);
            if ($updated) {
                // Invalida el caché para la clave específica que fue actualizada
                // La clave de caché se construye en getValorCacheado
                // $cacheKey = self::CACHE_KEY_PREFIX . $modelo->clave . '_' . ($modelo->fecha_inicio_vigencia ? Carbon::parse($modelo->fecha_inicio_vigencia)->format('YmdHis') : 'now');
                $cacheKey = self::CACHE_KEY_PREFIX . $modelo->clave . '_' . 'now';
                Cache::forget($cacheKey);
                Log::info("Caché invalidado para la clave: {$cacheKey}");
                
                // Si la fecha de fin de vigencia cambia, la anterior clave con fecha_fin_vigencia anterior
                // también podría necesitar ser invalidada si se usó con Carbon::now()
                // Una estrategia más robusta podría ser invalidar cualquier clave con `_now`
                // para la misma 'clave' o considerar un sistema de tags si la app fuera más compleja.
                Cache::forget(self::CACHE_KEY_PREFIX . $modelo->clave . '_now'); // Invalida el caché general para esa clave
            }
            return $updated;
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param Configuraciones $modelo
     * @return bool|null
     */
    public function delete(Configuraciones $modelo)
    {
        try {
            // Guarda la clave antes de eliminar el modelo para poder invalidar el caché
            $clave = $modelo->clave;
            $fechaInicioVigencia = $modelo->fecha_inicio_vigencia;

            $deleted = $this->configuracionesRepository->delete($modelo);
            if ($deleted) {
                // Invalida el caché para la clave específica que fue eliminada
                $cacheKey = self::CACHE_KEY_PREFIX . $clave . '_' . ($fechaInicioVigencia ? Carbon::parse($fechaInicioVigencia)->format('YmdHis') : 'now');
                Cache::forget($cacheKey);
                Log::info("Caché invalidado por eliminación para la clave: {$cacheKey}");

                // Invalida también la clave 'now' por si fue accedida recientemente
                Cache::forget(self::CACHE_KEY_PREFIX . $clave . '_now');
            }
            return $deleted;
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Obtiene el valor de una configuración por su clave y fecha.
     *
     * @param string $clave
     * @param Carbon|null $fecha
     * @return mixed
     */
    public function getValor(string $clave, ?Carbon $fecha = null)
    {
        $fecha = $fecha ?? Carbon::now();
        
        $config = Configuraciones::where('clave', $clave)
            ->where('fecha_inicio_vigencia', '<=', $fecha)
            ->where(function ($query) use ($fecha) {
                $query->whereNull('fecha_fin_vigencia')
                      ->orWhere('fecha_fin_vigencia', '>=', $fecha);
            })
            ->orderByDesc('fecha_inicio_vigencia') // Asegura que si hay solapamientos, tome el más reciente
            ->first();

        if ($config) {
            // Opcional: castear el valor según tipo_dato si lo almacenas como string
            switch ($config->tipo_dato) {
                case 'decimal': return (float) $config->valor;
                case 'integer': return (int) $config->valor;
                case 'boolean': return (bool) $config->valor;
                default: return $config->valor;
            }
        }

        return null; // O un valor por defecto si no se encuentra
    }

    /**
     * Obtiene el valor de una configuración por su clave y fecha, cacheando el resultado.
     *
     * @param string $clave
     * @param Carbon|null $fecha
     * @return mixed
     */
    public function getValorCacheado(string $clave, ?Carbon $fecha = null)
    {
        $fechaComponent = $fecha ? $fecha->format('YmdHis') : 'now';
        $cacheKey = 'CONFIG_' . $clave . '_' . $fechaComponent;
        
        return Cache::remember($cacheKey, 60 * 24, function () use ($clave, $fecha) { // Cache por 24 horas
            return $this->getValor($clave, $fecha);
        });
    }
}