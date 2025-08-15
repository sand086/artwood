@php
    // Determinar si se definieron botones en la configuración.
    // Por ejemplo: edit, delete, custom.
    $hasButtons = (!empty($actionsConfig['edit']) && $actionsConfig['edit']) ||
        (!empty($actionsConfig['delete']) && $actionsConfig['delete']) ||
        (!empty($actionsConfig['custom']) && is_array($actionsConfig['custom']));

    if (!function_exists('buildRouteFromConfig')) {
        function buildRouteFromConfig($config, $row) {
            $params = [];

            if (!empty($config['routeParams']) && is_array($config['routeParams'])) {
                foreach ($config['routeParams'] as $key => $source) {
                    $params[$key] = is_numeric($source) || is_string($source) && !isset($row->$source)
                        ? $source
                        : $row->$source;
                }
            }

            return route($config['route'], $params);
        }
    }
@endphp

@if($hasButtons)
    <div class="action-buttons inline-flex rounded-lg shadow-2xs">
        {{-- Botón Editar --}}
        @if(!empty($actionsConfig['edit']) && $actionsConfig['edit'])
            {{-- @can('update', $row) --}}
            <button
                class="editar mr-2.5 inline-flex items-center gap-x-2 -ms-px first:rounded-s-lg first:ms-0 last:rounded-e-lg focus:z-10  bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900  dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 "
                data-id="{{ $row->{$keyName ?? 'id'} }}"
                data-url="{{ isset($module) ? route($module . '.edit', $row->{$keyName ?? 'id'}) : '#' }}">

                <img src="{{ asset('images/icons/crud/iconos_editar.svg') }}" alt="Editar" class="w-9" width="30">
            </button>
            {{-- @endcan --}}
        @endif

        {{-- Botón Eliminar --}}
        @if(!empty($actionsConfig['delete']) && $actionsConfig['delete'])
            {{-- @can('delete', $row) --}}
            <button data-id="{{ $row->{$keyName ?? 'id'} }}"
                data-url="{{ isset($module) ? route($module . '.destroy', $row->{$keyName ?? 'id'}) : '#' }}"
                class="eliminar inline-flex items-center gap-x-2 -ms-px first:rounded-s-lg first:ms-0 last:rounded-e-lg focus:z-10  bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900  dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                data-method="delete" data-confirm="¿Estás seguro?">
                <img src="{{ asset('images/icons/crud/iconos_eliminar.svg') }}" alt="Eliminar" class="w-9" width="30">

            </button>
            {{-- @endcan --}}
        @endif


        {{-- Botones Custom (opcional) --}}
        @if(!empty($actionsConfig['custom']) && is_array($actionsConfig['custom']))
            @foreach($actionsConfig['custom'] as $custom)
                @php
                    $displayButton = true; // Mostrar por defecto

                    // Lógica de Condición
                    if (isset($custom['condition']) && is_array($custom['condition'])) {
                        $result = null;
                        $conditions = $custom['condition']['conditions'] ?? [];
                        $compare = strtoupper($custom['condition']['compare'] ?? 'AND');

                        foreach ($conditions as $subCondition) {
                            $field = $subCondition['field'] ?? null;
                            $expectedValue = $subCondition['value'] ?? null;
                            $operator = $subCondition['operator'] ?? '===';

                            if (!$field) {
                                $currentResult = false;
                            } else {
                                $actualValue = data_get($row, $field);
                                $currentResult = false; // Valor por defecto

                                switch ($operator) {
                                    case '===': $currentResult = ($actualValue === $expectedValue); break;
                                    case '==': $currentResult = ($actualValue == $expectedValue); break;
                                    case '!==': $currentResult = ($actualValue !== $expectedValue); break;
                                    case '!=': $currentResult = ($actualValue != $expectedValue); break;
                                    case '>': $currentResult = ($actualValue > $expectedValue); break;
                                    case '<': $currentResult = ($actualValue < $expectedValue); break;
                                    case '>=': $currentResult = ($actualValue >= $expectedValue); break;
                                    case '<=': $currentResult = ($actualValue <= $expectedValue); break;
                                    case 'is_empty': $currentResult = empty($actualValue); break;
                                    case 'is_not_empty': $currentResult = !empty($actualValue); break;
                                    default: $currentResult = false; // Operador no reconocido
                                }
                            }
                            // var_dump("Evaluando condición: {$field} {$operator} {$expectedValue} => Resultado: " . ($currentResult ? 'true' : 'false'));
                            if ($result === null) {
                                $result = $currentResult;
                            } else {
                                if ($compare === 'OR') {
                                    $result = $result || $currentResult;
                                } else { // 'AND'
                                    $result = $result && $currentResult;
                                }
                            }
                        }
                        $displayButton = $result;
                    }
                @endphp

                @if($displayButton)
                    @php
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
                                $href = buildRouteFromConfig($custom, $row);
                            } elseif (isset($custom['href'])) {
                                $href = $custom['href'];
                            }
                            $target = $custom['target'] ?? '_self';
                            $rel = ($target === '_blank') ? 'noopener noreferrer' : null;
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
                    @endphp
                    <!-- DEBUG Alpine Click Expression: {{ $alpineClickExpression ?? 'NOT_SET' }} -->
                    <!-- DEBUG Row Data for this button: {{ json_encode($row) }} -->
                    @if($elementType === 'a')
                        <a href="{{ $href }}"
                           @if($alpineClickExpression) @click.prevent="{{ $alpineClickExpression }}" @endif
                           class="{{ $finalClass }}"
                           title="{{ $title }}"
                           {!! $htmlAttributes !!}
                           target="{{ $target }}"
                           @if($rel) rel="{{ $rel }}" @endif
                        >
                            @if($icon)
                                @php
                                    $iconType = $custom['iconType'] ?? 'lucide';
                                    $iconClassExtra = $label ? 'mr-1' : '';
                                    $iconClass = $custom['iconClass'] ?? '';
                                    $iconSize = $custom['iconSize'] ?? 'w-6';
                                    $iconWidth = $custom['iconWidth'] ?? null;
                                @endphp

                                @switch($iconType)
                                    @case('img')
                                        <img src="{{ asset($icon) }}"
                                            alt="{{ $title ?? $label }}"
                                            title="{{ $title ?? $label }}"
                                            class="inline-block {{ $iconSize }} {{ $iconClass }}"
                                            @if($iconWidth) width="{{ $iconWidth }}" @endif>
                                        @break

                                    @case('fa')
                                        <i class="fa {{ $icon }} {{ $iconClass }} {{ $iconClassExtra }}" title="{{ $title ?? '' }}"></i>
                                        @break

                                    @case('lucide')
                                        <i class="lucide lucide-{{ $icon }} {{ $iconClass }} {{ $iconClassExtra }}" title="{{ $title ?? '' }}"></i>
                                        @break

                                    @default
                                        <i class="{{ $icon }} {{ $iconClass }} {{ $iconClassExtra }}" title="{{ $title ?? '' }}"></i>
                                @endswitch
                            @endif
                            {{ $label }}
                        </a>
                    @else {{-- 'button' --}}
                        <button type="button"
                                @if($alpineClickExpression) @click.prevent="{{ $alpineClickExpression }}" @endif
                                class="{{ $finalClass }}"
                                title="{{ $title }}"
                                {!! $htmlAttributes !!}>
                            @if($icon)
                                @php
                                    $iconType = $custom['iconType'] ?? 'lucide';
                                    $iconClassExtra = $label ? 'mr-1' : '';
                                    $iconClass = $custom['iconClass'] ?? '';
                                    $iconSize = $custom['iconSize'] ?? 'w-6';
                                    $iconWidth = $custom['iconWidth'] ?? null;
                                @endphp

                                @switch($iconType)
                                    @case('img')
                                        <img src="{{ asset($icon) }}"
                                            alt="{{ $title ?? $label }}"
                                            title="{{ $title ?? $label }}"
                                            class="inline-block {{ $iconSize }} {{ $iconClass }}"
                                            @if($iconWidth) width="{{ $iconWidth }}" @endif>
                                        @break

                                    @case('fa')
                                        <i class="fa {{ $icon }} {{ $iconClass }} {{ $iconClassExtra }}" title="{{ $title ?? '' }}"></i>
                                        @break

                                    @case('lucide')
                                        <i class="lucide lucide-{{ $icon }} {{ $iconClass }} {{ $iconClassExtra }}" title="{{ $title ?? '' }}"></i>
                                        @break

                                    @default
                                        <i class="{{ $icon }} {{ $iconClass }} {{ $iconClassExtra }}" title="{{ $title ?? '' }}"></i>
                                @endswitch
                            @endif
                            {{ $label }}
                        </button>
                    @endif
                @endif
            @endforeach
        @endif
    </div>
@endif
