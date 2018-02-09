import {navActive} from './scripts/nav-active';
import {skills} from "./scripts/management/skills";
import {articles, createArticle} from "./scripts/management/articles";
import Editor from "./scripts/helpers/Editor";
import Router from "./scripts/libs/Router";
import {usersManagement} from "./scripts/management/users";
import Vars from "./scripts/libs/PhpVarCatcher";
import {toggleInput} from "./scripts/management/toggleInputControls";
import KeyInputBuffer from "./scripts/helpers/KeyInputBuffer";
import footerDoctors from "./scripts/management/footerDoctors";
import Api from "./scripts/libs/Api";
import Flash from "./scripts/libs/flash/Flash";
import manageDataCreation from "./scripts/management/manageDataCreation";
import updateImage from "./scripts/management/updateImage";
import manageBugs from "./scripts/management/manageBugs";
import manageUserContacts from './scripts/management/manageUserContacts';

// var url = window.location.pathname;

$('.alert').delay(2500).fadeOut(700, function () {
    $(this).remove();
});

$.prototype.toHtmlString = function () {
    return this.prop('outerHTML');
};

$(document).ready(function () {
    $('.close-modal').click(() => bootbox.hideAll());
    $('[data-toggle="tooltip"]').tooltip();
    Editor.prepare($('[data-toggle="editor"]'));
    Editor.prepare($('[data-toggle="focus-sensitive-editor"]'), {
        height: 1,
        setup: function (editor) {
            editor.on('focus', function (e) {
            });

            editor.on('blur', function () {
                const editor = Editor.getActiveEditor();
                const settings = editor.settings;
                const selector = settings.selector;
                const tag = $(selector);
                const namespace = tag.data('namespace');
                const name = tag.attr('name');
                const dataId = tag.data('id');
                const startContent = editor.startContent == null ? "" : editor.startContent;
                const newContent = editor.getContent() == null ? "" : editor.getContent();
                const data = {};

                if (!editor.isDirty() || newContent === startContent) // unmodified
                {
                    return;
                }

                if (dataId == null || dataId < 1) {
                    Flash.error("Une erreur est survenue, l'information n'a pas été modifiée...");
                    editor.setContent(startContent);
                    return;
                }

                data.id = dataId;
                data[name] = newContent == null ? "" : newContent;

                Api.sendData(namespace + '/' + dataId, "PUT", data)
                    .then(() => {
                        editor.setContent(newContent);
                        editor.startContent = newContent;
                        Flash.success("L'information a bien été modifiée !");
                    })
                    .catch(() => {
                        editor.setContent(startContent);
                        Flash.error("Une erreur est survenue, l'information n'a pas été modifiée... 2");
                    });
            });
        },
    });

    toggleInput();
});

$(document).on('focusin', function (e) {
    if ($(e.target).closest(".mce-window").length) {
        e.stopImmediatePropagation();
    }
});

Array.prototype.remove = function () {
    let what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};

Array.prototype.insertAt = function (index, el) {
    this.splice(index, 0, el);
    return this;
};

Vars.boot();
KeyInputBuffer.boot();

navActive();
footerDoctors();
manageDataCreation();
updateImage();


Router.addRoute('articles\\/(rediger)|(\\d+\\/modifier)\\/?', [
    () => createArticle(),
]);

Router.addRoute('articles\\/\\d+\\/?', [
    () => articles(),
]);

Router.addRoute('nos-competences\\/?', [
    () => skills(),
]);

Router.addRoute('admin\\/utilisateurs\\/\\d+\\/?', [
    () => manageUserContacts(),
]);

Router.addRoute('admin\\/utilisateurs\\/?', [
    () => usersManagement(),
]);

Router.addRoute('admin\\/contacts\\/?', [
    () => manageUserContacts(),
]);

Router.addRoute('admin\\/bugs(\\/\\d+\\/?)?', [
    () => manageBugs(),
]);

Router.trigger();
