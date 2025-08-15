<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Models\Personas;
use App\Http\Requests\PersonasRequest;
use App\Services\PersonasService;

class PersonasController extends Controller
{
    protected PersonasService $personaService;

    public function __construct(PersonasService $personaService)
    {
        $this->personaService = $personaService;
    }

    /**
     * Muestra la lista de personas.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'nombres', 'field' => 'nombres'],
                ['data' => 'apellidos', 'field' => 'apellidos'],
                ['data' => 'direccion', 'field' => 'direccion'],
                ['data' => 'telefono', 'field' => 'telefono'],
                ['data' => 'email', 'field' => 'email'],
                ['data' => 'tipo_identificacion_id', 'field' => 'tipo_identificacion_id'],
                ['data' => 'identificador', 'field' => 'identificador'],
                ['data' => 'estado_pais_id', 'field' => 'estado_pais_id'],
                ['data' => 'municipio_id', 'field' => 'municipio_id'],
                ['data' => 'estado', 'field' => 'estado'],
                ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
                ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],
            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
            ];

            return $this->personaService->getDataTable($columns, $actionsConfig, 'personas', 'persona_id');
        }

        return view('modules.Personas.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo persona.
     */
    public function store(PersonasRequest $request)
    {
        $validated = $request->validated();

        try {
            $persona = $this->personaService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Personas guardado exitosamente.',
                'persona' => $persona,
                'registro' => $persona,
                'action' => 'personaCreada',
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar persona', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el persona.',
            ], 500);
        }
    }

    /**
     * Muestra el persona solicitado.
     */
    public function edit(Personas $persona)
    {
        return response()->json($persona);
    }

    /**
     * Actualiza el persona especificado.
     */
    public function update(PersonasRequest $request, Personas $persona)
    {
        $validated = $request->validated();

        try {
            $this->personaService->update($persona, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Personas actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar persona', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el persona.',
            ], 500);
        }
    }

    /**
     * Elimina el persona especificado.
     */
    public function destroy(Personas $persona)
    {
        try {
            $this->personaService->delete($persona);
            return response()->json([
                'success' => true,
                'message' => 'Personas eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar persona', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el persona.',
            ], 500);
        }
    }

    public function create(Request $request)
    {
        $openModal = $request->query('openModal', false); // Obtiene el valor del parámetro openModal
        return view('modules.Personas.index', compact('openModal')); // Pasa la variable openModal a la vista
    }
    
}