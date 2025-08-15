const config = {
    moduleName: 'Gastos',
    baseUrl: '/gastos/',
    idField: 'gasto_id',
    formFields: ['nombre', 'tipo_gasto_id', 'unidad_medida_id', 'valor_unidad', 'cantidad', 'valor_total', 'usuario_id'],
    moduleForm: 'gastosForm',
    moduleTable: 'gastosTable',
    moduleModal: 'gastosModal',
    columns: [
        { data: 'nombre', name: 'nombre', title: 'Nombre' },
            { data: 'tipo_gasto_id', name: 'tipo_gasto_id', visible: false },
            { data: 'tipo_gasto_nombre', name: 'tipo_gasto_nombre', title: 'Tipo Gasto' },
            { data: 'unidad_medida_id', name: 'unidad_medida_id', visible: false },
            { data: 'unidad_medida_nombre', name: 'unidad_medida_nombre', title: 'Unidad Medida' },
            { data: 'valor_unidad', name: 'valor_unidad', title: 'Valor Unidad' },
            { data: 'cantidad', name: 'cantidad', title: 'Cantidad' },
            { data: 'valor_total', name: 'valor_total', title: 'Valor Total' },
            { data: 'usuario_id', name: 'usuario_id', title: 'Usuario', visible: false },
            { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
            { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
            
    ],
};

const gastosModule = new BaseModule(config);
gastosModule.init();