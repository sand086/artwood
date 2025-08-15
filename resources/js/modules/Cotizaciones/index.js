const config = {
    moduleName: 'Cotizaciones',
    baseUrl: '/cotizaciones/',
    idField: 'cotizacion_id',
    formFields: ['cotizacion_solicitud_id', 'cliente_contacto_id', 'empleado_responsable_id', 'plantilla_id', 'condiciones_comerciales', 'datos_adicionales'],
    moduleForm: 'cotizacionesForm',
    moduleTable: 'cotizacionesTable',
    moduleModal: 'cotizacionesModal',
    columns: [
        { data: 'consecutivo', name: 'consecutivo', title: 'Solicitud' },
        { data: 'contacto_nombre_completo', name: 'contacto_nombre_completo', title: 'Destinatario' },
        { data: 'plantilla_nombre', name: 'plantilla_nombre', title: 'Plantilla' },
        { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
        { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }            
    ],
};

const cotizacionesModule = new BaseModule(config);
cotizacionesModule.init();