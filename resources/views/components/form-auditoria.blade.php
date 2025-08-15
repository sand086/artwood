@props([
    'showUser'       => false,       // Controla si se muestran los campos 'Creado por' y 'Modificado por'
    'showTimestamps' => true,        // Controla si se muestran las fechas 'Fecha Creación' y 'Fecha Modificación'
    'showStatus'     => true,        // Controla si se muestra el campo 'Estado'
])
<hr class="my-2 border-gray-200">

{{-- Contenedor con fondo, sombra y padding --}}
<div class="bg-white p-4 rounded-lg shadow-sm">
  {{-- Usamos una grilla responsive de 12 columnas --}}
  <div class="grid grid-cols-12 gap-4">

    @if($showTimestamps)
      {{-- Fecha de Registro --}}
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
            value="{{ $fechaRegistro }}"
          >
        </div>
      </div>

      {{-- Fecha de Actualización --}}
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
            value="{{ $fechaActualizacion }}"
          >
        </div>
      </div>
    @endif

    @if($showStatus)
      {{-- Estado --}}
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
            value="{{ $estadoTexto }}"
          >
          <input type="hidden" name="estado" value="{{ $estado }}">
        </div>
      </div>
    @endif

    @if($showUser)
      {{-- Usuario --}}
      <div class="col-span-12 md:col-span-12 lg:col-span-6">
        <label for="usuario_nombre_display" class="art-label-custom">Usuario</label>
        <div class="flex mt-1">
          <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-100 text-gray-600 text-sm">
            <i data-lucide="user" class="w-4 h-4"></i>
          </span>
          {{-- Usamos auth()->check() para asegurarnos que hay un usuario logueado --}}
          @if(Auth::guard('api')->check())
            {{-- Campo de texto para mostrar el nombre, no editable --}}
            <input
              type="text"
              id="usuario_nombre_display"
              name="usuario_nombre_display"
              disabled
              class="flex-1 block w-full rounded-none rounded-r-md art-input-custom bg-gray-50 text-gray-700 text-sm
                     cursor-not-allowed"
              {{-- Accede al nombre del usuario logueado. Ajusta 'nombre' si el campo se llama diferente en tu modelo User --}}
              value="{{ Auth::guard('api')->user()->nombre ?? 'Usuario no encontrado' }}"
            >
            {{-- Campo oculto para enviar el ID del usuario logueado si es necesario --}}
            {{-- Ajusta 'id' si la clave primaria de tu modelo User es diferente (ej. 'usuario_id') --}}
            {{-- El 'name' sigue siendo 'usuario_id' como en tu select original, asumiendo que eso es lo que espera tu backend --}}
            <input type="hidden" id="usuario_id" name="usuario_id" value="{{ Auth::guard('api')->user()->id }}">
          @else
            {{-- Qué mostrar si no hay usuario logueado (poco probable en secciones de auditoría) --}}
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
          @endif
        </div>
      </div>
    @endif

  </div>
</div>
