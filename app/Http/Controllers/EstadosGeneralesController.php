<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\EstadosGenerales;
use App\Http\Requests\EstadosGeneralesRequest;
use App\Services\EstadosGeneralesService;

class EstadosGeneralesController extends Controller
{
    protected EstadosGeneralesService $estadosGeneraleService;

    public function __construct(EstadosGeneralesService $estadosGeneraleService)
    {
        $this->estadosGeneraleService = $estadosGeneraleService;
    }

    /**
     * Muestra la lista de estadosGenerales.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'nombre', 'field' => 'nombre'],
                ['data' => 'categoria', 'field' => 'categoria'],
                ['data' => 'estado', 'field' => 'estado'],
                ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
                ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],

            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
            ];

            return $this->estadosGeneraleService->getDataTable($columns, $actionsConfig, 'estadosgenerales', 'estado_general_id');
        }

        return view('modules.EstadosGenerales.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo estadosGenerale.
     */
    public function store(EstadosGeneralesRequest $request)
    {
        $validated = $request->validated();

        try {
            $estadosGenerale = $this->estadosGeneraleService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'EstadosGenerales guardado exitosamente.',
                'estadosGenerale' => $estadosGenerale,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar el Estado General', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el Estado General.',
            ], 500);
        }
    }

    /**
     * Muestra el estadosGenerale solicitado.
     */
    public function edit(EstadosGenerales $estadosgenerale)
    {
        return response()->json($estadosgenerale);
    }

    /**
     * Actualiza el estadosGenerale especificado.
     */
    public function update(EstadosGeneralesRequest $request, EstadosGenerales $estadosgenerale)
    {
        $validated = $request->validated();

        try {
            $this->estadosGeneraleService->update($estadosgenerale, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Estado General actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar Estado General', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estados General.',
            ], 500);
        }
    }

    /**
     * Elimina el estadosGenerale especificado.
     */
    public function destroy(EstadosGenerales $estadosgenerale)
    {
        try {
            $this->estadosGeneraleService->delete($estadosgenerale);
            return response()->json([
                'success' => true,
                'message' => 'Estado General eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar estado General', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el estado General.',
            ], 500);
        }
    }

    /**
     * Obtiene los estados generales por categoría.
     */
    public function obtenerEstadosGeneralesPorCategoria(Request $request, $categoria)
    {
        // Asumiendo que tienes una tabla 'estadosgenerales'
        // y columnas 'id', 'nombre', 'categoria'
        // Ajusta los nombres de tabla y columnas según tu esquema
        $estados = DB::table('estadosgenerales')
                        ->where('categoria', $categoria)
                        ->select('id_estado_general as id', 'nombre_estado as nombre') // Ajusta los alias según necesites
                        ->orderBy('nombre_estado', 'asc')
                        ->get();

        if ($request->expectsJson()) {
            return response()->json(['data' => $estados]);
        }

        // Podrías tener otra lógica si no se espera JSON
        return $estados;
    }
}