const config = {
    moduleName: "Usuarios",
    baseUrl: "/usuarios/",
    idField: "usuario_id",
    formFields: [
        "nombre", // Alias del usuario
        "role_id", // Rol
        "nombres", // Nombres de la persona
        "apellidos", // Apellidos de la persona
        "telefono",
        "email",
        "direccion",
    ],
    moduleForm: "usuariosForm",
    moduleTable: "usuariosTable",
    moduleModal: "usuariosModal",

    columns: [
        { data: "persona_nombres", name: "persona_nombres", title: "Nombres" },
        {
            data: "persona_apellidos",
            name: "persona_apellidos",
            title: "Apellidos",
        },
        { data: "nombre", name: "nombre", title: "Alias" },
        {
            data: "role_nombre",
            name: "role_nombre",
            title: "Rol",
            className: "text-center align-middle",
            headerClass: "text-center",
        },
        {
            data: "metodo_doble_factor",
            name: "metodo_doble_factor",
            title: "Método 2FA",
        },
        {
            data: "no_intentos",
            name: "no_intentos",
            title: "Intentos",
            type: "string",
            className: "text-center align-middle",
            headerClass: "text-center",
        },
        {
            data: "fecha_ultimo_acceso",
            name: "fecha_ultimo_acceso",
            title: "Último Acceso",
            render: "formatearFechaSinSegundos",
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

const usuariosModule = new BaseModule(config);
usuariosModule.init();
