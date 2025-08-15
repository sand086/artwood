@props([
    'id' => '',           // ID del modal, para cerrar con HS-overlay
    'formId' => '',       // ID del formulario
    'showSaveButton' => true,
    'saveLabel' => 'Guardar',
    'saveEvent' => null, // Evento JS para guardar
    'saveDataAction' => null, // Acción de datos para guardar
    'showCancelButton' => true,
    'cancelEvent' => null, // Evento JS para cancelar
    'cancelDispatch' => null, // Evento Alpine a despachar al cancelar
    'cancelDataAction' => null, // Acción de datos para cancelar
    'showClearButton' => true,
    'footer' => null,     // Contenido adicional opcional en el footer
])

{{-- <div class="py-2 px-2 border-t flex justify-end space-x-2"> --}}
<div class="flex justify-between items-center border-t mt-4 pt-4 px-4">
    <div>
    @if($showClearButton)
        <button type="reset" 
                class="flex items-center px-3 py-2 art-btn-secondary hover:filter hover:brightness-90"
                form="{{ $formId }}">
                <i data-lucide="paintbrush" class="mr-2 w-4 h-4"></i>Limpiar
        </button>
    @endif
    </div>

    <div class="flex items-center gap-3">
    @if($showCancelButton)
        <button type="button" 
                class="flex items-center px-3 py-2 art-btn-tertiary hover:filter hover:brightness-90"
              @if($cancelDispatch)
                @click="$dispatch('{{ $cancelDispatch }}')"
              @elseif($cancelEvent)
                @click="{{ $cancelEvent }}"
              @elseif($cancelDataAction)
                data-modal-action="{{ $cancelDataAction }}"
              @else
                data-modal-action="close"
              @endif
              >
            <i data-lucide="x" class="mr-2 w-4 h-4"></i>Cancelar
        </button>
    @endif

    @if($showSaveButton)
        <button type="submit"  
                class="flex items-center px-3 py-2 art-btn-primary hover:filter hover:brightness-90"
                form="{{ $formId }}"
                @if($saveEvent)
                @click.prevent="{{ $saveEvent }}"
                @endif
                >
            <i data-lucide="save" class="mr-2 w-4 h-4"></i>{{ $saveLabel }}
        </button>
    @endif
    </div>
</div>
