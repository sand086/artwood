<?php
    // Determinar si se definieron botones en la configuración.
    // Por ejemplo: edit, delete, custom.
    $hasButtons = (!empty($actionsConfig['edit']) && $actionsConfig['edit']) ||
        (!empty($actionsConfig['delete']) && $actionsConfig['delete']) ||
        (!empty($actionsConfig['custom']) && is_array($actionsConfig['custom']));
?>

<?php if($hasButtons): ?>
    <div class="action-buttons inline-flex rounded-lg shadow-2xs">
        
        <?php if(!empty($actionsConfig['edit']) && $actionsConfig['edit']): ?>
            
            <button
                class="editar mr-2.5 inline-flex items-center gap-x-2 -ms-px first:rounded-s-lg first:ms-0 last:rounded-e-lg focus:z-10  bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900  dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 "
                data-id="<?php echo e($row->{$keyName ?? 'id'}); ?>"
                data-url="<?php echo e(isset($module) ? route($module . '.edit', $row->{$keyName ?? 'id'}) : '#'); ?>">

                <img src="<?php echo e(asset('images/icons/crud/iconos_editar.svg')); ?>" alt="Editar" class="w-9" width="30">
            </button>
            
        <?php endif; ?>

        
        <?php if(!empty($actionsConfig['delete']) && $actionsConfig['delete']): ?>
            
            <button data-id="<?php echo e($row->{$keyName ?? 'id'}); ?>"
                data-url="<?php echo e(isset($module) ? route($module . '.destroy', $row->{$keyName ?? 'id'}) : '#'); ?>"
                class="eliminar inline-flex items-center gap-x-2 -ms-px first:rounded-s-lg first:ms-0 last:rounded-e-lg focus:z-10  bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900  dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                data-method="delete" data-confirm="¿Estás seguro?">
                <img src="<?php echo e(asset('images/icons/crud/iconos_eliminar.svg')); ?>" alt="Eliminar" class="w-9" width="30">

            </button>
            
        <?php endif; ?>


        
        <?php if(!empty($actionsConfig['custom']) && is_array($actionsConfig['custom'])): ?>
            <?php $__currentLoopData = $actionsConfig['custom']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $custom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $displayButton = true; // Mostrar por defecto

                    // Lógica de Condición
                    if (isset($custom['condition']) && is_array($custom['condition'])) {
                        $field = $custom['condition']['field'] ?? null;
                        $expectedValue = $custom['condition']['value'] ?? null;
                        $operator = $custom['condition']['operator'] ?? '===';

                        if ($field) {
                            $actualValue = data_get($row, $field);

                            switch ($operator) {
                                case '===': $displayButton = ($actualValue === $expectedValue); break;
                                case '==': $displayButton = ($actualValue == $expectedValue); break;
                                case '!==': $displayButton = ($actualValue !== $expectedValue); break;
                                case '!=': $displayButton = ($actualValue != $expectedValue); break;
                                case '>': $displayButton = ($actualValue > $expectedValue); break;
                                case '<': $displayButton = ($actualValue < $expectedValue); break;
                                case '>=': $displayButton = ($actualValue >= $expectedValue); break;
                                case '<=': $displayButton = ($actualValue <= $expectedValue); break;
                                default: $displayButton = false; // Operador no reconocido
                            }
                        } else {
                            $displayButton = false; // Condición mal configurada
                        }
                    }
                ?>
                
<!--
    Custom Button Debug for row ID: <?php echo e($row->{$keyName ?? 'id'} ?? 'ID_NOT_FOUND'); ?>

    --------------------------------------------------
    Button Config: <?php echo e(json_encode($custom)); ?>

    Display Logic:
        displayButton Variable: <?php echo e($displayButton ? 'TRUE' : 'FALSE'); ?>

    Condition Details:
        Field to check: <?php echo e($custom['condition']['field'] ?? 'N/A'); ?>

        Operator: <?php echo e($custom['condition']['operator'] ?? 'N/A'); ?>

        Expected Value: <?php echo e(var_export($custom['condition']['value'] ?? null, true)); ?>

    Row Data:
        Actual Value for '<?php echo e($custom['condition']['field'] ?? 'N/A'); ?>': <?php echo e(var_export($actualValue ?? null, true)); ?>

        Full Row estado_id (if exists): <?php echo e($row->estado_id ?? 'NOT_SET'); ?>

    KeyName being used: '<?php echo e($keyName ?? 'id'); ?>'
-->

                <?php if($displayButton): ?>
                    <?php
                        $elementType = $custom['element_type'] ?? 'a'; // 'a' por defecto, puede ser 'button'
                        $defaultClass = 'art-btn-outline-tertiary text-xs px-2 py-1'; // Clase por defecto más específica
                        $finalClass = $custom['class'] ?? $defaultClass;
                        $title = $custom['title'] ?? '';
                        $icon = $custom['icon'] ?? null; // Para data-lucide o clase de icono FontAwesome
                        $label = $custom['label'] ?? '';
                        $currentId = $row->{$keyName ?? 'id'};

                        // Atributos HTML
                        $htmlAttributes = '';
                        $customAttributes = $custom['attributes'] ?? [];
                        // Añadir data-id por defecto para botones si no está en attributes
                        if ($elementType === 'button' && !isset($customAttributes['data-id'])) {
                            $customAttributes['data-id'] = $currentId;
                        }

                        foreach ($customAttributes as $attrKey => $attrValue) {
                            // Reemplazar placeholders como {id} o {field_name}
                            $attrValue = preg_replace_callback('/\{([a-zA-Z0-9_.]+)\}/', function($matches) use ($row, $currentId) {
                                $placeholder = $matches[1];
                                if ($placeholder === 'id') return $currentId;
                                $fieldParts = explode('.', $placeholder);
                                $value = $row;
                                foreach ($fieldParts as $part) {
                                    if (is_object($value) && property_exists($value, $part)) $value = $value->{$part};
                                    elseif (is_array($value) && isset($value[$part])) $value = $value[$part];
                                    else return $matches[0]; // Placeholder no encontrado, devolver original
                                }
                                return e($value);
                            }, $attrValue);
                            $htmlAttributes .= ' ' . e($attrKey) . '="' . e($attrValue) . '"';
                        }

                        $href = '#';
                        if ($elementType === 'a') {
                            if (isset($custom['route'])) {
                                $routeParamValue = $row->{$custom['route_param_key'] ?? ($keyName ?? 'id')};
                                $href = route($custom['route'], $routeParamValue);
                            } elseif (isset($custom['href'])) {
                                $href = $custom['href']; // Aquí también se podrían reemplazar placeholders si es necesario
                            }
                        }

                        // Procesar la directiva Alpine.js para @click.prevent
                        $alpineClickExpression = null;
                        if (isset($custom['alpine']['click']['prevent'])) {
                            $preventStringTemplate = $custom['alpine']['click']['prevent'];

                            $processedPreventString = preg_replace_callback('/\{([a-zA-Z0-9_.]+)\}/', function($matches) use ($row, $currentId) {
                                $placeholder = $matches[1];
                                $valueToReplace = null;
                                $found = false;

                                if ($placeholder === 'id') {
                                    $valueToReplace = $currentId;
                                    $found = true;
                                } else {
                                    // Acceso a propiedades directas o anidadas de $row
                                    $keys = explode('.', $placeholder);
                                    
                                    $tempValue = $row;
                                    
                                    $possible = true;
                                    foreach ($keys as $key) {
                                        if (is_object($tempValue) && isset($tempValue->{$key})) {
                                            $tempValue = $tempValue->{$key};
                                        } elseif (is_array($tempValue) && array_key_exists($key, $tempValue)) {
                                            $tempValue = $tempValue[$key];
                                        } else {
                                            $possible = false;
                                            break;
                                        }
                                    }
                                    if ($possible) {
                                        $valueToReplace = $tempValue;
                                        $found = true;
                                    }
                                }

                                if ($found) {
                                    if (is_string($valueToReplace)) {
                                        // Escapar para que sea seguro dentro de una cadena JS.
                                        // La cadena prevent es como: "funcion('param1', 'param2={valor}')"
                                        // El {valor} se reemplaza aquí. Si es una cadena, necesita ser escapada
                                        // para que la cadena JS externa siga siendo válida.
                                        return addslashes(rawurlencode($valueToReplace));
                                    } elseif (is_numeric($valueToReplace)) {
                                        return $valueToReplace; // Los números no necesitan comillas ni ser escapados como cadenas JS
                                    } elseif (is_bool($valueToReplace)) {
                                        return $valueToReplace ? 'true' : 'false'; // Booleanos como literales JS
                                    } elseif (is_null($valueToReplace)) {
                                        return ''; 
                                    }
                                    // Fallback: convertir a cadena, codificar para URL, escapar para JS
                                    return addslashes(rawurlencode((string)$valueToReplace));
                                }
                                return $matches[0]; // Placeholder no encontrado, devolver original
                            }, $preventStringTemplate);

                            $alpineClickExpression = $processedPreventString; // Esta es la expresión JS completa
                        }
                    ?>
                    <!-- DEBUG Alpine Click Expression: <?php echo e($alpineClickExpression ?? 'NOT_SET'); ?> -->
                    <!-- DEBUG Row Data for this button: <?php echo e(json_encode($row)); ?> -->
                    <?php if($elementType === 'a'): ?>
                        <a href="<?php echo e($href); ?>"
                           <?php if($alpineClickExpression): ?> @click.prevent="<?php echo e($alpineClickExpression); ?>" <?php endif; ?>
                           class="<?php echo e($finalClass); ?>"
                           title="<?php echo e($title); ?>"
                           <?php echo $htmlAttributes; ?>>
                            <?php if($icon): ?><i class="<?php echo e(strpos($icon, 'fa-') === false && strpos($icon, 'lucide-') === false ? 'lucide lucide-' : ''); ?><?php echo e($icon); ?> <?php echo e($label ? 'mr-1' : ''); ?>"></i><?php endif; ?>
                            <?php echo e($label); ?>

                        </a>
                    <?php else: ?> 
                        <button type="button"
                                <?php if($alpineClickExpression): ?> @click.prevent="<?php echo e($alpineClickExpression); ?>" <?php endif; ?>
                                class="<?php echo e($finalClass); ?>"
                                title="<?php echo e($title); ?>"
                                <?php echo $htmlAttributes; ?>>
                            <?php if($icon): ?><i class="<?php echo e(strpos($icon, 'fa-') === false && strpos($icon, 'lucide-') === false ? 'lucide lucide-' : ''); ?><?php echo e($icon); ?> <?php echo e($label ? 'mr-1' : ''); ?>"></i><?php endif; ?>
                            <?php echo e($label); ?>

                        </button>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/components/datatable-actions.blade.php ENDPATH**/ ?>