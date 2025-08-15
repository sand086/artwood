const configPA = {
    moduleName: 'ProcesosActividades',
    baseUrl: '/procesosactividades/',
    idField: 'proceso_actividad_id',
    formFields: ['nombre', 'descripcion', 'proceso_id', 'area_id', 'unidad_medida_id', 'tiempo_estimado', 'costo_estimado', 'riesgos', 'observaciones', 'estado'],
    moduleForm: 'procesosactividadesForm',
    moduleTable: 'procesosactividadesTable',
    // moduleModal: 'procesosactividadesModal', 
    moduleModal: 'procesosModal', // 'procesosactividadesModal',
    parentIdField: 'proceso_id',  // ID del padre del modulo cuando es una pestaña
    closeModalOnSave: false,  // Determina si se cierra el modal al guardar
    resetFormOnSave: true,  // Determina si se reinicia el formulario al guardar
    targetTab: 'actividades', // Nombre de la pestaña a la que se redirige despues de un evento
    formIsInModal: false, // Determina si el formulario está dentro de un modal
    showFormEventName: 'show-form-actividad',  // Nombre del evento para mostrar el formulario
    hideFormEventName: 'hide-form-actividad',
    columns: [
        { data: 'nombre', name: 'nombre', title: 'Nombre' },
            { data: 'descripcion', name: 'descripcion', title: 'Descripcion' },
            { data: 'proceso_nombre', name: 'proceso_nombre', title: 'Proceso' },
            { data: 'area_nombre', name: 'area_nombre', title: 'Area' },
            { data: 'unidad_medida_nombre', name: 'unidad_medida_nombre', title: 'Unidad Tiempo' },
            { data: 'tiempo_estimado', name: 'tiempo_estimado', title: 'Tiempo Estimado' },
            { data: 'costo_estimado', name: 'costo_estimado', title: 'Costo Estimado' },
            // { data: 'riesgos', name: 'riesgos', title: 'Riesgos' },
            // { data: 'observaciones', name: 'observaciones', title: 'Observaciones' },
            { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
            { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
            
    ],
    onEditSuccess: (data) => {
        // Aquí defines qué pasa en tu interfaz al cargar los datos
        // mostrarFormContacto = true;  // Mostrar el formulario
        // document.querySelector('#actividades-panel').__x.$data.mostrarFormContacto = true;
        // document.getElementById('proveedoresactividadesTable').closest('div[x-show]').__x.$data.mostrarFormContacto = true;
        // También podrías cambiar de pestaña si aplica
        // tab = 'actividades';
        window.dispatchEvent(new CustomEvent('show-form-actividad'));
    },
};

const procesosactividadesModule = new BaseModule(configPA);
procesosactividadesModule.init();