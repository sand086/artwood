<?php $__env->startSection('title', 'Mi perfil'); ?>

<?php $__env->startSection('content'); ?>
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="Perfil">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Mi perfil</h1>

        <div class="overflow-x-auto">
            <div class="p-1.5 space-y-12">
                
                <form id="perfilForm" method="POST" action="#">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <!-- Sección de imágenes: Avatar y Foto de Portada -->
                    <div class="grid grid-cols-12 gap-6 mb-6">
                        
                        <div class="col-span-12 lg:col-span-4">
                            <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-2"
                                for="avatar">Avatar</label>
                            <div data-hs-file-upload='{
                                                  "url": "/upload/avatar",
                                                  "acceptedFiles": "image/*",
                                                  "maxFiles": 1,
                                                  "singleton": true
                                                }' class="flex flex-col items-center">
                                <template data-hs-file-upload-preview="">
                                    <div class="w-24 h-24">
                                        <img class="w-full h-full object-cover rounded-full" data-dz-thumbnail alt="Avatar">
                                    </div>
                                </template>
                                <div class="group mt-2" data-hs-file-upload-previews=""
                                    data-hs-file-upload-pseudo-trigger="">
                                    <span class="file-upload-previews-span">
                                        <i class="w-10 h-10 text-gray-400" data-lucide="user"></i>
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Sube tu avatar (máx 1 MB)</p>
                                <div class="flex gap-2 mt-2">
                                    <button type="button" data-hs-file-upload-trigger=""
                                        class="art-button-upload-icon-user">
                                        <i class="w-6 h-6" data-lucide="upload"></i>
                                    </button>
                                    <button type="button" data-hs-file-upload-clear=""
                                        class="art-button-trash-icon-upload-user">
                                        <i class="w-6 h-6" data-lucide="trash-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-span-12 lg:col-span-8">
                            <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-2" for="portada">Foto de
                                portada</label>
                            <div data-hs-file-upload='{
                                                  "url": "/upload/portada",
                                                  "acceptedFiles": "image/*",
                                                  "maxFiles": 1
                                                }'
                                class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                <!-- Área de drag & drop -->
                                <div class="flex flex-col items-center justify-center h-48">
                                    <template data-hs-file-upload-preview="">
                                        <img class="absolute inset-0 w-full h-full object-cover" data-dz-thumbnail
                                            alt="Portada">
                                    </template>
                                    <div class="flex flex-col items-center z-10">
                                        <i class="w-10 h-10 text-gray-400" data-lucide="image"></i>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 text-center">
                                            Arrastra y suelta o haz clic para seleccionar una imagen (máx 2 MB)
                                        </p>
                                    </div>
                                </div>
                                <!-- Botón de borrar en esquina superior derecha -->
                                <button type="button" data-hs-file-upload-clear=""
                                    class="absolute top-2 right-2 bg-white dark:bg-gray-600 rounded-full p-1 shadow">
                                    <i class="w-5 h-5 text-gray-600 dark:text-gray-300" data-lucide="trash-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Información Personal -->
                    <div class="grid grid-cols-12 gap-4 mb-6">
                        <div class="col-span-12">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Información personal
                            </h2>
                        </div>
                        <div class="col-span-12 md:col-span-6">
                            <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre
                                completo</label>
                            <input type="text" id="nombre" name="nombre" placeholder="Ej: John Doe"
                                class="art-input-custom mt-1 w-full" required>
                        </div>
                        <div class="col-span-12 md:col-span-6">
                            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre
                                de usuario</label>
                            <input type="text" id="username" name="username" placeholder="Ej: john_doe"
                                class="art-input-custom mt-1 w-full" required>
                        </div>
                        <div class="col-span-12 md:col-span-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo
                                electrónico</label>
                            <input type="email" id="email" name="email" placeholder="Ej: example@mail.com"
                                class="art-input-custom mt-1 w-full" required>
                        </div>
                        <div class="col-span-12 md:col-span-6">
                            <label for="ubicacion"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ubicación</label>
                            <input type="text" id="ubicacion" name="ubicacion" placeholder="Ciudad/País"
                                class="art-input-custom mt-1 w-full">
                        </div>
                    </div>

                    <!-- Botones de acción para el formulario de perfil -->
                    <div
                        class="flex justify-between items-center border-t border-gray-300 dark:border-gray-600 mt-4 pt-4 px-4">
                        <div></div>
                        <div class="flex items-center gap-3">
                            <button type="button"
                                class="flex items-center px-3 py-2 art-btn-tertiary hover:filter hover:brightness-90"
                                data-hs-overlay="#modalPerfil">
                                <i data-lucide="x" class="mr-2 w-4 h-4"></i>Cancelar
                            </button>
                            <button type="submit"
                                class="flex items-center px-3 py-2 art-btn-primary hover:filter hover:brightness-90"
                                form="perfilForm">
                                <i data-lucide="save" class="mr-2 w-4 h-4"></i>Guardar
                            </button>
                        </div>
                    </div>
                </form>

                
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Seguridad de la cuenta</h2>

                    <div class="space-y-12">
                        <!-- Sección: Cambiar Contraseña -->
                        <section
                            class="p-5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Contraseña</h3>
                            <form method="POST" action="#">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="grid grid-cols-12 gap-4">
                                    <!-- Contraseña actual -->
                                    <div class="col-span-12 md:col-span-6">
                                        <label for="current_password"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Contraseña actual
                                        </label>
                                        <input type="password" id="current_password" name="current_password"
                                            placeholder="Introduce tu contraseña actual"
                                            class="art-input-custom mt-1 w-full" required>
                                    </div>
                                    <!-- Nueva contraseña -->
                                    <div class="col-span-12 md:col-span-6">
                                        <label for="new_password"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Nueva contraseña
                                        </label>
                                        <input type="password" id="new_password" name="new_password"
                                            placeholder="Introduce tu nueva contraseña" class="art-input-custom mt-1 w-full"
                                            required>
                                    </div>
                                    <!-- Indicador de fuerza de contraseña (opcional) -->
                                    <div class="col-span-12">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nivel</label>
                                        <div class="relative w-full h-2 bg-gray-200 dark:bg-gray-600 rounded">
                                            <div id="password-strength-bar"
                                                class="absolute left-0 top-0 h-2 bg-green-500 rounded transition-all duration-300"
                                                style="width: 40%;"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            La barra se actualizará según la complejidad de tu nueva contraseña.
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-6 flex items-center justify-between">
                                    <a href="#" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Olvidé mi
                                        contraseña</a>
                                    <button type="submit"
                                        class="flex items-center px-3 py-2 art-btn-primary hover:filter hover:brightness-90"
                                        form="perfilForm">
                                        <i data-lucide="save" class="mr-2 w-4 h-4"></i>Cambiar
                                    </button>
                                </div>
                            </form>
                        </section>

                        <!-- Sección: Verificación en Dos Pasos (2FA) -->
                        <section
                            class="p-6 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Verificación en dos
                                pasos</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                Autenticación de dos factores (2FA) mediante una aplicación Authenticator. Al activar esta
                                función,
                                se agrega una capa extra de seguridad para evitar accesos no autorizados. Una vez
                                habilitada, deberás
                                generar códigos de verificación para iniciar sesión. Si no se introduce el código
                                correctamente, no será
                                posible acceder al sistema.
                            </p>
                            <form method="POST" action="#">
                                <?php echo csrf_field(); ?>
                                <div class="grid grid-cols-12 gap-4">
                                    <div class="col-span-12 md:col-span-6">
                                        <label for="otp_code"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Código de
                                            verificación</label>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                            Se enviará un código de verificación a tu correo registrado. Por favor,
                                            introdúcelo aquí:
                                        </p>
                                        <input type="text" id="otp_code" name="otp_code" placeholder="Introduce el OTP"
                                            class="art-input-custom mt-1 w-full" required>
                                    </div>
                                    <div class="col-span-12 md:col-span-6 flex flex-col justify-center">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Reenviar OTP en <span class="font-semibold">57</span> segundos
                                        </p>
                                    </div>
                                </div>

                                <div
                                    class="flex justify-between items-center border-t border-gray-300 dark:border-gray-600 mt-4 pt-4 px-4">
                                    <div></div>
                                    <div class="flex items-center gap-3">
                                        <button type="button"
                                            class="flex items-center px-3 py-2 art-btn-tertiary hover:filter hover:brightness-90"
                                            data-hs-overlay="#modalPerfil">
                                            <i data-lucide="x" class="mr-2 w-4 h-4"></i>Cancelar
                                        </button>
                                        <button type="submit"
                                            class="flex items-center px-3 py-2 art-btn-primary hover:filter hover:brightness-90"
                                            form="perfilForm">
                                            <i data-lucide="save" class="mr-2 w-4 h-4"></i>Habilitar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </section>

                        <!-- Sección: Aplicación de Autenticación -->
                        <section
                            class="p-5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Aplicación de
                                    autenticación</h3>
                                <!-- Botones de estado -->
                                <div class="flex items-center gap-2">
                                    <!-- Botón Activado -->
                                    <button type="button"
                                        class="bg-green-100 text-green-600 px-3 py-1 rounded-md text-sm font-semibold">
                                        Activado
                                    </button>
                                    <!-- Botón Principal -->
                                    <button type="button"
                                        class="bg-gray-100 text-gray-600 px-3 py-1 rounded-md text-sm font-semibold">
                                        Principal
                                    </button>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Utilice una aplicación de autenticación como autenticación de dos factores (2FA). Cuando
                                inicie sesión, se le pedirá que utilice el código de seguridad que le proporcione la
                                aplicación.
                            </p>
                        </section>

                        <!-- Sección: Zona de Peligro -->
                        <section
                            class="p-5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Zona de peligro</h3>
                            <!-- Botón para eliminar el perfil -->
                            <button type="button"
                                class="bg-red-600 text-white px-4 py-2 rounded-md font-semibold hover:bg-red-700">
                                Eliminar mi perfil
                            </button>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                                Esto eliminará inmediatamente todos tus datos. Esta acción es irreversible, así que continúa
                                con precaución.
                            </p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        // Lógica para actualizar la barra de fuerza de contraseña
        const newPasswordInput = document.getElementById('new_password');
        const strengthBar = document.getElementById('password-strength-bar');

        newPasswordInput?.addEventListener('input', function () {
            const val = newPasswordInput.value;
            let score = 0;
            if (val.length >= 8) score += 25;
            if (/[A-Z]/.test(val)) score += 25;
            if (/[0-9]/.test(val)) score += 25;
            if (/[^A-Za-z0-9]/.test(val)) score += 25;
            strengthBar.style.width = score + '%';

            // Cambiar color según el puntaje
            strengthBar.classList.remove('bg-green-500', 'bg-yellow-500', 'bg-red-500');
            if (score < 50) {
                strengthBar.classList.add('bg-red-500');
            } else if (score < 100) {
                strengthBar.classList.add('bg-yellow-500');
            } else {
                strengthBar.classList.add('bg-green-500');
            }
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.appP', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/modules/Usuarios/perfil.blade.php ENDPATH**/ ?>