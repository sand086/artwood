const config = {
    moduleName: 'TiposProyectos',
    baseUrl: '/tiposproyectos/',
    idField: 'tipo_proyecto_id',
    formFields: ['nombre', 'descripcion'],
    moduleForm: 'tiposproyectosForm',
    moduleTable: 'tiposproyectosTable',
    moduleModal: 'tiposproyectosModal',
    columns: [
        { data: 'nombre', name: 'nombre', title: 'Nombre' },
            { data: 'descripcion', name: 'descripcion', title: 'Descripcion' },
            { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
            { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
            
    ],
};

const tiposproyectosModule = new BaseModule(config);
tiposproyectosModule.init();