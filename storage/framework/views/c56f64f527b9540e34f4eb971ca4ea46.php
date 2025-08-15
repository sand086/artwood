<!-- SIDEBAR -->
<aside x-data="combinedAccess()"
    class="bg-white border-r border-gray-200 flex flex-col transition-all duration-300 h-screen overflow-y-auto"
    :class="sidebarOpen ? 'w-64' : 'w-16'">

    <!-- Logo + Toggle -->
    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200">
        <img src="<?php echo e(asset('images/icons/artwood-logo.svg')); ?>" alt="Logo" width="110" x-show="sidebarOpen" />
        <button @click="sidebarOpen = !sidebarOpen" class="p-1 text-gray-600 hover:text-gray-900 focus:outline-none">
            <i data-lucide="X" x-show="sidebarOpen" class="w-6 h-6"></i>
            <i data-lucide="menu" x-show="!sidebarOpen" class="w-6 h-6"></i>
        </button>
    </div>

    <!-- Menú Lateral -->
    <nav class="flex-1 mt-2">
        <ul class="space-y-1 px-2">

            <!-- Grupo Dashboards -->
            <li x-data="{ open: window.location.pathname.startsWith('/dashboard') }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                    :class="{ 'sidebar-active': open }">
                    <div class="flex items-center gap-3">
                        <img src="<?php echo e(asset('images/icons/sidebar/iconos_dashboard.svg')); ?>" alt="Dashboards" width="25"
                            class="flex-shrink-0" />
                        <span x-show="sidebarOpen" x-transition.opacity>Dashboards</span>
                    </div>
                    <img src="<?php echo e(asset('images/icons/sidebar/iconos_chevron-down.svg')); ?>" alt="Toggle" width="16"
                        :class="{ 'transform rotate-180': open }" />
                </button>
                <ul x-show="open" x-transition class="ml-4 mt-1 space-y-1">

                    <!-- Cotizaciones -->
                    <li>
                        <a href="<?php echo e(route('dashboard.cotizaciones')); ?>"
                            class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                            :class="{ 'sidebar-active': window.location.pathname === '/dashboard/cotizaciones' }">
                            <img src="<?php echo e(asset('images/icons/sidebar/iconos_cotizacion.svg')); ?>" alt="Cotizaciones"
                                width="25" class="flex-shrink-0" />
                            <span x-show="sidebarOpen" x-transition.opacity>Cotizaciones</span>
                        </a>
                    </li>

                    <!-- Proyectos -->
                    <li>
                        <a href="<?php echo e(route('dashboard.proyectos')); ?>"
                            class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                            :class="{ 'sidebar-active': window.location.pathname === '/dashboard/proyectos' }">
                            <img src="<?php echo e(asset('images/icons/sidebar/iconos_proyectos.svg')); ?>" alt="Proyectos"
                                width="25" class="flex-shrink-0" />
                            <span x-show="sidebarOpen" x-transition.opacity>Proyectos</span>
                        </a>
                    </li>

                    <!-- Configuración -->
                    <li>
                        <a href="<?php echo e(route('dashboard.administracion')); ?>"
                            class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                            :class="{ 'sidebar-active': window.location.pathname === '/dashboard/administracion' }">
                            <img src="<?php echo e(asset('images/icons/sidebar/iconos_configuraciones.svg')); ?>"
                                alt="Configuración" width="25" class="flex-shrink-0" />
                            <span x-show="sidebarOpen" x-transition.opacity>Configuración</span>
                        </a>
                    </li>

                </ul>
            </li>

            <!-- Configuración (Master/Admin) -->
            <template x-if="hasAnyRole('Master','Administrador')">
                <li x-data="{ open:
                        window.location.pathname.startsWith('/areas') ||
                        window.location.pathname.startsWith('/estadosgenerales') ||
                        window.location.pathname.startsWith('/fuentes') ||
                        window.location.pathname.startsWith('/personas') ||
                        window.location.pathname.startsWith('/plazoscreditos') ||
                        window.location.pathname.startsWith('/procesos') ||
                        window.location.pathname.startsWith('/tiposclientes') ||
                        window.location.pathname.startsWith('/tiposgastos') ||
                        window.location.pathname.startsWith('/tiposidentificaciones') ||
                        window.location.pathname.startsWith('/tiposrecursos') ||
                        window.location.pathname.startsWith('/unidadesmedidas') ||
                        window.location.pathname.startsWith('/paises') ||
                        window.location.pathname.startsWith('/estadospaises') ||
                        window.location.pathname.startsWith('/municipios')
                    }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                        :class="{ 'sidebar-active': open }">
                        <div class="flex items-center gap-3">
                            <i data-lucide="settings" class="w-6 h-6 text-gray-600"></i>
                            <span x-show="sidebarOpen" x-transition.opacity>Configuración</span>
                        </div>
                        <i data-lucide="chevron-down" :class="{ 'rotate-180 transition-transform': open }"
                            class="w-4 h-4 text-gray-600"></i>
                    </button>
                    <ul x-show="open" x-transition class="ml-4 mt-1 space-y-1">

                        <li>
                            <a href="<?php echo e(route('areas.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/areas') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_areas.svg')); ?>" alt="Áreas" width="25"
                                    class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Áreas</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('configuraciones.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/configuraciones') }">
                                <i data-lucide="settings" class="w-6 h-6 text-gray-600"></i>
                                <span x-show="sidebarOpen" x-transition:opacity>Configuraciones</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('estadosgenerales.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/estadosgenerales') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_categorias.svg')); ?>"
                                    alt="Estados Generales" width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Estados Generales</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('fuentes.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/fuentes') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_fuentes.svg')); ?>" alt="Fuentes"
                                    width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Fuentes</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('personas.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/personas') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_personas.svg')); ?>" alt="Personas"
                                    width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Personas</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('plantillas.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/plantillas') }">
                                <i data-lucide="square-minus" class="w-6 h-6 flex-shrink-0 text-gray-600"></i>
                                <span x-show="sidebarOpen" x-transition:opacity>Plantillas</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('plazoscreditos.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/plazoscreditos') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_plazosdecreditos.svg')); ?>"
                                    alt="Plazos Créditos" width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Plazos Créditos</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('procesos.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/procesos') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_procesos.svg')); ?>" alt="Procesos"
                                    width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Procesos</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('tiposclientes.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/tiposclientes') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_tipodeclientes.svg')); ?>"
                                    alt="Tipos Clientes" width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Tipos Clientes</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('tiposgastos.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/tiposgastos') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_tiposdegastos.svg')); ?>"
                                    alt="Tipos Gastos" width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Tipos Gastos</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('tiposidentificaciones.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/tiposidentificaciones') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_identificaciones.svg')); ?>"
                                    alt="Tipos Identificaciones" width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Tipos Identificaciones</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('tiposrecursos.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/tiposrecursos') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_tiposrecursos.svg')); ?>"
                                    alt="Tipos Recursos" width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Tipos Recursos</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('unidadesmedidas.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/unidadesmedidas') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_unidaddemedida.svg')); ?>"
                                    alt="Unidades Medida" width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Unidades Medida</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('paises.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/paises') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_paises.svg')); ?>" alt="Países" width="25"
                                    class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Países</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('estadospaises.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/estadospaises') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_estadosPais.svg')); ?>"
                                    alt="Estados Países" width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Estados Países</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('municipios.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/municipios') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_municipios.svg')); ?>" alt="Municipios"
                                    width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Municipios</span>
                            </a>
                        </li>

                    </ul>
                </li>
            </template>

            <!-- Sistema (Master/Admin) -->
            <template x-if="hasAnyRole('Master','Administrador')">
                <li x-data="{ open:
            window.location.pathname.startsWith('/usuarios') ||
            window.location.pathname.startsWith('/roles')    ||
            window.location.pathname.startsWith('/permisos')
          }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                        :class="{ 'sidebar-active': open }">
                        <div class="flex items-center gap-3">
                            <i data-lucide="server" class="w-6 h-6 text-gray-600"></i>
                            <span x-show="sidebarOpen" x-transition.opacity>Sistema</span>
                        </div>
                        <i data-lucide="chevron-down" :class="{ 'rotate-180 transition-transform': open }"
                            class="w-4 h-4 text-gray-600"></i>
                    </button>
                    <ul x-show="open" x-transition class="ml-4 mt-1 space-y-1">

                        <li>
                            <a href="<?php echo e(route('usuarios.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/usuarios') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_usuario.svg')); ?>" alt="Usuarios"
                                    width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Usuarios</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('roles.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/roles') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_roles.svg')); ?>" alt="Roles" width="25"
                                    class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Roles</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('permisos.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/permisos') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_permisos.svg')); ?>" alt="Permisos"
                                    width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Permisos</span>
                            </a>
                        </li>

                    </ul>
                </li>
            </template>

            <!-- Operaciones (Master/Admin/Operativo) -->
            <template x-if="hasAnyRole('Master','Administrador','Operativo')">
                <li x-data="{ open:
            window.location.pathname.startsWith('/clientes')    ||
            window.location.pathname.startsWith('/empleados')   ||
            window.location.pathname.startsWith('/proveedores') ||
            window.location.pathname.startsWith('/productos')   ||
            window.location.pathname.startsWith('/servicios')   ||
            window.location.pathname.startsWith('/materiales')  ||
            window.location.pathname.startsWith('/equipos')     ||

            window.location.pathname.startsWith('/cotizacionessolicitudes') ||
            window.location.pathname.startsWith('/cotizacionesanalisis')
          }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                        :class="{ 'sidebar-active': open }">
                        <div class="flex items-center gap-3">

                            <img src="<?php echo e(asset('images/icons/sidebar/Iconos_administrador_de_archivos.svg')); ?>"
                                alt="Clientes" width="25" class="flex-shrink-0" />

                            <span x-show="sidebarOpen" x-transition.opacity>Administración</span>
                        </div>
                        <i data-lucide="chevron-down" :class="{ 'rotate-180 transition-transform': open }"
                            class="w-4 h-4 text-gray-600"></i>
                    </button>
                    <ul x-show="open" x-transition class="ml-4 mt-1 space-y-1">

                        <li>
                            <a href="<?php echo e(route('clientes.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/clientes') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_clientes.svg')); ?>" alt="Clientes"
                                    width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Clientes</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('empleados.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/empleados') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_empleados.svg')); ?>" alt="Empleados"
                                    width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Empleados</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('proveedores.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/proveedores') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_proveedores.svg')); ?>" alt="Proveedores"
                                    width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Proveedores</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('productos.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/productos') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_productos.svg')); ?>" alt="Productos"
                                    width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Productos</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('servicios.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/servicios') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_servicios.svg')); ?>" alt="Servicios"
                                    width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Servicios</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('materiales.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/materiales') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/Iconos_materiales.svg')); ?>" alt="Materiales"
                                    width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Materiales</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('equipos.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/equipos') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/Iconos_equipo.svg')); ?>" alt="Equipos"
                                    width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Equipos</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('cotizacionessolicitudes.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/cotizacionessolicitudes') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_solicituddecotizacion.svg')); ?>"
                                    alt="Solicitudes" width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Solicitudes</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('cotizacionesanalisis.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/cotizacionesanalisis') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_analisisdecotizacion.svg')); ?>"
                                    alt="Análisis" width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition.opacity>Análisis</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('cotizaciones.index')); ?>"
                                class="flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100"
                                :class="{ 'sidebar-active': window.location.pathname.startsWith('/cotizacionesanalisis') }">
                                <img src="<?php echo e(asset('images/icons/sidebar/iconos_cotizacion.svg')); ?>" alt="Análisis"
                                    width="25" class="flex-shrink-0" />
                                <span x-show="sidebarOpen" x-transition:opacity>Cotizaciones</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </template>
        </ul>
    </nav>

    <!-- Footer Sidebar -->
    <div class="border-t border-gray-200 p-4">
        <a href="#" class="flex items-center gap-3 text-red-600 hover:text-gray-900 logoutButton">
            <i data-lucide="door-open" class="w-6 h-6"></i>
            <span x-show="sidebarOpen" x-transition.opacity>Salir</span>
        </a>
    </div>

</aside>
<!-- FIN SIDEBAR --><?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>