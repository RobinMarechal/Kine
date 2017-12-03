/**
 * Created by Utilisateur on 06/08/2017.
 */

import Editor from "../helpers/Editor";
import Flash from "../libs/flash/Flash";
import Form from "../helpers/Form";
import News from "../models/News";
import Helper from "../helpers/Helper";
import Api from "../libs/Api";
import RemovingConfirmDialog from "../helpers/RemovingConfirmDialog";
import Article from "../models/Article";

function buildForm(news = null) {

    let divTitle = Form.formGroup();
    let divContent = Form.formGroup();

    let labelTitle = Form.label('Titre :');
    let inputTitle = Form.input('title', 'bb_title');

    let labelContent = Form.label('Texte :');
    let textarea = Form.textarea('content', 'bb_content');

    inputTitle.val(news.title);
    textarea.html(news.content);

    divTitle.append(labelTitle);
    divTitle.append(inputTitle);

    divContent.append(labelContent);
    divContent.append(textarea);

    let container = $('<div></div>');
    container.append(divTitle);
    container.append(divContent);

    return container;
}

function openArticleDialog(article) {
    const form = buildForm(article);
    let datepicker = null;

    bootbox.dialog({
        message: form,
        title: 'Modifier un article',
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

                    const data = {
                        title: $('#bb_title').val(),
                        content: Editor.getActiveEditorContent(),
                    }

                    Api.get('/user?with=doctor', false)
                        .done((user) => {
                            data.doctor_id = user.id;

                            if (data.title === "" || data.content === "") {
                                Flash.error("Tous les champs sont requis.");
                                return false;
                            }

                            if (article === null) {
                                Article.create(data).then((article) => {
                                    Helper.redirectTo('articles/' + article.id);
                                })
                            }
                            else {
                                article.title = data.title;
                                article.content = data.content;

                                article.update().then((article) => {

                                    $('#article-title').html(article.title);
                                    $('#article-content').html(article.content);

                                    Flash.success('L\'article a été modifié avec succès.');
                                });
                            }
                        })
                        .fail(() => {
                            Flash.error("Une erreur est survenue, l\'article n'a pas été publié.");
                            return false;
                        });
                }
            }
        }
    });

    Editor.createUnique('#bb_content');
}

export function articles() {
    $('#btn-remove-article').click(function () {
        const articleId = $(this).data('id');

        if(articleId <= 0)
            return;

        let dialog = new RemovingConfirmDialog();
        dialog.message = "Voulez-vous vraiment supprimer cet article ?";
        dialog.title = "Supprimer l'article";
        dialog.callback = function () {
            Article.remove(articleId)
                .then(() => {
                    Flash.success("L'article a été supprimé avec succès.");
                    Helper.redirectTo("/articles");
                })
                .catch(() => {
                    Flash.error("Une erreur est survenue, l'article n'a pas été supprimé.");
                })
        }

        dialog.build();
    })
}


//
// function refreshTagList(list)
// {
//     $('.tag-item').remove();
//
//     let end = Math.min(5, list.length);
//
//     for (let i = 0; i < end; i++) {
//         let li = $('<li></li>');
//         li.addClass('list-group-item');
//         li.addClass('tag-item');
//         li.html(list[i]);
//
//         li.click(function()
//         {
//             tagItemClick(list);
//         });
//
//         $('#tag-list-group .items').append(li);
//     }
// }
//
// function tagItemClick(tags)
// {
//     const tagName = $(this).html();
//
//     tags.remove(tagName);
//     tags.remove(tagName);
//
//     $('#add-tag-input').val(tagName);
//     $('#add-tag-button').click();
//
//     refreshTagList(tags);
// }
//
// export function createArticle() {
//
//     let tags = ['abc', 'jkl', 'mno', 'def', 'ghi', 'pqr', 'stu'];
//
//     tags.sort();
//
//     refreshTagList(tags);
//
//     $('.remove-tag').click(function () {
//         removeTag($(this));
//     });
//
//     $('#add-tag-button').click(function () {
//         let input = $('#add-tag-input');
//         let tagList = $('#tag-list');
//         const tagName = input.val();
//
//         if (tagName.length == 0)
//             return;
//
//         input.val("");
//
//         let tag = $('<span></span>');
//         tag.attr('data-name', tagName);
//         tag.addClass("tag");
//         tag.html(tagName);
//
//         let cross = $('<i></i>');
//         cross.addClass('fa');
//         cross.addClass('fa-times');
//         cross.addClass('remove-tag');
//         cross.attr('title', 'Retirer ce tag');
//
//         cross.click(function () {
//             removeTag($(this));
//         })
//
//         tag.append(cross);
//
//         tagList.append(tag);
//     });
// }

function formatTagName(tagName) {
    let formattedEnteredName = "";

    if (tagName.length > 0) {
        const array = tagName.split(' ');
        for (let i = 0; i < array.length; i++) {
            formattedEnteredName += array[i].substring(0, 1).toUpperCase();
            formattedEnteredName += array[i].substring(1).toLowerCase();
            formattedEnteredName += ' ';
        }
    }

    return formattedEnteredName.trim();
}

function highlightSelectedTag(tag) {
}

function submitNewTag() {
    const input = $('#add-tag-input');
    const enteredName = input.val().toLowerCase().trim();

    // The name is empty: we leave the function
    if (enteredName == "")
        return;

    if (enteredName.indexOf(';') != -1) {
        Flash.error("Le caractère ';' est réservé, merci de ne pas l'utiliser dans le nom des tags.", 3000);
        return;
    }

    const formattedName = formatTagName(enteredName);

    // The tag already exists: we leave the function
    if (getSelectedTagList().indexOf(formattedName) != -1) {
        input.val('');
        const jqueryObj = $(`.tag[data-name=${formattedName}]`);
        highlightSelectedTag(jqueryObj);
        return;
    }

    const tagList = getTagList();
    const htmlTagList = getHtmlTagList();
    const indexInList = tagList.indexOf(enteredName);

    if (indexInList > -1) {
        const jqueryObj = $(htmlTagList[indexInList]);
        // if (jqueryObj.hasClass('selected-tag')) {
        //     input.val('');
        //     highlightSelectedTag(jqueryObj);
        //     return;
        // }

        jqueryObj.addClass('selected-tag');
    }

    createTag(formattedName, indexInList);

    input.val('');
}

function removeTag(tag) {
    const index = tag.data('index');
    // Remove the created tag
    tag.remove();
    if (index != -1) {
        // Reset the item in the list (if it's in)
        $(getHtmlTagList()[index]).removeClass('selected-tag');
    }
}

function getHtmlTagList() {
    return $('.tag-item');
}

function getTagList() {
    let list = [];
    $('.tag-item').each(function (i) {
        let tagItem = $(this);
        tagItem.attr('data-index', i);
        list.push(tagItem.html().toLowerCase());
    })

    return list;
}

function createTag(name, index) {
    // Create the span tag with the name, the index
    let tag = $('<span></span>');
    tag.attr('data-name', name);
    tag.attr('data-index', index);
    tag.addClass("tag");
    tag.html(name);

    // Create the cross used to remove a tag
    let cross = $('<i></i>');
    cross.addClass('fa');
    cross.addClass('fa-times');
    cross.addClass('remove-tag');
    cross.attr('title', 'Retirer ce tag');

    cross.click(function () {
        removeTag($(this).parent('span'));
    })

    tag.append(cross);
    $('#tag-list').append(tag);
}

function tagItemClicked(el) {
    // If it has already been selected, deselect it
    if (el.hasClass('selected-tag')) {
        const index = el.data('index');
        const htmlTag = $(`.tag[data-index=${index}]`);
        removeTag(htmlTag);
        return;
    }

    el.addClass('selected-tag');

    const tagName = el.html();
    const index = el.data('index');

    createTag(tagName, index);
}

function resetTagSelection() {
    $('.tag-item').removeClass('selected-tag');
    $('#tag-list').html('');
    loadTags(getLoadedTagList());
}

function getSelectedTagList() {
    const htmlSelectedList = $('.tag');
    let list = [];
    htmlSelectedList.each(function () {
        list.push($(this).data('name'));
    });

    return list;
}

function prepareTagsField() {
    const selectedTagList = getSelectedTagList();

    let value = "";
    selectedTagList.forEach(function (el) {
        value += el + ';';
    })

    if (value.length > 0) {
        value = value.substring(0, value.length - 1);
        $('#tags-input').val(value);
    }
}

function submitForm(event) {
    prepareTagsField();
    console.log("run");
    $('#article-creation-form').submit();
}

function loadTags(loadedTagList) {
    let htmlTagList = getHtmlTagList();

    // For each loaded tag, we check if it's in the html tag list
    loadedTagList.forEach(function (loadedTagName) {
        // For each tag in DB
        for (let i = 0; i < htmlTagList.length; i++) {
            const htmlTag = $(htmlTagList[i]);

            // If this tag is the html list should be selected
            if (loadedTagName == htmlTag.html()) {
                htmlTag.click();
                htmlTagList.splice(i, 1);
                break;
            }
        }
    });
}

function getLoadedTagList() {
    return $('#tags-input').val().split(';');
}

function preview() {
    prepareTagsField();

    const form = $('#article-creation-form');

    const method = form.attr('method');

    form.attr('target', '_blank');
    form.attr('action', '/articles/previsualisation');
    form.attr('method', 'POST');

    form.submit();

    form.removeAttr('target');
    form.removeAttr('action');
    form.attr('method', method);
}

export function createArticle() {
    // Get the list of tags generated with PHP
    const htmlTagList = getHtmlTagList();
    const primaryList = getTagList();

    // Select a tag of the list
    $('.tag-item').click(function () {
        tagItemClicked($(this));
    });

    // Remove a tag from selected ones
    $('.remove-tag').click(function () {
        removeTag($(this).parent('span'));
    });

    $('#add-tag-button').click(function () {
        submitNewTag();
        $('#add-tag-input').focus();
    });

    $('button[type=reset]').click(function () {
        resetTagSelection();
    });

    $('#submit-article-creation').click(function () {
        submitForm();
    });

    const loadedTags = getLoadedTagList();
    if (loadedTags.length != 0) {
        loadTags(loadedTags);
    }

    $('#article-creation-preview').click(function () {
        preview();
    });
}


$('#add-tag-input').keypress(function (event) {
    // 13 = Enter button
    if (event.which == 13) {
        event.preventDefault();
        $('#add-tag-button').click();
    }
});