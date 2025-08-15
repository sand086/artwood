<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\ProveedoresProductos;
use App\Http\Requests\ProveedoresProductosRequest;
use App\Services\ProveedoresProductosService;

class ProveedoresProductosController extends Controller
{
    protected ProveedoresProductosService $proveedoresProductoService;

    public function __construct(ProveedoresProductosService $proveedoresProductoService)
    {
        $this->proveedoresProductoService = $proveedoresProductoService;
    }

    /**
     * Muestra la lista de proveedoresProductos.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'proveedor_id', 'field' => 'proveedor_id'],
                ['data' => 'producto_id', 'field' => 'producto_id'],
                ['data' => 'descripcion', 'field' => 'descripcion'],
                ['data'=> 'unidad_medida_id', 'field'=> 'unidad_medida_id'],
                ['data'=> 'precio_unitario', 'field'=> 'precio_unitario'],
                ['data' => 'detalle', 'field' => 'detalle'],
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
            if ($request->has('proveedor_id') && !empty($request->input('proveedor_id'))) {
                $filters['proveedor_id'] = $request->input('proveedor_id');
            } else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                 Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                 // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            }

            return $this->proveedoresProductoService->getDataTable($columns, $actionsConfig, 'proveedoresproductos', 'proveedor_producto_id', $filters);
        }

        return view('modules.ProveedoresProductos.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo proveedoresProducto.
     */
    public function store(ProveedoresProductosRequest $request)
    {
        $validated = $request->validated();

        try {
            $proveedoresProducto = $this->proveedoresProductoService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Producto del Proveedor guardado exitosamente.',
                'proveedoresProducto' => $proveedoresProducto,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar el Producto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el Producto.',
            ], 500);
        }
    }

    /**
     * Muestra el proveedoresProducto solicitado.
     */
    public function edit(ProveedoresProductos $proveedoresproducto)
    {
        return response()->json($proveedoresproducto);
    }

    /**
     * Actualiza el proveedoresProducto especificado.
     */
    public function update(ProveedoresProductosRequest $request, ProveedoresProductos $proveedoresproducto)
    {
        $validated = $request->validated();

        try {
            $this->proveedoresProductoService->update($proveedoresproducto, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Producto del Proveedor actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar el Producto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el Producto.',
            ], 500);
        }
    }

    /**
     * Elimina el proveedoresProducto especificado.
     */
    public function destroy(ProveedoresProductos $proveedoresproducto)
    {
        try {
            $this->proveedoresProductoService->delete($proveedoresproducto);
            return response()->json([
                'success' => true,
                'message' => 'Producto del Proveedor eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar el Producto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el Producto.',
            ], 500);
        }
    }
}