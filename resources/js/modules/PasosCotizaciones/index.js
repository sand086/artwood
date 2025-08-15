const config = {
    moduleName: 'PasosCotizaciones',
    baseUrl: '/pasoscotizaciones/',
    idField: 'paso_cotizacion_id',
    formFields: ['nombre', 'descripcion', 'tipo_cliente_id', 'orden'],
    moduleForm: 'pasoscotizacionesForm',
    moduleTable: 'pasoscotizacionesTable',
    moduleModal: 'pasoscotizacionesModal',
    columns: [
        { data: 'nombre', name: 'nombre', title: 'Nombre' },
            { data: 'descripcion', name: 'descripcion', title: 'Descripcion' },
            { data: 'tipo_cliente_id', name: 'tipo_cliente_id', visible: false },
            { data: 'tipo_cliente_nombre', name: 'tipo_cliente_nombre', title: 'Tipo Cliente' },
            { data: 'orden', name: 'orden', title: 'Orden' },
            { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
            { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
            
    ],
};

const pasoscotizacionesModule = new BaseModule(config);
pasoscotizacionesModule.init();