<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
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
]));

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

foreach (array_filter(([
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
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>


<div class="flex justify-between items-center border-t mt-4 pt-4 px-4">
    <div>
    <?php if($showClearButton): ?>
        <button type="reset" 
                class="flex items-center px-3 py-2 art-btn-secondary hover:filter hover:brightness-90"
                form="<?php echo e($formId); ?>">
                <i data-lucide="paintbrush" class="mr-2 w-4 h-4"></i>Limpiar
        </button>
    <?php endif; ?>
    </div>

    <div class="flex items-center gap-3">
    <?php if($showCancelButton): ?>
        <button type="button" 
                class="flex items-center px-3 py-2 art-btn-tertiary hover:filter hover:brightness-90"
              <?php if($cancelDispatch): ?>
                @click="$dispatch('<?php echo e($cancelDispatch); ?>')"
              <?php elseif($cancelEvent): ?>
                @click="<?php echo e($cancelEvent); ?>"
              <?php elseif($cancelDataAction): ?>
                data-modal-action="<?php echo e($cancelDataAction); ?>"
              <?php else: ?>
                data-modal-action="close"
              <?php endif; ?>
              >
            <i data-lucide="x" class="mr-2 w-4 h-4"></i>Cancelar
        </button>
    <?php endif; ?>

    <?php if($showSaveButton): ?>
        <button type="submit"  
                class="flex items-center px-3 py-2 art-btn-primary hover:filter hover:brightness-90"
                form="<?php echo e($formId); ?>"
                <?php if($saveEvent): ?>
                @click.prevent="<?php echo e($saveEvent); ?>"
                <?php endif; ?>
                >
            <i data-lucide="save" class="mr-2 w-4 h-4"></i><?php echo e($saveLabel); ?>

        </button>
    <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/components/buttons.blade.php ENDPATH**/ ?>