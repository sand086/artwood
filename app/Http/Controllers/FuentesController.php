<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Fuentes;
use App\Http\Requests\FuentesRequest;
use App\Services\FuentesService;

class FuentesController extends Controller
{
    protected FuentesService $fuenteService;

    public function __construct(FuentesService $fuenteService)
    {
        $this->fuenteService = $fuenteService;
    }

    /**
     * Muestra la lista de fuentes.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                            ['data' => 'nombre', 'field' => 'nombre'],
            ['data' => 'descripcion', 'field' => 'descripcion'],
            ['data' => 'estado', 'field' => 'estado'],
            ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
            ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],

            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
            ];

            $filters = [];
            // Asume que el ID del proveedor se envía como parámetro en la solicitud AJAX
            // (ej. /proveedorescontactos?proveedor_id=123)
            if ($request->has('fuente_id') && !empty($request->input('fuente_id'))) {
                $filters['fuente_id'] = $request->input('fuente_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->fuenteService->getDataTable($columns, $actionsConfig, 'fuentes', 'fuente_id', $filters);
        }

        return view('modules.Fuentes.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo fuente.
     */
    public function store(FuentesRequest $request)
    {
        $validated = $request->validated();

        try {
            $fuente = $this->fuenteService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Fuentes guardado exitosamente.',
                'fuente' => $fuente,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar fuente', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el fuente.',
            ], 500);
        }
    }

    /**
     * Muestra el fuente solicitado.
     */
    public function edit(Fuentes $fuente)
    {
        return response()->json($fuente);
    }

    /**
     * Actualiza el fuente especificado.
     */
    public function update(FuentesRequest $request, Fuentes $fuente)
    {
        $validated = $request->validated();

        try {
            $this->fuenteService->update($fuente, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Fuentes actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar fuente', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el fuente.',
            ], 500);
        }
    }

    /**
     * Elimina el fuente especificado.
     */
    public function destroy(Fuentes $fuente)
    {
        try {
            $this->fuenteService->delete($fuente);
            return response()->json([
                'success' => true,
                'message' => 'Fuentes eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar fuente', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el fuente.',
            ], 500);
        }
    }
}