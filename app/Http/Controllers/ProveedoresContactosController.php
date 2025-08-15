<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\ProveedoresContactos;
use App\Http\Requests\ProveedoresContactosRequest;
use App\Services\ProveedoresContactosService;

class ProveedoresContactosController extends Controller
{
    protected ProveedoresContactosService $proveedoresContactoService;

    public function __construct(ProveedoresContactosService $proveedoresContactoService)
    {
        $this->proveedoresContactoService = $proveedoresContactoService;
    }

    /**
     * Muestra la lista de proveedoresContactos.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'proveedor_id', 'field' => 'proveedor_id'],
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
                'editEvent' => 'mostrarFormContacto = false;',
            ];

            $filters = [];
            // Asume que el ID del proveedor se envía como parámetro en la solicitud AJAX
            // (ej. /proveedorescontactos?proveedor_id=123)
            if ($request->has('proveedor_id') && !empty($request->input('proveedor_id'))) {
                $filters['proveedor_id'] = $request->input('proveedor_id');
            } else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                 Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                 // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            }

            return $this->proveedoresContactoService->getDataTable($columns, $actionsConfig, 'proveedorescontactos', 'proveedor_contacto_id', $filters);
        }

        // return view('modules.ProveedoresContactos.index', ['canAdd' => true]);
        return response()->json(['error' => 'Acceso no permitido'], 403);
    }

    /**
     * Almacena un nuevo proveedoresContacto.
     */
    public function store(ProveedoresContactosRequest $request)
    {
        $validated = $request->validated();
        // Si no se proporciona proveedor_id, pero hay parent_id, asignamos parent_id a proveedor_id
        if (!isset($validated['proveedor_id']) && $request->has('parent_id')) {
            $validated['proveedor_id'] = $request->input('parent_id');
        }

        try {
            $proveedoresContacto = $this->proveedoresContactoService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Contacto guardado exitosamente.',
                'proveedoresContacto' => $proveedoresContacto,
                'registro' => $proveedoresContacto,
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
     * Muestra el proveedoresContacto solicitado.
     */
    public function edit(ProveedoresContactos $proveedorescontacto)
    {
        // $proveedorescontacto->load('persona', 'proveedor');
        return response()->json($proveedorescontacto);
    }

    /**
     * Actualiza el proveedoresContacto especificado.
     */
    public function update(ProveedoresContactosRequest $request, ProveedoresContactos $proveedorescontacto)
    {
        $validated = $request->validated();

        try {
            $this->proveedoresContactoService->update($proveedorescontacto, $validated);
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
     * Elimina el proveedoresContacto especificado.
     */
    public function destroy(ProveedoresContactos $proveedorescontacto)
    {
        try {
            $this->proveedoresContactoService->delete($proveedorescontacto);
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