{{--
Vista parcial para mostrar los detalles de un proveedor en un modal.
--}}
<div class="space-y-4">
    <div>
        <h4 class="text-lg font-bold text-gray-800">{{ $proveedor->nombre }}</h4>
        <p class="text-sm text-gray-500">{{ $proveedor->rfc }}</p>
    </div>

    <div class="border-t border-gray-200 pt-4">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2">
            <div class="col-span-1">
                <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $proveedor->direccion ?: 'No especificada' }}</dd>
            </div>
            <div class="col-span-1">
                <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $proveedor->telefono ?: 'No especificado' }}</dd>
            </div>
        </dl>
    </div>

    @if($proveedor->contactos->isNotEmpty())
        <div class="border-t border-gray-200 pt-4">
            <h5 class="text-md font-semibold mb-2 text-gray-700">Contactos</h5>
            <ul class="list-disc list-inside space-y-1">
                @foreach($proveedor->contactos as $contacto)
                    <li class="text-sm text-gray-800">{{ $contacto->persona->nombre_completo ?? 'Sin nombre' }} - <a href="mailto:{{ $contacto->correo_electronico }}" class="text-blue-600 hover:underline">{{ $contacto->correo_electronico }}</a></li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
