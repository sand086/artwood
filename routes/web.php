<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\PersonasController;
use App\Http\Controllers\TiposSolicitudesController;
use App\Http\Controllers\TiposGastosController;
use App\Http\Controllers\EstadosGeneralesController;
use App\Http\Controllers\UnidadesMedidasController;
use App\Http\Controllers\PlazosCreditosController;
use App\Http\Controllers\PaisesController;
use App\Http\Controllers\EstadosPaisesController;
use App\Http\Controllers\MunicipiosController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ServiciosController;
// importar middelware CheckJwtToken
use App\Http\Middleware\CheckJwtToken;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\ProveedoresContactosController;
use App\Http\Controllers\ProveedoresProductosController;
use App\Http\Controllers\ProveedoresServiciosController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ClientesContactosController;
use App\Http\Controllers\TiposClientesController;
use App\Http\Controllers\PasosCotizacionesController;
use App\Http\Controllers\GastosController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\ProcesosController;
use App\Http\Controllers\ProcesosActividadesController;
use App\Http\Controllers\CotizacionesSolicitudesController;
use App\Http\Controllers\FuentesController;
use App\Http\Controllers\CotizacionesResponsablesController;
use App\Http\Controllers\TiposIdentificacionesController;
use App\Http\Controllers\CotizacionesAnalisisController;
use App\Http\Controllers\TiposProyectosController;
use App\Http\Controllers\MaterialesController;
use App\Http\Controllers\EquiposController;
use App\Http\Controllers\ProveedoresMaterialesController;
use App\Http\Controllers\ProveedoresEquiposController;
use App\Http\Controllers\CotizacionesDocumentosController;
use App\Http\Controllers\TiposRecursosController;
use App\Http\Controllers\CotizacionesRecursosController;
use App\Http\Controllers\ConfiguracionesController;
use App\Http\Controllers\PlantillasController;
use App\Http\Controllers\CotizacionesController;
use App\Http\Controllers\DashboardController;



// Rutas publicas
Route::view('/login', 'modules.Autenticacion.login')->name('login');
Route::get('/', function () {
    if (auth()->check()) {
        return view('home'); // Reemplaza 'home' con tu vista de usuario logueado
    } else {
        return redirect('/home'); // Reemplaza 'home' con tu vista de inicio de sesión
    }
})->name('root');

Route::view('/registro-2fa', 'modules.Autenticacion.registro2AF')->name('registro2AF');
Route::view('/recovery-contrasena', 'modules.Autenticacion.recoveryContrasena')->name('recoveryContrasena');
Route::view('/correo-enviado-recovery', 'modules.Autenticacion.correoEnviado')->name('correoEnviadoRecoveryContrasena');
Route::view('/ingreso-temporal', 'modules.Autenticacion.ingresarConContrasenaTemporal')->name('ingresoTemporal');
Route::view('/home', 'modules.Home.index')->name('home');

// Rutas autenticacion
Route::resource('roles', RolesController::class);
Route::resource('permisos', PermisosController::class);
Route::resource('usuarios', UsuariosController::class);


Route::view('/ajustes', 'modules.Usuarios.ajustes')->name('ajustes');
Route::view('/perfil', 'modules.Usuarios.perfil')->name('perfil');

// Rutas personalizadas

// Rutas protegidas
Route::resource('personas', PersonasController::class);
Route::resource('tipossolicitudes', TiposSolicitudesController::class);
Route::resource('tiposgastos', TiposGastosController::class);
Route::resource('estadosgenerales', EstadosGeneralesController::class);
Route::resource('unidadesmedidas', UnidadesMedidasController::class);
Route::resource('plazoscreditos', PlazosCreditosController::class);
Route::resource('paises', PaisesController::class);
Route::resource('estadospaises', EstadosPaisesController::class);
Route::resource('municipios', MunicipiosController::class);
Route::resource('empleados', EmpleadosController::class);
Route::resource('productos', ProductosController::class);
Route::resource('servicios', ServiciosController::class);
Route::resource('proveedores', ProveedoresController::class)->parameters(['proveedores' => 'proveedor']);
Route::resource('proveedorescontactos', ProveedoresContactosController::class);
Route::resource('proveedoresproductos', ProveedoresProductosController::class);
Route::resource('proveedoresservicios', ProveedoresServiciosController::class);
Route::resource('clientes', ClientesController::class);
Route::resource('clientescontactos', ClientesContactosController::class);
Route::resource('tiposclientes', TiposClientesController::class);
Route::resource('pasoscotizaciones', PasosCotizacionesController::class);
Route::resource('gastos', GastosController::class);
Route::resource('areas', AreasController::class);
Route::resource('procesos', ProcesosController::class);
Route::resource('procesosactividades', ProcesosActividadesController::class);
Route::resource('cotizacionessolicitudes', CotizacionesSolicitudesController::class);
Route::resource('fuentes', FuentesController::class);
Route::resource('cotizacionesresponsables', CotizacionesResponsablesController::class);
Route::resource('tiposidentificaciones', TiposIdentificacionesController::class);
Route::resource('cotizacionesanalisis', CotizacionesAnalisisController::class);
Route::resource('tiposproyectos', TiposProyectosController::class);
Route::resource('materiales', MaterialesController::class);
Route::resource('equipos', EquiposController::class);
Route::resource('proveedoresmateriales', ProveedoresMaterialesController::class);
Route::resource('proveedoresequipos', ProveedoresEquiposController::class);
Route::resource('cotizacionesdocumentos', CotizacionesDocumentosController::class);
Route::resource('tiposrecursos', TiposRecursosController::class);
Route::resource('cotizacionesrecursos', CotizacionesRecursosController::class);
Route::resource('configuraciones', ConfiguracionesController::class);
Route::resource('plantillas', PlantillasController::class);

// ... other routes
Route::post('/create-prospecto', [ClientesController::class, 'storeProspecto'])->name('quick.client.contact.store');
Route::get('/debug-db', function () {
    return response()->json(config('database.connections.mysql'));
});
Route::get('/proveedores/{proveedor}/details', [ProveedoresController::class, 'showDetailsView'])->name('proveedores.details');
Route::get('/cotizacionesdocumentos/stream/{cotizacionesdocumento}', [CotizacionesDocumentosController::class, 'streamDocument'])->name('cotizacionesdocumentos.stream');

Route::get('/documentos/{plantilla}/generar/{registro}', [PlantillasController::class, 'generar'])
    ->name('documentos.generar');

Route::get('/plantillas/{plantilla}/previsualizar', [PlantillasController::class, 'previsualizar'])
    ->name('plantillas.previsualizar');
Route::resource('cotizaciones', CotizacionesController::class);


Route::view('/dashboard/cotizaciones', 'Home.dashboard.administracion')->name('dashboard.administracion');
Route::view('/dashboard/proyectos', 'Home.dashboard.proyectos')->name('dashboard.proyectos');
Route::view('/dashboard/configuraciones', 'Home.dashboard.cotizaciones')->name('dashboard.cotizaciones');
