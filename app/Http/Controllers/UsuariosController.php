<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use App\Http\Requests\UsuariosRequest;
use App\Services\UsuariosService;
use Illuminate\Support\Facades\Log;

class UsuariosController extends Controller
{
    protected UsuariosService $usuariosService;

    public function __construct(UsuariosService $usuariosService)
    {
        $this->usuariosService = $usuariosService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'nombre', 'field' => 'nombre'],
                ['data' => 'contrasena', 'field' => 'contrasena'],
                ['data' => 'fecha_ultimo_acceso', 'field' => 'fecha_ultimo_acceso'],
                ['data' => 'metodo_doble_factor', 'field' => 'metodo_doble_factor'],
                ['data' => 'doble_factor', 'field' => 'doble_factor'],
                ['data' => 'no_intentos', 'field' => 'no_intentos'],
                ['data' => 'role_id', 'field' => 'role_id'],
                ['data' => 'persona_id', 'field' => 'persona_id'],
                ['data' => 'IP', 'field' => 'IP'],
                ['data' => 'estado', 'field' => 'estado'],

            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
            ];

            return $this->usuariosService->getDataTable($columns, $actionsConfig, 'usuarios', 'usuario_id');
        }

        return view('modules.Usuarios.index', ['canAdd' => true]);
    }

    public function store(UsuariosRequest $request)
    {
        $validated = $request->validated();

        // Encriptar la contraseña y asignarla al campo "contrasena"
        $validated['contrasena'] = bcrypt($validated['password']);

        try {
            $usuario = $this->usuariosService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Usuario guardado exitosamente.',
                'usuario' => $usuario,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar usuario', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el usuario.',
            ], 500);
        }
    }


    public function edit(Usuarios $usuario)
    {
        // Carga la relación para poder obtener datos de la persona
        $usuario->load('persona');
        $data = $usuario->toArray();

        // Aplanar los datos de 'persona' en el objeto principal
        if (isset($data['persona'])) {
            $data['nombres']   = $data['persona']['nombres']   ?? null;
            $data['apellidos'] = $data['persona']['apellidos'] ?? null;
            $data['telefono']  = $data['persona']['telefono']  ?? null;
            $data['email']     = $data['persona']['email']     ?? null;
            $data['direccion'] = $data['persona']['direccion'] ?? null;
        }

        // Opcional: eliminar la clave 'persona' para evitar ambigüedad
        unset($data['persona']);

        return response()->json($data);
    }



    public function update(UsuariosRequest $request, Usuarios $usuarios)
    {
        $validated = $request->validated();

        try {
            $this->usuariosService->update($usuarios, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Usuarios actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar usuarios', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el usuarios.',
            ], 500);
        }
    }

    public function destroy(Usuarios $usuarios)
    {
        try {
            $this->usuariosService->delete($usuarios);
            return response()->json([
                'success' => true,
                'message' => 'Usuarios eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar usuarios', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el usuarios.',
            ], 500);
        }
    }
}
