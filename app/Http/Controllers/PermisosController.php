<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Permisos; // Usa tu modelo personalizado
use App\Http\Requests\PermisosRequest;
use App\Services\PermisosService;

class PermisosController extends Controller
{
    protected PermisosService $PermisosService;

    public function __construct(PermisosService $PermisosService)
    {
        $this->PermisosService = $PermisosService;
    }

    /**
     * Muestra la lista de Permisos.
     */
    public function index(Request $request)
    {

        //var_dump($request->all());
        if ($request->ajax()) {
            $columns = [
                // Opcional: configuración extra para DataTable
            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
            ];

            return $this->PermisosService->getDataTable($columns, $actionsConfig, 'permisos', 'permission_id');
        }

        return view('modules.Permisos.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo rol.
     */
    public function store(PermisosRequest $request)
    {
        $validated = $request->validated();

        // Asigna "name" usando "nombre" si existe, o falla con un mensaje adecuado
        $validated['name'] = $validated['nombre'] ?? '';
        unset($validated['nombre']);

        try {
            $permiso = $this->PermisosService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'permiso guardado exitosamente.',
                'permiso' => $permiso,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar rol', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el rol.',
            ], 500);
        }
    }

    /**
     * Muestra el rol solicitado para editar.
     */
    public function edit(Permisos $permiso)
    {

        return response()->json($permiso);
    }

    /**
     * Actualiza el rol especificado.
     */
    public function update(PermisosRequest $request, Permisos $permiso)
    {
        $validated = $request->validated();
        Log::info('Validated data:', $validated); // Verifica en el log

        try {
            $this->PermisosService->update($permiso, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Rol actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar rol', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el rol.',
            ], 500);
        }
    }



    /**
     * Elimina el rol especificado.
     */
    public function destroy(Permisos $permiso)
    {
        try {
            $this->PermisosService->delete($permiso);
            return response()->json([
                'success' => true,
                'message' => 'Rol eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar rol', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el rol.',
            ], 500);
        }
    }
}
