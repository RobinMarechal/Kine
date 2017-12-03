/**
 * Created by Utilisateur on 29/07/2017.
 */

import Content from "../models/Content";
import Editor from "../helpers/Editor";
import Flash from "../libs/flash/Flash";

function reloadHtml(content) {
    let h1 = $('#content-'+content.id+'-title');
    let text = $('#content-'+content.id+'-content');

    h1.html(content.title);
    text.html(content.content);
}

export function editContents() {
    $('.content-editable #edit-content').click(function () {
        var id = $(this).data('id'),
            name = $(this).data('name');




        const inputId = "bb_content-" + id + "-title";
        const textareaId = "bb_content-" + id + "-content";

        const editorSelector = '#' + textareaId;

        Content.get(id).then(function (content) {
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
                        callback: () => {

                            content.title = $('#bb_content-' + id + '-title').val();
                            content.content = Editor.getActiveEditorContent();

                            if(content.title == "" || content.content == "")
                            {
                                Flash.error("Tous les champs champs sont requis.");
                                return false;
                            }

                            content.update().then((content) => {
                                if (content == null) {
                                    Flash.error("Une erreur est survenue, les données n'ont pas été modifiées.");
                                    return false;
                                }

                                reloadHtml(content);
                            });
                        }
                    }
                }
            });

            Editor.createUnique(editorSelector);
        });

    });
}