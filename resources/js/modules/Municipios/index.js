const config = {
    moduleName: "Municipios",
    baseUrl: "/municipios/",
    idField: "municipio_id",
    formFields: ["nombre", "codigo_postal", "estado_pais_id"],
    moduleForm: "municipiosForm",
    moduleTable: "municipiosTable",
    moduleModal: "municipiosModal",
    columns: [
        { data: "nombre", name: "nombre", title: "Nombre" },
        {
            data: "codigo_postal",
            name: "codigo_postal",
            title: "Codigo Postal",
        },
        {
            data: "estado_pais_nombre",
            name: "estado_pais_nombre",
            title: "Estado Pais",
        },
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

const municipiosModule = new BaseModule(config);
municipiosModule.init();
