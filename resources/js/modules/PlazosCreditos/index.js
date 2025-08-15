const config = {
    moduleName: 'PlazosCreditos',
    baseUrl: '/plazoscreditos/',
    idField: 'plazo_credito_id',
    formFields: ['nombre'],
    moduleForm: 'plazoscreditosForm',
    moduleTable: 'plazoscreditosTable',
    moduleModal: 'plazoscreditosModal',
    columns: [
        { data: 'nombre', name: 'nombre', title: 'Nombre' },
        { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
        { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
            
    ],
};

const plazoscreditosModule = new BaseModule(config);
plazoscreditosModule.init();