@props([
    'id' => 'defaultModalId',
    'formId' => null,
    'showCancelButton' => true,
    'showClearButton' => true,
    'showSaveButton' => true,
    'size' => 'md'
])

{{-- Componente de Modal --}}
{{-- Este componente es un modal reutilizable que puede ser utilizado en diferentes partes de la aplicación. --}}
{{-- Se puede personalizar el tamaño, los botones y el contenido del modal. --}}

{{-- Sección de encabezado del modal --}}
{{-- Puedes pasar el contenido del encabezado a través de la propiedad 'header' --}}
{{-- Sección del cuerpo del modal --}}
{{-- Puedes pasar el contenido del cuerpo a través de la propiedad 'body' --}}
{{-- Sección del pie de página del modal --}}
{{-- Puedes pasar el contenido del pie de página a través de la propiedad 'footer' --}}
@php
    // clase de tamaño usando las fracciones
    switch ($size) {
        case 'xs':
            $modalSizeClass = 'w-1/4'; // Extra small: 25% del ancho
            break;
        case 'sm':
            $modalSizeClass = 'w-1/3'; // Small: 33.33% del ancho
            break;
        case 'md':
            $modalSizeClass = 'w-1/2'; // Medium: 50% del ancho
            break;
        case 'lg':
            $modalSizeClass = 'w-2/3'; // Large: 66.66% del ancho
            break;
        case 'xl':
            $modalSizeClass = 'w-3/4'; // Extra large: 75% del ancho
            break;
        case 'full':
            $modalSizeClass = 'w-full';  // Full: 100% del ancho
            break;
        default:
            $modalSizeClass = 'w-1/2'; // Por defecto, tamaño mediano
            break;
    }
@endphp

{{-- <div id="{{ $id }}" class="art-modal-overlay hs-overlay hidden z-50 inset-0" tabindex="-1" {!! $alpine !!}> --}}
<div id="{{ $id }}" {{ $attributes->merge(['class' => 'art-modal-overlay hs-overlay hidden z-50 inset-0']) }}>
    <div class="art-modal-container   {{ $modalSizeClass }} ">
        {{-- Header --}}
        <div class="art-modal-header">
            <h3 class="art-modal-header-title">{{ $header }}</h3>
            <button type="button" data-hs-overlay="#{{ $id }}" class="art-modal-close-button">
                <i class="w-6 h-6" data-lucide="x"></i>
            </button>
        </div>

        {{-- Body --}}
        <div class="art-modal-body">
            {{ $body }}
        </div>
        <div class="art-modal-footer">

            <x-buttons :id="$id" :form-id="$formId" :show-cancel-button="$showCancelButton"
                :show-clear-button="$showClearButton" :show-save-button="$showSaveButton">
                {{-- Si deseas agregar contenido extra en el footer, lo puedes pasar aquí --}}
                @if (isset($footer))
                    {{ $footer }}
                @endif
            </x-buttons>
        </div>
    </div>
</div>

<script>
    window.Helpers = {
        /**
         * Muestra el modal dado su ID.
         */
        showModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) {
                console.warn(`Modal con ID "${modalId}" no encontrado.`);
                return;
            }
            modal.classList.remove("hidden");
            modal.classList.add("open", "opened");
        },

        /**
         * Oculta el modal dado su ID.
         */
        hideModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) {
                console.warn(`Modal con ID "${modalId}" no encontrado.`);
                return;
            }
            modal.classList.remove("open", "opened");
            modal.classList.add("hidden");
        },

        /**
         * Alterna la visibilidad del modal.
         */
        toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) {
                console.warn(`Modal con ID "${modalId}" no encontrado.`);
                return;
            }
            modal.classList.toggle("hidden");
            modal.classList.toggle("open");
        },

        /**
         * Cierra el modal padre del botón con data-modal-action=\"close\",
         * y resetea el formulario dentro si existe.
         */
        closeFromButton(event) {
            const modal = event.target.closest('[id$=\"Modal\"]');
            if (modal) {
                modal.classList.add('hidden');
                const form = modal.querySelector('form');
                if (form) form.reset();
            }
        }
    };

    // Delegación del evento para cerrar con botones que tengan data-modal-action="close"
    document.addEventListener('click', function (event) {
        if (event.target.dataset.modalAction === 'close') {
            window.Helpers.closeFromButton(event);
        }
    });

</script>
