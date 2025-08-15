<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\TiposClientes;
use App\Http\Requests\TiposClientesRequest;
use App\Services\TiposClientesService;

class TiposClientesController extends Controller
{
    protected TiposClientesService $tiposClienteService;

    public function __construct(TiposClientesService $tiposClienteService)
    {
        $this->tiposClienteService = $tiposClienteService;
    }

    /**
     * Muestra la lista de tiposClientes.
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
            if ($request->has('tipo_cliente_id') && !empty($request->input('tipo_cliente_id'))) {
                $filters['tipo_cliente_id'] = $request->input('tipo_cliente_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->tiposClienteService->getDataTable($columns, $actionsConfig, 'tiposclientes', 'tipo_cliente_id', $filters);
        }

        return view('modules.TiposClientes.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo tiposCliente.
     */
    public function store(TiposClientesRequest $request)
    {
        $validated = $request->validated();

        try {
            $tiposCliente = $this->tiposClienteService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'TiposClientes guardado exitosamente.',
                'tiposCliente' => $tiposCliente,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar tiposCliente', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el tiposCliente.',
            ], 500);
        }
    }

    /**
     * Muestra el tiposCliente solicitado.
     */
    public function edit(TiposClientes $tiposcliente)
    {
        return response()->json($tiposcliente);
    }

    /**
     * Actualiza el tiposCliente especificado.
     */
    public function update(TiposClientesRequest $request, TiposClientes $tiposcliente)
    {
        $validated = $request->validated();

        try {
            $this->tiposClienteService->update($tiposcliente, $validated);
            return response()->json([
                'success' => true,
                'message' => 'TiposClientes actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar tiposCliente', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el tiposCliente.',
            ], 500);
        }
    }

    /**
     * Elimina el tiposCliente especificado.
     */
    public function destroy(TiposClientes $tiposcliente)
    {
        try {
            $this->tiposClienteService->delete($tiposcliente);
            return response()->json([
                'success' => true,
                'message' => 'TiposClientes eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar tiposCliente', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el tiposCliente.',
            ], 500);
        }
    }
}