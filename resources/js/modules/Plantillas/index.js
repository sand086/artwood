import { render } from "nprogress";
import { EditorView, basicSetup } from "@codemirror/basic-setup";
import { html } from "@codemirror/lang-html";

const config = {
    moduleName: 'Plantillas',
    baseUrl: '/plantillas/',
    idField: 'plantilla_id',
    formFields: ['nombre', 'clave', 'modulo', 'formato', 'tipo', 'origen_datos', 'fuente_datos', 'html'],
    moduleForm: 'plantillasForm',
    moduleTable: 'plantillasTable',
    moduleModal: 'plantillasModal',
    columns: [
        { data: 'nombre', name: 'nombre', title: 'Nombre' },
        { data: 'clave', name: 'clave', title: 'Clave' },
        { data: 'tipo', name: 'tipo', title: 'Tipo' },
        // { data: 'html', name: 'html', title: 'Html' },
        { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
        { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }  
    ],
};

const plantillasModule = new BaseModule(config);
plantillasModule.init();

let editor;

window.initEditor = function () {
    const textarea  = document.querySelector("#html");
    const editorDiv = document.querySelector("#editor_contenido");
console.info('initEditor');
    if (!textarea || !editorDiv) {
        console.warn("No se encontró textarea o editorDiv");
        return;
    }

    requestAnimationFrame(() => {
        if (editor) {
            editor.destroy();
            editor = null;
            editorDiv.innerHTML = '';
        }
        console.info('Antes de EditorView');
        editor = new EditorView({
            doc: textarea.value ?? '',
            extensions: [basicSetup, html()],
            parent: editorDiv,
            dispatch: (tr) => {
                editor.update([tr]);
                textarea.value = editor.state.doc.toString();
            },
        });
    });
}

document.addEventListener('alpine:init', () => {
    Alpine.data('modalEditorWatcher', () => ({
        initWatcher() {
            const modal = document.getElementById(config.moduleModal);

            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (
                        mutation.attributeName === 'class' &&
                        modal.classList.contains('open') // O la clase que indica que está visible
                    ) {
                        console.log('🟢 Modal visible, inicializando editor...');
                        this.$nextTick(() => window.initEditor && window.initEditor());
                    }
                });
            });

            observer.observe(modal, { attributes: true });
        }
    }));
});

