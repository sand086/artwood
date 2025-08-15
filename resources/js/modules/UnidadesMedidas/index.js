const config = {
    moduleName: "UnidadesMedidas",
    baseUrl: "/unidadesmedidas/",
    idField: "unidad_medida_id",
    formFields: ["nombre", 'categoria', 'simbolo', 'estado'],
    moduleForm: "unidadesmedidasForm",
    moduleTable: "unidadesmedidasTable",
    moduleModal: "unidadesmedidasModal",
    columns: [
        { data: "nombre", name: "nombre", title: "Nombre" },
        { data: "categoria", name: "categoria", title: "Categoria" },
        { data: "simbolo", name: "simbolo", title: "Simbolo" },
        {
            data: "estado",
            name: "estado",
            title: "Estado",
            render: "renderEstado",
            className: "text-center align-middle",
            headerClass: "text-center",
        },
        {
            data: "action",
            name: "action",
            title: "Acciones",
            orderable: false,
            searchable: false,
            className: "text-center align-middle",
            headerClass: "text-center",
        },
    ],
};

const unidadesmedidasModule = new BaseModule(config);
unidadesmedidasModule.init();
