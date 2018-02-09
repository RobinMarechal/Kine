import Flash from "../libs/flash/Flash";
import Helper from "../helpers/Helper";
import RemovingConfirmDialog from "../helpers/RemovingConfirmDialog";
import Article from "../models/Article";
import Key from '../libs/Key';

export function articles() {
    $('#btn-remove-article').click(function () {
        const articleId = $(this).data('id');

        if (articleId <= 0)
            return;

        let dialog = new RemovingConfirmDialog();
        dialog.message = "Voulez-vous vraiment supprimer cet article ?";
        dialog.title = "Supprimer l'article";
        dialog.callback = async () => {
            try {
                await Article.remove(articleId);
                Flash.success("L'article a été supprimé avec succès.");
                Helper.redirectTo("/articles");
            } catch (e) {
                Flash.error("Une erreur est survenue, l'article n'a pas été supprimé.");
            }
        };

        dialog.build();
    });
}


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
    if (enteredName === "")
        return;

    if (';' in enteredName) {
        Flash.error("Le caractère ';' est réservé, merci de ne pas l'utiliser dans le nom des tags.", 3000);
        return;
    }

    const formattedName = formatTagName(enteredName);

    // The tag already exists: we leave the function
    if (getSelectedTagList().indexOf(formattedName) !== -1) {
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
        jqueryObj.addClass('selected-tag');
    }

    createTag(formattedName, indexInList);

    input.val('');
}

function removeTag(tag) {
    const index = tag.data('index');
    // Remove the created tag
    tag.remove();
    if (index !== -1) {
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
    });

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
    cross.addClass('times');
    cross.addClass('remove-tag');
    cross.attr('title', 'Retirer ce tag');
    cross.html('x');

    cross.click(function () {
        removeTag($(this).parent('span'));
    });

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
    });

    if (value.length > 0) {
        value = value.substring(0, value.length - 1);
        $('#tags-input').val(value);
    }
}

function submitForm() {
    prepareTagsField();
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
            if (loadedTagName === htmlTag.html()) {
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
    if (loadedTags.length !== 0) {
        loadTags(loadedTags);
    }

    $('#article-creation-preview').click(function () {
        preview();
    });
}


$('#add-tag-input').keypress(function (event) {
    // 13 = Enter button
    if (event.which === Key.ENTER) {
        event.preventDefault();
        $('#add-tag-button').click();
    }
});