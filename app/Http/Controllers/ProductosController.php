<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Productos;
use App\Http\Requests\ProductosRequest;
use App\Services\ProductosService;

class ProductosController extends Controller
{
    protected ProductosService $productoService;

    public function __construct(ProductosService $productoService)
    {
        $this->productoService = $productoService;
    }

    /**
     * Muestra la lista de productos.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                            ['data' => 'nombre', 'field' => 'nombre'],
            ['data' => 'descripcion', 'field' => 'descripcion'],
            ['data' => 'unidad_medida_id', 'field' => 'unidad_medida_id'],
            ['data' => 'precio_unitario', 'field' => 'precio_unitario'],
            ['data' => 'estado', 'field' => 'estado'],
            ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
            ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],

            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
            ];

            return $this->productoService->getDataTable($columns, $actionsConfig, 'productos', 'producto_id');
        }

        return view('modules.Productos.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo producto.
     */
    public function store(ProductosRequest $request)
    {
        $validated = $request->validated();

        try {
            $producto = $this->productoService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Productos guardado exitosamente.',
                'producto' => $producto,
                'registro' => $producto,
                'action' => 'productoCreado',
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar producto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el producto.',
            ], 500);
        }
    }

    /**
     * Muestra el producto solicitado.
     */
    public function edit(Productos $producto)
    {
        return response()->json($producto);
    }

    /**
     * Actualiza el producto especificado.
     */
    public function update(ProductosRequest $request, Productos $producto)
    {
        $validated = $request->validated();

        try {
            $this->productoService->update($producto, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Productos actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar producto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el producto.',
            ], 500);
        }
    }

    /**
     * Elimina el producto especificado.
     */
    public function destroy(Productos $producto)
    {
        try {
            $this->productoService->delete($producto);
            return response()->json([
                'success' => true,
                'message' => 'Productos eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar producto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el producto.',
            ], 500);
        }
    }
}