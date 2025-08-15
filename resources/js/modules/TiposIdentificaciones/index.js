const config = {
    moduleName: 'TiposIdentificaciones',
    baseUrl: '/tiposidentificaciones/',
    idField: 'tipo_identificacion_id',
    formFields: ['nombre', 'descripcion'],
    moduleForm: 'tiposidentificacionesForm',
    moduleTable: 'tiposidentificacionesTable',
    moduleModal: 'tiposidentificacionesModal',
    columns: [
        { data: 'nombre', name: 'nombre', title: 'Nombre' },
            { data: 'descripcion', name: 'descripcion', title: 'Descripcion' },
            { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
            { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
            
    ],
};

const tiposidentificacionesModule = new BaseModule(config);
tiposidentificacionesModule.init();