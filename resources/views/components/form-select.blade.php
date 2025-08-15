{{-- resources/views/components/form-select.blade.php --}}
@props([
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
    'value' => '',
    'attributes' => null,
    'selected' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'populateFields' => [],
    
    // Nuevas props para el Form Group
    'elemGroupType' => null,
    'elemGroupContent' => null,
    'elemGroupClass' => '',
    'elemGroupEvent' => null,
    'elemGroupTitle' => ''
])

<div>
    <label for="{{ $id }}" class="art-label-custom">
        {{ $label }}
        @if($required) <span class="text-red-500">*</span> @endif
    </label>

    <div @if($elemGroupType) class="flex items-end mt-1" @endif>
        <select
            name="{{ $name }}"
            id="{{ $id }}"
            {{ $attributes->merge([
                // Ajuste de clases aquí
                'class' => 'art-select-custom h-10 ' . ($elemGroupType ? 'rounded-r-none border-r-0' : '')
            ]) }}
            data-table="{{ $table }}"
            data-value-field="{{ $valueField }}"
            data-label-field="{{ $labelField }}"
            data-placeholder="{{ $placeholder }}"
            data-where="{{ json_encode($where) }}"
            data-order-by="{{ json_encode($orderBy) }}"
            data-parent-id-field="{{ is_array($parentIdField) ? json_encode($parentIdField) : $parentIdField }}"
            data-initial-value="{{ $value }}"
            data-target-value=""
            data-options-loaded="false"
            @if(!empty($populateFields))
                data-populate-fields="{{ json_encode($populateFields) }}"
            @endif
            @disabled($disabled)
            @readonly($readonly)
            @required($required)
        >
            @if($placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif
            {{-- Opciones se cargan vía JS --}}
        </select>
        
        @if($elemGroupType)
            @php
                $baseClass = 'inline-flex items-center justify-center px-3 border border-gray-700 bg-gray-300 text-gray-800 h-10';
                $finalClass = $baseClass . ' ' . $elemGroupClass;
            @endphp
            
            @if($elemGroupType === 'button')
                <button type="button" class="{{ $finalClass }} rounded-r-md -ml-px"
                        @if($elemGroupEvent) @click.prevent="{{ $elemGroupEvent }}" @endif
                        title="{{ $elemGroupTitle }}">
                    {!! $elemGroupContent !!}
                </button>
            @elseif($elemGroupType === 'anchor')
                <a href="{{ $elemGroupContent }}" class="{{ $finalClass }} rounded-r-md -ml-px"
                   @if($elemGroupEvent) @click.prevent="{{ $elemGroupEvent }}" @endif
                   title="{{ $elemGroupTitle }}">
                    {!! $elemGroupContent !!}
                </a>
            @elseif($elemGroupType === 'icon' || $elemGroupType === 'text')
                <span class="{{ $finalClass }} rounded-r-md -ml-px">
                    {!! $elemGroupContent !!}
                </span>
            @endif
        @endif
    </div>
</div>