<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Empleados;
use App\Http\Requests\EmpleadosRequest;
use App\Services\EmpleadosService;

class EmpleadosController extends Controller
{
    protected EmpleadosService $empleadoService;

    public function __construct(EmpleadosService $empleadoService)
    {
        $this->empleadoService = $empleadoService;
    }

    /**
     * Muestra la lista de empleados.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                            ['data' => 'persona_id', 'field' => 'persona_id'],
            ['data' => 'cargo', 'field' => 'cargo'],
            ['data' => 'usuario_id', 'field' => 'usuario_id'],
            ['data' => 'estado', 'field' => 'estado'],
            ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
            ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],

            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
            ];

            return $this->empleadoService->getDataTable($columns, $actionsConfig, 'empleados', 'empleado_id');
        }

        return view('modules.Empleados.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo empleado.
     */
    public function store(EmpleadosRequest $request)
    {
        $validated = $request->validated();

        try {
            $empleado = $this->empleadoService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Empleados guardado exitosamente.',
                'empleado' => $empleado,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar empleado', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el empleado.',
            ], 500);
        }
    }

    /**
     * Muestra el empleado solicitado.
     */
    public function edit(Empleados $empleado)
    {
        return response()->json($empleado);
    }

    /**
     * Actualiza el empleado especificado.
     */
    public function update(EmpleadosRequest $request, Empleados $empleado)
    {
        $validated = $request->validated();

        try {
            $this->empleadoService->update($empleado, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Empleados actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar empleado', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el empleado.',
            ], 500);
        }
    }

    /**
     * Elimina el empleado especificado.
     */
    public function destroy(Empleados $empleado)
    {
        try {
            $this->empleadoService->delete($empleado);
            return response()->json([
                'success' => true,
                'message' => 'Empleados eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar empleado', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el empleado.',
            ], 500);
        }
    }
}