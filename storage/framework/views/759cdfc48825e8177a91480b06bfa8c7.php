<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'showUser'       => false,       // Controla si se muestran los campos 'Creado por' y 'Modificado por'
    'showTimestamps' => true,        // Controla si se muestran las fechas 'Fecha Creación' y 'Fecha Modificación'
    'showStatus'     => true,        // Controla si se muestra el campo 'Estado'
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
    'showUser'       => false,       // Controla si se muestran los campos 'Creado por' y 'Modificado por'
    'showTimestamps' => true,        // Controla si se muestran las fechas 'Fecha Creación' y 'Fecha Modificación'
    'showStatus'     => true,        // Controla si se muestra el campo 'Estado'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<hr class="my-2 border-gray-200">


<div class="bg-white p-4 rounded-lg shadow-sm">
  
  <div class="grid grid-cols-12 gap-4">

    <?php if($showTimestamps): ?>
      
      <div class="col-span-12 md:col-span-12 lg:col-span-6">
        <label for="fecha_registro" class="art-label-custom">Fecha de Registro</label>
        <div class="flex mt-1">
          <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-600 text-sm">
            <i data-lucide="calendar" class="w-4 h-4"></i>
          </span>
          <input
            type="text"
            id="fecha_registro"
            name="fecha_registro"
            disabled
            class="flex-1 block w-full rounded-none rounded-r-md art-input-custom bg-gray-50 text-gray-700 text-sm
                   cursor-not-allowed"
            value="<?php echo e($fechaRegistro); ?>"
          >
        </div>
      </div>

      
      <div class="col-span-12 md:col-span-12 lg:col-span-6">
        <label for="fecha_actualizacion" class="art-label-custom">Fecha de Actualización</label>
        <div class="flex mt-1">
          <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-600 text-sm">
            <i data-lucide="calendar" class="w-4 h-4"></i>
          </span>
          <input
            type="text"
            id="fecha_actualizacion"
            name="fecha_actualizacion"
            disabled
            class="flex-1 block w-full rounded-none rounded-r-md art-input-custom bg-gray-50 text-gray-700 text-sm
                   cursor-not-allowed"
            value="<?php echo e($fechaActualizacion); ?>"
          >
        </div>
      </div>
    <?php endif; ?>

    <?php if($showStatus): ?>
      
      <div class="col-span-12 md:col-span-12 lg:col-span-6">
        <label for="estado-texto" class="art-label-custom">Estado</label>
        <div class="flex mt-1">
          <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-600 text-sm">
            <i data-lucide="info" class="w-4 h-4"></i>
          </span>
          <input
            type="text"
            id="estado-texto"
            name="estado-texto"
            disabled
            class="flex-1 block w-full rounded-none rounded-r-md art-input-custom bg-gray-50 text-gray-700 text-sm
                   cursor-not-allowed"
            value="<?php echo e($estadoTexto); ?>"
          >
          <input type="hidden" name="estado" value="<?php echo e($estado); ?>">
        </div>
      </div>
    <?php endif; ?>

    <?php if($showUser): ?>
      
      <div class="col-span-12 md:col-span-12 lg:col-span-6">
        <label for="usuario_nombre_display" class="art-label-custom">Usuario</label>
        <div class="flex mt-1">
          <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-600 text-sm">
            <i data-lucide="user" class="w-4 h-4"></i>
          </span>
          
          <?php if(Auth::guard('api')->check()): ?>
            
            <input
              type="text"
              id="usuario_nombre_display"
              name="usuario_nombre_display"
              disabled
              class="flex-1 block w-full rounded-none rounded-r-md art-input-custom bg-gray-50 text-gray-700 text-sm
                     cursor-not-allowed"
              
              value="<?php echo e(Auth::guard('api')->user()->nombre ?? 'Usuario no encontrado'); ?>"
            >
            
            
            
            <input type="hidden" id="usuario_id" name="usuario_id" value="<?php echo e(Auth::guard('api')->user()->id); ?>">
          <?php else: ?>
            
            <input
              type="text"
              id="usuario_nombre_display"
              name="usuario_nombre_display"
              disabled
              class="flex-1 block w-full rounded-none rounded-r-md art-input-custom bg-gray-50 text-gray-700 text-sm
                     cursor-not-allowed"
              value="N/A"
            >
            <input type="hidden" id="usuario_id" name="usuario_id" value="">
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>
</div>
<?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/components/form-auditoria.blade.php ENDPATH**/ ?>