const config = {
    moduleName: 'Areas',
    baseUrl: '/areas/',
    idField: 'area_id',
    formFields: ['nombre', 'descripcion', 'estado'],
    moduleForm: 'areasForm',
    moduleTable: 'areasTable',
    moduleModal: 'areasModal',
    columns: [
        { data: 'nombre', name: 'nombre', title: 'Nombre' },
            { data: 'descripcion', name: 'descripcion', title: 'Descripcion' },
            { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
            { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
            
    ],
};

const areasModule = new BaseModule(config);
areasModule.init();