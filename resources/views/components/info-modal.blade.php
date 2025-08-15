@props([
    'id' => 'infoDetailModal',
    'size' => 'lg'
])

{{--
Componente de Modal Genérico para mostrar detalles.
Se rellena dinámicamente mediante JavaScript.
--}}
<x-modal :id="$id" :size="$size" :show-save-button="false" :show-clear-button="false">
    <x-slot name="header">
        <span id="{{ $id }}Title">Detalles</span>
    </x-slot>
    <x-slot name="body">
        <div id="{{ $id }}Body" class="p-4">
            <div class="text-center">
                Cargando...
            </div>
        </div>
    </x-slot>
</x-modal>
