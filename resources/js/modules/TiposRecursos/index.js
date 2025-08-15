const config = {
    moduleName: 'TiposRecursos',
    baseUrl: '/tiposrecursos/',
    idField: 'tipo_recurso_id',
    formFields: ['nombre', 'descripcion', 'tabla_referencia', 'estado'],
    moduleForm: 'tiposrecursosForm',
    moduleTable: 'tiposrecursosTable',
    moduleModal: 'tiposrecursosModal',
    columns: [
        { data: 'nombre', name: 'nombre', title: 'Nombre' },
        { data: 'tabla_referencia', name: 'tabla_referencia', title: 'Tabla Referencia' },
        { data: 'descripcion', name: 'descripcion', title: 'Descripcion' },
        { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
        { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
    ],
};

const tiposrecursosModule = new BaseModule(config);
tiposrecursosModule.init();