<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id' => 'defaultModalId',
    'formId' => null,
    'showCancelButton' => true,
    'showClearButton' => true,
    'showSaveButton' => true,
    'size' => 'md'
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
    'id' => 'defaultModalId',
    'formId' => null,
    'showCancelButton' => true,
    'showClearButton' => true,
    'showSaveButton' => true,
    'size' => 'md'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>











<?php
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
?>

<div id="<?php echo e($id); ?>" class="art-modal-overlay hs-overlay hidden z-50 inset-0" tabindex="-1">
    <div class="art-modal-container   <?php echo e($modalSizeClass); ?> ">
        
        <div class="art-modal-header">
            <h3 class="art-modal-header-title"><?php echo e($header); ?></h3>
            <button type="button" data-hs-overlay="#<?php echo e($id); ?>" class="art-modal-close-button">
                <i class="w-6 h-6" data-lucide="x"></i>
            </button>
        </div>

        
        <div class="art-modal-body">
            <?php echo e($body); ?>

        </div>
        <div class="art-modal-footer">

            <?php if (isset($component)) { $__componentOriginalbac5affb147c7bb0375e6eb7b7d76916 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbac5affb147c7bb0375e6eb7b7d76916 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.buttons','data' => ['id' => $id,'formId' => $formId,'showCancelButton' => $showCancelButton,'showClearButton' => $showClearButton,'showSaveButton' => $showSaveButton]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($id),'form-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($formId),'show-cancel-button' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($showCancelButton),'show-clear-button' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($showClearButton),'show-save-button' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($showSaveButton)]); ?>
                
                <?php if(isset($footer)): ?>
                    <?php echo e($footer); ?>

                <?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbac5affb147c7bb0375e6eb7b7d76916)): ?>
<?php $attributes = $__attributesOriginalbac5affb147c7bb0375e6eb7b7d76916; ?>
<?php unset($__attributesOriginalbac5affb147c7bb0375e6eb7b7d76916); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbac5affb147c7bb0375e6eb7b7d76916)): ?>
<?php $component = $__componentOriginalbac5affb147c7bb0375e6eb7b7d76916; ?>
<?php unset($__componentOriginalbac5affb147c7bb0375e6eb7b7d76916); ?>
<?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/components/modal.blade.php ENDPATH**/ ?>