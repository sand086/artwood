const config = {
    moduleName: 'Fuentes',
    baseUrl: '/fuentes/',
    idField: 'fuente_id',
    formFields: ['nombre', 'descripcion', 'estado'],
    moduleForm: 'fuentesForm',
    moduleTable: 'fuentesTable',
    moduleModal: 'fuentesModal',
    columns: [
        { data: 'nombre', name: 'nombre', title: 'Nombre' },
        { data: 'descripcion', name: 'descripcion', title: 'Descripcion' },
        { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
        { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
            
    ],
};

const fuentesModule = new BaseModule(config);
fuentesModule.init();