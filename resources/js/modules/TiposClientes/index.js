const config = {
    moduleName: 'TiposClientes',
    baseUrl: '/tiposclientes/',
    idField: 'tipo_cliente_id',
    formFields: ['nombre', 'descripcion'],
    moduleForm: 'tiposclientesForm',
    moduleTable: 'tiposclientesTable',
    moduleModal: 'tiposclientesModal',
    columns: [
        { data: 'nombre', name: 'nombre', title: 'Nombre' },
        { data: 'descripcion', name: 'descripcion', title: 'Descripcion' },
        { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
        { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
            
    ],
};

const tiposclientesModule = new BaseModule(config);
tiposclientesModule.init();