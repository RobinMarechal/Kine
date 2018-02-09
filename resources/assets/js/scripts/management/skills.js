import Editor from "../helpers/Editor";
import Skill from "../models/Skill";
import Content from "../models/Content";
import Flash from "../libs/flash/Flash";

function listOfSkillTitles() {
    return $('#section-titles').find('.skill-titles');
}

function addSkillDiv(skill) {
    let container = $('#section-contents');

    let div = $('<div></div>');
    div.attr('data-skill-id', skill.id);
    div.addClass('skill-section');

    let h1 = $('<h1></h1>');
    h1.html(skill.title);

    let hr = $('<hr/>');

    let p = $('<p></p>');
    p.html(skill.content);

    div.append(h1);
    div.append(hr);
    div.append(p);

    container.append(div);

    // showSkill(skill.id);
}

function buildNewSkillTitle(skill) {
    let el = $('<span></span>');
    el.attr('data-skill-id', skill.id);
    el.attr('data-skill-index', skill.index);
    el.addClass('skills-section-btn');
    el.addClass('skill-titles');

    el.html(skill.title);

    return el;
}

function getNewList(skill = null) {
    let list = listOfSkillTitles();

    let newTitle = null;

    if (skill !== null) {
        newTitle = buildNewSkillTitle(skill);
        list.push(newTitle);
    }

    list.sort((b1, b2) => {
        const b1Index = parseInt($(b1).data('skill-index'));
        const b2Index = parseInt($(b2).data('skill-index'));

        let res = b2Index - b1Index;

        if (res !== 0)
            return res;

        return $(b2).html().trim().localeCompare($(b1).html().trim());
    });

    return list;
}


function reloadHtml(list) {
    let div = $('#section-titles');

    $('.skill-titles').remove();

    let last = list[0];

    for (let i = 0; i < list.length; i++) {
        div.prepend(list[i]);
        if (last == null || $(list[i]).data('skill-id') > $(last).data('skill-id'))
            last = list[i];
    }

    $('.skill-titles').unbind('click');

    $('.skill-titles').click(function (ev) {
        titleClicked(ev, $(this));
    });

    titleClicked(null, last);
}

function titleClicked(event, el) {

    el = $(el);

    if (event !== null) {
        event.preventDefault();
    }

    $('.skill-titles.selected').removeClass('selected');
    el.addClass('selected');

    const skillId = el.data('skill-id');

    // hide the one visible
    $('#section-contents').find('.skill-section.selected').removeClass('selected');

    // Show the good one
    let divToShow = $('#section-contents').find(`div[data-skill-id=${skillId}]`);
    divToShow.addClass('selected');
}


export function skills() {
    $('#create-skills-content').click((e) => {
        e.preventDefault();

        const editorId = "bb_content";
        const inputId = "bb_title";
        const indexInputId = "bb_index";

        let html = Content.buildHtmlForm(inputId, 'title', editorId, 'content');
        let indexField = '<div class="form-group">'
            + '<label class="control-label">Poids :</label>'
            + '<input class="form-control" value="0" type="number" name="index" id="' + indexInputId + '"/>'
            + '</div>';

        html.append(indexField);

        bootbox.dialog({
            message: html,
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

                        const data = {
                            title: $('#' + inputId).val(),
                            content: Editor.getActiveEditorContent(),
                            index: $('#' + indexInputId).val(),
                        };

                        if (data.title === "" || data.content === "") {
                            Flash.error("Tous les champs champs sont requis.");
                            return false;
                        }

                        Skill.create(data).then((skill) => {
                            if (skill == null) {
                                Flash.error("Une erreur est survenue, la rubrique n'a pas été créée.");
                                return false;
                            }

                            addSkillDiv(skill);
                            const list = getNewList(skill);
                            reloadHtml(list);
                        });
                    },
                },
            },
        });

        Editor.createUnique('#' + editorId);
    });


    $('.skill-titles').click(function (e) {
        titleClicked(e, $(this));
    });

    $('#edit-skill').click(() => {
        const skillId = $('.skill-titles.selected').data('skill-id');

        const editorId = "bb_content";
        const inputId = "bb_title";
        const indexInputId = "bb_index";

        Skill.get(skillId).then((skill) => {
            let html = Content.buildHtmlForm(inputId, 'title', editorId, 'content', skill.title, skill.content);
            let indexField = '<div class="form-group">'
                + '<label class="control-label">Position :</label>'
                + '<input class="form-control" type="number" name="index" id="' + indexInputId + '" value="' + skill.index + '"/>'
                + '</div>';

            html.append(indexField);

            bootbox.dialog({
                message: html,
                title: "Modifier une rubrique",
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

                            skill.title = $('#' + inputId).val();
                            skill.content = Editor.getActiveEditorContent();
                            skill.index = $('#' + indexInputId).val();

                            if (skill.content == "" || skill.title === "") {
                                Flash.error("Tous les champs champs sont requis.");
                                return false;
                            }

                            skill.update()
                                .then((skill) => {
                                    if (skill == null) {
                                        Flash.error("Une erreur est survenue, la rubrique n'a pas été modifiée.");
                                        return false;
                                    }

                                    let title = $('.skill-titles[data-skill-id=' + skill.id + ']');
                                    title.html(skill.title);
                                    title.attr('data-skill-index', skill.index);

                                    const list = getNewList();

                                    reloadHtml(list);

                                    let content = $('.skill-section[data-skill-id=' + skill.id + ']');
                                    content.children('h1').html(skill.title);
                                    content.children('p').remove();

                                    let p = $('<p></p>');
                                    p.html(skill.content);
                                    content.append(p);

                                    Flash.success("La rubrique a bien été modifiée.");
                                })
                                .catch(e => {
                                    Flash.error("Une erreur est survenue, la rubrique n'a pas été modifiée.");
                                    console.log(["skills#validate", e]);
                                });
                        },
                    },
                },
            });

            Editor.createUnique('#' + editorId);
        });
    });

    $('#btn-remove-skill').click(function (ev) {
        ev.preventDefault();

        bootbox.confirm({
            title: "Supprimer une rubrique",
            size: "small",
            message: `<p align="center">Voulez-vous vraiment supprimer cette rubrique ? </p> <p align="center" class="text-error"><b>Attention, cette action est irréversible !</b></p>`,
            callback: (result) => {
                if (result) {
                    let skillTitle = $('.skill-titles.selected');
                    let skillContent = $('.skill-section.selected');

                    const skillId = skillTitle.data('skill-id');

                    Skill.remove(skillId)
                        .then(() => {
                            skillTitle.remove();
                            skillContent.remove();

                            let list = $('.skill-titles');
                            if (list.length > 0) {
                                titleClicked(null, $(list[0]));
                            }

                            Flash.success("La rubrique a bien été modifiée.");
                        })
                        .catch((e) => {
                            Flash.error("Une erreur est survenue, la rubrique n'a pas été supprimée.");
                            console.log(["skills#HF", e]);
                        });
                }
            },
        });
    });
}