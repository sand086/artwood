<!-- NAVBAR SUPERIOR -->
<header x-data="navUser()" x-init="init()" class="flex items-center h-16 bg-white shadow px-4">
    <!-- Barra de Búsqueda / Botones / Notificaciones / Perfil -->
    <div class="flex-1">
        <!-- Ejemplo: Input de búsqueda -->
        <div class="relative w-72">
            
        </div>
    </div>
    <!-- Menú de Perfil -->
    <div class="ml-4 flex items-center space-x-4">
        <!-- Botón para activar el modo oscuro -->
        
        



        <!-- Notificaciones -->
        



        <!-- Usuario -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center focus:outline-none">
                <div class="ml-2 flex flex-col leading-tight">
                    <span class="w-full text-left text-gray-800 font-bold" x-text="nombre"></span>
                    <span class="w-full text-left text-gray-600 text-xs mt-0.5" x-text="rol"></span>
                </div>
                <img :src="foto_url || '<?php echo e(asset('images/icons/sidebar/iconos_usuarioCuenta.svg')); ?>'"
                    class="rounded-full" width="60" />
                <!-- Flecha hacia abajo -->
                <svg class="ml-1 w-4 h-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <!-- Dropdown de usuario -->
            <div x-show="open" @click.away="open = false"
                class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg z-20">
                <!-- Encabezado con rol y bienvenida -->
                <div class="px-4 py-3 border-b border-gray-200">
                    <p class="text-xs text-gray-500">Bienvenido</p>
                </div>
                <!-- Opciones -->
                <ul class="py-1">
                    <li>
                        <a href="/ajustes" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="w-4 h-4 mr-2" data-lucide="settings"></i>
                            Ajustes
                        </a>
                    </li>
                    <li>
                        <a href="/perfil" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="w-4 h-4 mr-2" data-lucide="user"></i>
                            Mi perfil
                        </a>
                    </li>
                </ul>
                <!-- Opción de salir -->
                <div class="border-t border-gray-200">
                    <a href="#"
                        class="logoutButton flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="w-4 h-4 mr-2" data-lucide="log-out"></i>
                        Salir
                    </a>
                </div>
            </div>
        </div>




    </div>
</header>
<!-- FIN NAVBAR --><?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/partials/navbar.blade.php ENDPATH**/ ?>