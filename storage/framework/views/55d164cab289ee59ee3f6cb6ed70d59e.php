
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label',
    'name',
    'id',
    'table',
    'valueField',
    'labelField',
    'placeholder' => '',
    'with' => [],
    'where' => [],
    'orderBy' => [],
    'parentIdField' => null,
    'value' => '',            // Valor inicial (útil para 'old()', pero 'set-value' tendrá prioridad en edición)
    'attributes' => null,
    'selected' => null,       // Para una opcion preseleccionada
    'required' => false,      // Determina si es requerido, por defecto a false
    'disabled' => false,      // Determina si es deshabilitado, por defecto a false
    'readonly' => false,     // Determina si es solo lectura, por defecto a false
    'populateFields' => [],   // Array de mapeos: [['source_key' => 'api_key', 'target_id' => 'field_id', 'target_event' => 'optional_event']]
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
    'label',
    'name',
    'id',
    'table',
    'valueField',
    'labelField',
    'placeholder' => '',
    'with' => [],
    'where' => [],
    'orderBy' => [],
    'parentIdField' => null,
    'value' => '',            // Valor inicial (útil para 'old()', pero 'set-value' tendrá prioridad en edición)
    'attributes' => null,
    'selected' => null,       // Para una opcion preseleccionada
    'required' => false,      // Determina si es requerido, por defecto a false
    'disabled' => false,      // Determina si es deshabilitado, por defecto a false
    'readonly' => false,     // Determina si es solo lectura, por defecto a false
    'populateFields' => [],   // Array de mapeos: [['source_key' => 'api_key', 'target_id' => 'field_id', 'target_event' => 'optional_event']]
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div >
    <label for="<?php echo e($id); ?>" class="art-label-custom">
        <?php echo e($label); ?>

        <?php if($required): ?> <span class="text-red-500">*</span> <?php endif; ?>
    </label>
    <select
        name="<?php echo e($name); ?>"
        id="<?php echo e($id); ?>"
        <?php echo e($attributes->merge(['class' => 'art-select-custom'])); ?>

        data-table="<?php echo e($table); ?>"
        data-value-field="<?php echo e($valueField); ?>"
        data-label-field="<?php echo e($labelField); ?>"
        data-placeholder="<?php echo e($placeholder); ?>"
        data-where="<?php echo e(json_encode($where)); ?>"
        data-order-by="<?php echo e(json_encode($orderBy)); ?>"
        data-parent-id-field="<?php echo e(is_array($parentIdField) ? json_encode($parentIdField) : $parentIdField); ?>"
        data-initial-value="<?php echo e($value); ?>" 
        data-target-value="" 
        data-options-loaded="false" 
        <?php if(!empty($populateFields)): ?>
        data-populate-fields="<?php echo e(json_encode($populateFields)); ?>"
        <?php endif; ?>
        <?php if($disabled): echo 'disabled'; endif; ?> 
        <?php if($readonly): echo 'readonly'; endif; ?> 
        <?php if($required): echo 'required'; endif; ?> 
    >
        <?php if($placeholder): ?>
            <option value=""><?php echo e($placeholder); ?></option>
        <?php endif; ?>
        
    </select>
    
    
</div>

<?php $__env->startPush('scripts'); ?>
    
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/components/form-select.blade.php ENDPATH**/ ?>