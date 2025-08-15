<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Models\Proveedores;
use App\Http\Requests\ProveedoresRequest;
use App\Services\ProveedoresService;

class ProveedoresController extends Controller
{
    protected ProveedoresService $proveedorService;

    public function __construct(ProveedoresService $proveedorService)
    {
        $this->proveedorService = $proveedorService;
    }

    /**
     * Muestra la lista de proveedores.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'nombre', 'field' => 'nombre'],
                ['data' => 'tipo', 'field' => 'tipo'],
                ['data' => 'direccion', 'field' => 'direccion'],
                ['data' => 'colonia', 'field' => 'colonia'],
                ['data' => 'municipio_id', 'field' => 'municipio_id'],
                ['data' => 'estado_pais_id', 'field' => 'estado_pais_id'],
                ['data' => 'telefono', 'field' => 'telefono'],
                ['data' => 'sitio_web', 'field' => 'sitio_web'],
                ['data' => 'notas_adicionales', 'field' => 'notas_adicionales'],
                ['data' => 'usuario_id', 'field' => 'usuario_id'],
                ['data' => 'estado', 'field' => 'estado'],
                ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
                ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],
            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
            ];

            return $this->proveedorService->getDataTable($columns, $actionsConfig, 'proveedores', 'proveedor_id');
        }

        return view('modules.Proveedores.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo proveedor.
     */
    public function store(ProveedoresRequest $request)
    {
        $validated = $request->validated();
        $currentUserID = Auth::guard('api')->user()->usuario_id ?? Auth::user()->usuario_id ?? 1;
        $validated['usuario_id'] = $currentUserID;

        try {
            $proveedor = $this->proveedorService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Proveedores guardado exitosamente.',
                'proveedor' => $proveedor,
                'registro' => $proveedor,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar proveedor', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el proveedor.',
            ], 500);
        }
    }

    /**
     * Muestra el proveedor solicitado.
     */
    public function edit(Proveedores $proveedor)
    {
        return response()->json($proveedor);
    }

    /**
     * Actualiza el proveedor especificado.
     */
    public function update(ProveedoresRequest $request, Proveedores $proveedor)
    {
        $validated = $request->validated();

        try {
            $this->proveedorService->update($proveedor, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Proveedores actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar proveedor', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el proveedor.',
            ], 500);
        }
    }

    /**
     * Elimina el proveedor especificado.
     */
    public function destroy(Proveedores $proveedor)
    {
        try {
            $this->proveedorService->delete($proveedor);
            return response()->json([
                'success' => true,
                'message' => 'Proveedores eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar proveedor', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el proveedor.',
            ], 500);
        }
    }

    /**
     * Muestra una vista parcial con los detalles de un proveedor.
     * Esta vista está diseñada para ser cargada en un modal o popup.
     *
     * @param  \App\Models\Proveedores $proveedor
     * @return \Illuminate\View\View
     */
    public function showDetailsView(Proveedores $proveedor)
    {
        // Carga las relaciones que quieras mostrar, como los contactos.
        $proveedor->load('contactos.persona');

        // Retorna una vista parcial con los datos.
        return view('modules.Proveedores.details-view', compact('proveedor'));
    }
}