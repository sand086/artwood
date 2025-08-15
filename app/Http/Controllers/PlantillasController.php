<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Plantillas;
use App\Http\Requests\PlantillasRequest;
use App\Services\PlantillasService;
use App\Services\Plantillas\DocumentoGeneradorService;
use App\Services\Plantillas\PlantillasPrevisualizacionService;

class PlantillasController extends Controller
{
    protected PlantillasService $plantillaService;

    public function __construct(PlantillasService $plantillaService)
    {
        $this->plantillaService = $plantillaService;
    }

    /**
     * Muestra la lista de plantillas.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'nombre', 'field' => 'nombre'],
                ['data' => 'clave', 'field' => 'clave'],
                ['data' => 'tipo', 'field' => 'tipo'],
                ['data' => 'html', 'field' => 'html'],
                ['data' => 'estado', 'field' => 'estado'],
                ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
                ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],
            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
                'custom' => [
                                [
                                    'label' => '',
                                    'icon' => '/images/icons/crud/iconos_ojo_abierto.svg',
                                    'iconType'=> 'img',
                                    'iconSize'=> 'w-9',
                                    'iconWidth'=> '30',
                                    'class' => 'btn btn-primary btn-sm inline-flex items-center justify-center bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 p-1 rounded',
                                    'route' => 'plantillas.previsualizar',
                                    'routeParams' => ['plantilla' => 'plantilla_id'],
                                    'title' => 'Vista previa (Diseño)',
                                    'target' => '_blank',
                                ],
                                // [
                                //     'label' => 'Vista previa (Render)',
                                //     'icon' => 'fa fa-eye',
                                //     'route' => 'plantillas.previsualizarRender',
                                //     'routeParams' => ['plantilla' => 'plantilla_id'],
                                //     'target' => '_blank',
                                // ]
                            ]
            ];

            $filters = [];
            // Asume que el ID del proveedor se envía como parámetro en la solicitud AJAX
            // (ej. /proveedorescontactos?proveedor_id=123)
            if ($request->has('plantilla_id') && !empty($request->input('plantilla_id'))) {
                $filters['plantilla_id'] = $request->input('plantilla_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->plantillaService->getDataTable($columns, $actionsConfig, 'plantillas', 'plantilla_id', $filters);
        }

        return view('modules.Plantillas.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo plantilla.
     */
    public function store(PlantillasRequest $request)
    {
        $validated = $request->validated();

        try {
            $plantilla = $this->plantillaService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Plantilla guardado exitosamente.',
                'plantilla' => $plantilla,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar plantilla', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el plantilla.',
            ], 500);
        }
    }

    /**
     * Muestra el plantilla solicitado.
     */
    public function edit(Plantillas $plantilla)
    {
        return response()->json($plantilla);
    }

    /**
     * Actualiza el plantilla especificado.
     */
    public function update(PlantillasRequest $request, Plantillas $plantilla)
    {
        $validated = $request->validated();

        try {
            $this->plantillaService->update($plantilla, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Plantilla actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar plantilla', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el plantilla.',
            ], 500);
        }
    }

    /**
     * Elimina el plantilla especificado.
     */
    public function destroy(Plantillas $plantilla)
    {
        try {
            $this->plantillaService->delete($plantilla);
            return response()->json([
                'success' => true,
                'message' => 'Plantillas eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar plantilla', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el plantilla.',
            ], 500);
        }
    }

    /**
     * 
     */
    public function generar(int $idPlantilla, int $idRegistro, Request $request, DocumentoGeneradorService $docGen)
    {
        return $docGen->generarDocumento($idPlantilla, [
            'id' => $idRegistro,
            ...$request->except(['_token']) // por si llega más contexto útil
        ]);
    }

    public function previsualizar(string $plantilla_id, PlantillasPrevisualizacionService $plantillaVista)
    {
        $plantilla = Plantillas::where('plantilla_id', $plantilla_id)->firstOrFail();

        $contenidoRenderizado = $plantillaVista->render($plantilla->html);

        return view('modules.Plantillas.vista_previa', [
            'contenido_html' => $contenidoRenderizado
        ]);
    }

}