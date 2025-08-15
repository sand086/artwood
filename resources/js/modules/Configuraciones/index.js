const config = {
    moduleName: 'Configuraciones',
    baseUrl: '/configuraciones/',
    idField: 'configuracion_id',
    formFields: ['nombre', 'clave', 'valor', 'tipo_dato', 'fecha_inicio_vigencia', 'fecha_fin_vigencia', 'descripcion'],
    moduleForm: 'configuracionesForm',
    moduleTable: 'configuracionesTable',
    moduleModal: 'configuracionesModal',
    columns: [
        { data: 'nombre', name: 'nombre', title: 'Nombre' },
            { data: 'clave', name: 'clave', title: 'Clave' },
            { data: 'valor', name: 'valor', title: 'Valor' },
            { data: 'tipo_dato', name: 'tipo_dato', title: 'Tipo Dato' },
            { data: 'fecha_inicio_vigencia', name: 'fecha_inicio_vigencia', title: 'Fecha Inicio Vigencia' },
            { data: 'fecha_fin_vigencia', name: 'fecha_fin_vigencia', title: 'Fecha Fin Vigencia' },
            { data: 'descripcion', name: 'descripcion', title: 'Descripcion' },
            { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
            { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
            
    ],
};

const configuracionesModule = new BaseModule(config);
configuracionesModule.init();