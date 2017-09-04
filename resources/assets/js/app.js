/**
 * Created by Utilisateur on 17/07/2017.
 */
// import Flash from 'Flash';

import {navActive} from './scripts/nav-active';
import {editContents} from "./scripts/management/contents";
import {skills} from "./scripts/management/skills";
import {createNews, news} from "./scripts/management/news";
import {articles, createArticle} from "./scripts/management/articles";
import Editor from "./scripts/helpers/Editor";
import Router from "./scripts/libs/Router";

// var url = window.location.pathname;

const alerts = $('.alert').delay(2500).fadeOut(700, function () {
    $(this).remove();
});

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    Editor.prepare($('[data-toggle="editor"]'));
});

$(document).on('focusin', function (e) {
    if ($(e.target).closest(".mce-window").length) {
        e.stopImmediatePropagation();
    }
});

Array.prototype.remove = function () {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};

navActive();
editContents();
createNews();

Router.addRoute('articles\\/(rediger)|(\\d+\\/modifier)\\/?', [
    () => createArticle(),
]);

Router.addRoute('articles\\/\\d+', [
    () => articles(),
]);

Router.addRoute('news\\/\\d+\\/?', [
    () => news(),
]);

Router.addRoute('nos-competences\\/?', [
    () => skills()
]);

Router.execute();
