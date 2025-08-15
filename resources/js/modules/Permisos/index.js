const config = {
    moduleName: "Permisos",
    baseUrl: "/permisos/",
    idField: "permission_id",
    // Campos asignables según el modelo Permisos
    formFields: ["name", "guard_name", "descripcion"],
    moduleForm: "permisosForm",
    moduleTable: "permisosTable",
    moduleModal: "permisosModal",
    // Columnas a mostrar en el DataTable
    columns: [
        { data: "permission_id", name: "permission_id", title: "ID" },
        { data: "name", name: "name", title: "name" },
        { data: "guard_name", name: "guard_name", title: "Guard Name" },
        { data: "descripcion", name: "descripcion", title: "Descripción" },
        {
            data: "estado",
            name: "estado",
            title: "Estado",
            render: "renderEstado",
            orderable: false,
            searchable: false,
        },
        {
            data: "action",
            name: "action",
            title: "Acciones",
            orderable: false,
            searchable: false,
        },
    ],
};

const PermisosModule = new BaseModule(config);
PermisosModule.init();
