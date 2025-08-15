<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div x-data="{
        isModalOpen: false,
        formData: {
            cliente_nombre: '',
            cliente_telefono: '',
            contacto_nombre: '',
            contacto_apellidos: '',
            contacto_email: '',
            contacto_telefono: '',
            contacto_cargo: ''
        },
        errors: {},
        isLoading: false,
        submitForm() {
            this.isLoading = true;
            this.errors = {};
            // Despacha los datos del formulario para que sean manejados por el JS del módulo
            this.$dispatch('quick-save-client-data', JSON.parse(JSON.stringify(this.formData)));
        },
        closeModal() {
            this.isModalOpen = false;
            // Opcional: this.$dispatch('close-modal'); si algún otro componente necesita saberlo
        }
    }"
    x-show="isModalOpen"
    @keydown.escape.window="closeModal()"
    x-on:open-quick-client-modal.window="isModalOpen = true; errors = {}; isLoading = false; formData = { cliente_nombre: '', cliente_telefono: '', contacto_nombre: '', contacto_apellidos: '', contacto_email: '', contacto_telefono: '', contacto_cargo: '' };" // Abre y resetea
    @quick-client-errors.window="if(isModalOpen) { errors = $event.detail; isLoading = false; }" // Escucha errores de validación
    @quick-client-success.window="if(isModalOpen) { closeModal(); formData = { cliente_nombre: '', cliente_telefono: '', contacto_nombre: '', contacto_apellidos: '', contacto_email: '', contacto_telefono: '', contacto_cargo: '' }; errors = {}; isLoading = false; }" // Cierra y resetea en éxito
    @quick-client-generic-error.window="if(isModalOpen) { alert($event.detail); isLoading = false; }" // Muestra error genérico
    style="display: none;" 
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
>
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        
        <div x-show="isModalOpen"
             x-transition:enter="ease-out duration-300" enter-start="opacity-0" enter-end="opacity-100"
             x-transition:leave="ease-in duration-200" leave-start="opacity-100" leave-end="opacity-0"
             class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
             @click="closeModal()"
             aria-hidden="true"></div>

        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div x-show="isModalOpen"
             x-transition:enter="ease-out duration-300" enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200" leave-start="opacity-100 translate-y-0 sm:scale-100" leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white rounded-lg shadow-xl">
            
            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                Crear Prospecto - Quick
            </h3>
            <form @submit.prevent="submitForm()">
                <div class="mt-4 space-y-4">
                    
                    <div>
                        <label for="qc_cliente_nombre" class="block text-sm font-medium text-gray-700">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" x-model="formData.cliente_nombre" id="qc_cliente_nombre" class="art-input-custom mt-1 block w-full" required
                               @blur="if (formData.contacto_nombre === '' && formData.cliente_nombre.trim() !== '') {
                                         formData.contacto_nombre = formData.cliente_nombre;
                                     }"
                        >
                        <template x-if="errors.cliente_nombre"><p class="mt-1 text-xs text-red-600" x-text="errors.cliente_nombre[0]"></p></template>
                    </div>
                    <div>
                        <label for="qc_cliente_telefono" class="block text-sm font-medium text-gray-700">Tel&eacute;lefono <span class="text-red-500">*</span></label>
                        <input type="text" x-model="formData.cliente_telefono" id="qc_cliente_telefono" class="art-input-custom mt-1 block w-full"
                               @blur="if (formData.contacto_telefono === '' && formData.cliente_telefono.trim() !== '') {
                                         formData.contacto_telefono = formData.cliente_telefono;
                                     }"
                        >
                        <template x-if="errors.cliente_telefono"><p class="mt-1 text-xs text-red-600" x-text="errors.cliente_telefono[0]"></p></template>
                    </div>

                    
                    <hr class="my-3">
                    <h4 class="text-md font-medium leading-6 text-gray-800">Datos del Contacto</h4>
                    <div>
                        <label for="qc_contacto_nombre" class="block text-sm font-medium text-gray-700">Nombres <span class="text-red-500">*</span></label>
                        <input type="text" x-model="formData.contacto_nombre" id="qc_contacto_nombre" class="art-input-custom mt-1 block w-full" required>
                        <template x-if="errors.contacto_nombre"><p class="mt-1 text-xs text-red-600" x-text="errors.contacto_nombre[0]"></p></template>
                    </div>
                    <div>
                        <label for="qc_contacto_apellidos" class="block text-sm font-medium text-gray-700">Apellidos <span class="text-red-500">*</span></label>
                        <input type="text" x-model="formData.contacto_apellidos" id="qc_contacto_apellidos" class="art-input-custom mt-1 block w-full" required>
                        <template x-if="errors.contacto_apellidos"><p class="mt-1 text-xs text-red-600" x-text="errors.contacto_apellidos[0]"></p></template>
                    </div>
                    <div>
                        <label for="qc_contacto_email" class="block text-sm font-medium text-gray-700">Correo Electr&oacuteonico <span class="text-red-500">*</span></label>
                        <input type="email" x-model="formData.contacto_email" id="qc_contacto_email" class="art-input-custom mt-1 block w-full">
                        <template x-if="errors.contacto_email"><p class="mt-1 text-xs text-red-600" x-text="errors.contacto_email[0]"></p></template>
                    </div>
                    <div>
                        <label for="qc_contacto_telefono" class="block text-sm font-medium text-gray-700">Tel&eacute;lefono <span class="text-red-500">*</span></label>
                        <input type="text" x-model="formData.contacto_telefono" id="qc_contacto_telefono" class="art-input-custom mt-1 block w-full">
                        <template x-if="errors.contacto_telefono"><p class="mt-1 text-xs text-red-600" x-text="errors.contacto_telefono[0]"></p></template>
                    </div>
                    <div>
                        <label for="qc_contacto_cargo" class="block text-sm font-medium text-gray-700">Cargo  (Opcional)</label>
                        <input type="text" x-model="formData.contacto_cargo" id="qc_contacto_cargo" class="art-input-custom mt-1 block w-full">
                        <template x-if="errors.contacto_cargo"><p class="mt-1 text-xs text-red-600" x-text="errors.contacto_cargo[0]"></p></template>
                    </div>
                </div>

                <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" :disabled="isLoading"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm art-btn-primary hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm"
                            :class="{'opacity-50 cursor-not-allowed': isLoading}">
                        <span x-show="isLoading">Guardando...</span>
                        <span x-show="!isLoading">Guardar</span>
                    </button>
                    <button type="button" @click="closeModal()" :disabled="isLoading"
                            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm art-btn-secondary hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/components/form-create-prospecto.blade.php ENDPATH**/ ?>