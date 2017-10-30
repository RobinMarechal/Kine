/**
 * Created by Utilisateur on 16/07/2017.
 */
$('#create-skills-content').click(function () {
    bootbox.dialog({
        message: '<div class="form-group">' +
        '<label class="label-control">Titre :</label>' +
        '<input class="form-control" type="text" name="title" id="title" placeholder="Titre de la rubrique"/>' +
        '</div>' +
        '<label class="label-control">Texte :</label>' +
        '<textarea class="form-control" id="content" name="content" placeholder="Texte de la rubrique"></textarea>',
        title: "Ajouter une rubrique",
        backdrop: true,
        buttons: {
            cancel: {
                label: "Annuler",
                className: "btn-default",
            },
            validate: {
                label: "Valider",
                className: "btn-primary",
                callback: function () {
                    var data = {
                        title: $('title').val(),
                        content: CKEDITOR.instances['content'].getData(),
                    }

                    Content.create(data, function (data) {
                        window.location.replace(window.location.host + "/nos-competences");
                    });
                }
            }
        }
    });
    CKEDITOR.replace('content');
});