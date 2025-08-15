<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Asegúrate de importar DB
use Illuminate\Support\Facades\Validator;

use App\Models\Clientes;
use App\Models\Personas; // Importa el modelo Persona
use App\Models\TiposClientes; // Importa el modelo TipoCliente (asumiendo que es TiposClientes por el uso)
use App\Models\ClientesContactos; // Importa el modelo ClienteContacto
use App\Http\Requests\ClientesRequest;
use App\Services\ClientesService;

class ClientesController extends Controller
{
    protected ClientesService $clienteService;

    public function __construct(ClientesService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    /**
     * Muestra la lista de clientes.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'nombre', 'field' => 'nombre'],
                ['data' => 'tipo_cliente_id', 'field' => 'tipo_cliente_id'],
                ['data' => 'clase', 'field' => 'clase'],
                ['data' => 'rfc', 'field' => 'rfc'],
                ['data' => 'direccion', 'field' => 'direccion'],
                ['data' => 'codigo_postal', 'field' => 'codigo_postal'],
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

            $filters = [];
            // Asume que el ID del proveedor se envía como parámetro en la solicitud AJAX
            // (ej. /proveedorescontactos?proveedor_id=123)
            if ($request->has('cliente_id') && !empty($request->input('cliente_id'))) {
                $filters['cliente_id'] = $request->input('cliente_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->clienteService->getDataTable($columns, $actionsConfig, 'clientes', 'cliente_id', $filters);
        }

        return view('modules.Clientes.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo cliente.
     */
    public function store(ClientesRequest $request)
    {
        $validated = $request->validated();
        $currentUserID = Auth::guard('api')->user()->usuario_id ?? Auth::user()->usuario_id ?? 1;
        $validated['usuario_id'] = $currentUserID;

        try {
            $cliente = $this->clienteService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Cliente guardado exitosamente.',
                'cliente' => $cliente,
                'registro' => $cliente,
                'action' => 'clienteCreado',
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar cliente', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el cliente.',
            ], 500);
        }
    }

    /**
     * Muestra el cliente solicitado.
     */
    public function edit(Clientes $cliente)
    {
        return response()->json($cliente);
    }

    /**
     * Actualiza el cliente especificado.
     */
    public function update(ClientesRequest $request, Clientes $cliente)
    {
        $validated = $request->validated();

        try {
            $this->clienteService->update($cliente, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Clientes actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar cliente', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el cliente.',
            ], 500);
        }
    }

    /**
     * Elimina el cliente especificado.
     */
    public function destroy(Clientes $cliente)
    {
        try {
            $this->clienteService->delete($cliente);
            return response()->json([
                'success' => true,
                'message' => 'Clientes eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar cliente', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el cliente.',
            ], 500);
        }
    }

    public function storeProspecto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente_nombre' => 'required|string|max:255|unique:clientes,nombre',
            'cliente_telefono' => 'nullable|string|max:50',
            'contacto_nombre' => 'required|string|max:255',
            'contacto_apellidos' => 'required|string|max:255',
            'contacto_email' => 'nullable|email|max:255',
            'contacto_telefono' => 'nullable|string|max:50',
            'contacto_cargo' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $currentUserID = Auth::guard('api')->user()->usuario_id ?? Auth::user()->usuario_id ?? 1;
        // $validator->data('usuario_id', $currentUserID);

        DB::beginTransaction();
        try {
            // 1. Create Persona
            $persona = new Personas();
            $persona->nombres = $request->input('contacto_nombre'); // Adjust if you have separate first/last names
            $persona->apellidos = $request->input('contacto_apellidos'); // Adjust if you have separate first/last names
            $persona->correo_electronico = $request->input('contacto_email');
            $persona->telefono = $request->input('contacto_telefono'); // Map to your Persona's phone field
            $persona->direccion = $request->input('direccion', 'Información pendiente'); // Default or nullable
            $persona->identificador = $request->input('contacto_identificador', '0000000000'); // Default or nullable
            $persona->estado = 'A';
            // Set other required Persona fields with defaults if necessary
            // e.g., $persona->tipo_identificacion_id = config('app.default_tipo_identificacion_id');
            //       $persona->numero_identificacion = '0000000000';
            //       $persona->usuario_creacion_id = Auth::id();
            $persona->save();

            // 2. Create Cliente
            $cliente = new Clientes();
            $cliente->nombre = $request->input('cliente_nombre');
            $cliente->telefono = $request->input('cliente_telefono');
            $cliente->clase = 'PROSPECTO'; // Defaulting to PROSPECTO
            $cliente->estado = 'A';
            $cliente->usuario_id = $currentUserID;
            $defaultTipoCliente = 1; // Default tipo_cliente_id (e.g., for "Prospecto")
            $cliente->direccion = $request->input('direccion', 'Información pendiente'); // Or make it nullable
            $cliente->save();

            // 3. Create ClienteContacto (association)
            // This assumes you have a 'cliente_contactos' pivot table and a 'ClienteContacto' model.
            // Adjust if your structure is different (e.g., a direct foreign key on 'clientes' table).
            if (class_exists(ClientesContactos::class)) {
                $clienteContacto = new ClientesContactos();
                $clienteContacto->cliente_id = $cliente->cliente_id;
                $clienteContacto->persona_id = $persona->persona_id;
                $clienteContacto->cargo = $request->input('contacto_cargo', 'Información pendiente');
                $clienteContacto->correo_electronico = $request->input('contacto_email'); // Often duplicated for convenience
                $clienteContacto->telefono = $request->input('contacto_telefono');       // Often duplicated
                // $clienteContacto->es_principal = true; // Mark as primary contact
                $clienteContacto->estado = 'A';
                // $clienteContacto->usuario_creacion_id = Auth::id();
                $clienteContacto->save();
            } else {
                Log::warning('ClienteContacto model/logic not implemented for quick create. Contact not associated.');
                // If you have a simpler setup, like cliente.primary_persona_id:
                // $cliente->primary_persona_id = $persona->persona_id;
                // $cliente->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cliente/Prospecto y contacto creados exitosamente.',
                'client' => [
                    'id' => $cliente->cliente_id,
                    'name' => $cliente->nombre,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en storeQuick Client/Contact: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return response()->json(['success' => false, 'message' => 'Error interno del servidor al crear el cliente/prospecto.'], 500);
        }
    }
}