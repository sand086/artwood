<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\ClientesContactos;
use App\Http\Requests\ClientesContactosRequest;
use App\Services\ClientesContactosService;

class ClientesContactosController extends Controller
{
    protected ClientesContactosService $clientesContactoService;

    public function __construct(ClientesContactosService $clientesContactoService)
    {
        $this->clientesContactoService = $clientesContactoService;
    }

    /**
     * Muestra la lista de clientesContactos.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'cliente_id', 'field' => 'cliente_id'],
                ['data' => 'persona_id', 'field' => 'persona_id'],
                ['data' => 'cargo', 'field' => 'cargo'],
                ['data' => 'telefono', 'field' => 'telefono'],
                ['data' => 'correo_electronico', 'field' => 'correo_electronico'],
                ['data' => 'observaciones', 'field' => 'observaciones'],
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
            if ($request->has('cliente_id') && !empty($request->input('cliente_id'))) {
                $filters['cliente_id'] = $request->input('cliente_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->clientesContactoService->getDataTable($columns, $actionsConfig, 'clientescontactos', 'cliente_contacto_id', $filters);
        }

        return view('modules.ClientesContactos.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo clientesContacto.
     */
    public function store(ClientesContactosRequest $request)
    {
        $validated = $request->validated();

        try {
            $clientesContacto = $this->clientesContactoService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Contacto guardado exitosamente.',
                'registro' => $clientesContacto,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar Contacto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el Contacto.',
            ], 500);
        }
    }

    /**
     * Muestra el clientesContacto solicitado.
     */
    public function edit(ClientesContactos $clientescontacto)
    {
        return response()->json($clientescontacto);
    }

    /**
     * Actualiza el clientesContacto especificado.
     */
    public function update(ClientesContactosRequest $request, ClientesContactos $clientescontacto)
    {
        $validated = $request->validated();

        try {
            $this->clientesContactoService->update($clientescontacto, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Contacto actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar Contacto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el Contacto.',
            ], 500);
        }
    }

    /**
     * Elimina el clientesContacto especificado.
     */
    public function destroy(ClientesContactos $clientescontacto)
    {
        try {
            $this->clientesContactoService->delete($clientescontacto);
            return response()->json([
                'success' => true,
                'message' => 'Contacto eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar Contacto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el Contacto.',
            ], 500);
        }
    }
}