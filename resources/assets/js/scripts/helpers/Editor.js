import Exception from "../libs/Exception";

export default class Editor {

    static create(selector = 'textarea', params = null) {
        let defaultParams = {
            selector: selector,
            menubar: false,
            toolbar: [
                'tools undo redo | cut copy paste | indent outdent | link table image media | forecolor backcolor | fullscreen',
                'formatselect  |  alignleft aligncenter alignright alignjustify |    bold italic underline strikethrough removeformat | blockquote hr'
            ],
            plugins: 'link hr paste fullscreen image media table emoticons preview',
            height: 250,
            block_formats: 'Paragraphe=p;Titre 1=h1;Titre 2=h2;Titre 3=h3;Titre 4=h4;'
        };

        for (let prop in params) {
            if (params.hasOwnProperty(prop)) {
                defaultParams[prop] =  params[prop];
            }
        }

        if (defaultParams.selector == null) {
            throw new Exception("selector cannot be null.");
        }

        tinymce.init(defaultParams);
    }

    static remove(selector) {
        tinymce.remove(selector);
    }

    static getActiveEditorContent() {
        return Editor.getActiveEditor().getContent();
    }

    static getActiveEditor()
    {
        return tinymce.activeEditor;
    }

    static createUnique(selector, params = null) {
        Editor.remove(selector);
        Editor.create(selector, params);
    }

    static prepare(el, params = null)
    {
        if(el == null || el.length === 0)
            return;

        if(Array.isArray(el))
        {
            Editor.prepareArray(el, params);
        }

        const id = el.attr('id');
        Editor.create('#' + id, params);
    }

    static prepareArray(array, params = null)
    {
        for(let i = 0; i < array.length; i++)
        {
            Editor.prepare($(array[i]), params);
        }
    }
}