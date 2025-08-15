<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Roles; // Usa tu modelo personalizado
use App\Http\Requests\RolesRequest;
use App\Services\RolesService;

class RolesController extends Controller
{
    protected RolesService $rolesService;

    public function __construct(RolesService $rolesService)
    {
        $this->rolesService = $rolesService;
    }

    /**
     * Muestra la lista de roles.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                // Opcional: configuración extra para DataTable
            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
            ];

            return $this->rolesService->getDataTable($columns, $actionsConfig, 'roles', 'role_id');
        }

        return view('modules.Roles.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo rol.
     */
    public function store(RolesRequest $request)
    {
        $validated = $request->validated();

        // Asigna "name" usando "nombre" si existe, o falla con un mensaje adecuado
        $validated['name'] = $validated['nombre'] ?? '';
        unset($validated['nombre']);

        try {
            $role = $this->rolesService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Rol guardado exitosamente.',
                'role' => $role,
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
    public function edit(Roles $role)
    {
        // Agregar propiedad 'nombre' para que el formulario la reciba
        $role->nombre = $role->name;
        return response()->json($role);
    }

    /**
     * Actualiza el rol especificado.
     */
    public function update(RolesRequest $request, Roles $role)
    {
        $validated = $request->validated();
        Log::info('Validated data:', $validated); // Verifica en el log

        try {
            $this->rolesService->update($role, $validated);
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
    public function destroy(Roles $role)
    {
        try {
            $this->rolesService->delete($role);
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
