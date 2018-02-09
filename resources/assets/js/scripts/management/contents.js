import Content from "../models/Content";
import Editor from "../helpers/Editor";
import Flash from "../libs/flash/Flash";

function reloadHtml(content) {
    let h1 = $('#content-' + content.id + '-title');
    let text = $('#content-' + content.id + '-content');

    h1.html(content.title);
    text.html(content.content);
}

export async function editContents() {
    $('.content-editable #edit-content').click(async function () {
        console.log("oui");
        const id = $(this).data('id');

        const inputId = "bb_content-" + id + "-title";
        const textareaId = "bb_content-" + id + "-content";

        const editorSelector = '#' + textareaId;

        const content = await Content.get(id);

        bootbox.dialog({
            message: Content.buildHtmlForm(inputId, 'title', textareaId, null, content.title, content.content),
            title: "Modifier un contenu",
            backdrop: true,
            buttons: {
                cancel: {
                    label: "Annuler",
                    className: "btn-default",
                },
                validate: {
                    label: "Valider",
                    className: "btn-primary",
                    callback: async () => {

                        content.title = $('#bb_content-' + id + '-title').val();
                        content.content = Editor.getActiveEditorContent();

                        if (content.title === "" || content.content === "") {
                            Flash.error("Tous les champs champs sont requis.");
                            return false;
                        }

                        const resultContent = await content.update();
                        if (resultContent == null) {
                            Flash.error("Une erreur est survenue, les données n'ont pas été modifiées.");
                            return false;
                        }

                        reloadHtml(resultContent);
                    }
                }
            }
        });

        Editor.createUnique(editorSelector);
    });
}