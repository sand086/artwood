const config = {
    moduleName: 'CotizacionesResponsables',
    baseUrl: '/cotizacionesresponsables/',
    idField: 'cotizacion_responsable_id',
    formFields: ['cotizacion_solicitud_id', 'empleado_id', 'area_id', 'responsabilidad', 'estado'],
    moduleForm: 'cotizacionesresponsablesForm',
    moduleTable: 'cotizacionesresponsablesTable',
    moduleModal: 'cotizacionessolicitudesModal', // 'cotizacionesresponsablesModal',
    parentIdField: 'cotizacion_solicitud_id',  // ID del padre del modulo cuando es una pestaña
    closeModalOnSave: false,  // Determina si se cierra el modal al guardar
    resetFormOnSave: true,  // Determina si se reinicia el formulario al guardar
    targetTab: 'responsables', // Nombre de la pestaña a la que se redirige despues de un evento
    formIsInModal: false, // Determina si el formulario está dentro de un modal
    showFormEventName: 'show-form-responsable',  // Nombre del evento para mostrar el formulario
    hideFormEventName: 'hide-form-responsable',
    columns: [
        { data: 'empleado_nombre_completo', name: 'empleado_nombre_completo', title: 'Responsable' },
        { data: 'area_nombre', name: 'area_nombre', title: 'Area' },
        { data: 'responsabilidad', name: 'responsabilidad', title: 'Responsabilidad' },
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
        window.dispatchEvent(new CustomEvent('show-form-responsable'));
    },
};

const cotizacionesresponsablesModule = new BaseModule(config);
cotizacionesresponsablesModule.init();