import '../ProcesosActividades/index.js';

const config = {
    moduleName: 'Procesos',
    baseUrl: '/procesos/',
    idField: 'proceso_id',
    formFields: ['nombre', 'descripcion', 'presupuesto_estimado', 'fecha_estimada', 'comentarios', 'estado'],
    moduleForm: 'procesosForm',
    moduleTable: 'procesosTable',
    moduleModal: 'procesosModal',
    closeModalOnSave: true,
    resetFormOnSave: false,
    targetTab: 'basicos',
    columns: [
        { data: 'nombre', name: 'nombre', title: 'Nombre' },
            { data: 'descripcion', name: 'descripcion', title: 'Descripcion' },
            { data: 'presupuesto_estimado', name: 'presupuesto_estimado', title: 'Presupuesto Estimado' },
            { data: 'fecha_estimada', name: 'fecha_estimada', title: 'Fecha Estimada' },
            { data: 'comentarios', name: 'comentarios', title: 'Comentarios' },
            { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
            { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
            
    ],
};

const procesosModule = new BaseModule(config);
procesosModule.init();