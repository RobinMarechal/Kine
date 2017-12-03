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
import {config_pikaday} from "../data/pikaday.data";

function buildForm(news = null) {

    let divTitle = Form.formGroup();
    let divContent = Form.formGroup();
    let divPublishAt = Form.formGroup();

    let labelTitle = Form.label('Titre :');
    let inputTitle = Form.input('title', 'bb_title');


    let labelContent = Form.label('Texte :');
    let textarea = Form.textarea('content', 'bb_content');

    let labelDate = Form.label('Date de publication :');
    let inputDate = Form.input('published_at', 'bb_published_at');

    if (news !== null) {
        inputTitle.val(news.title);
        textarea.html(news.content);
        inputDate.val(new Date(news.published_at));
    }
    else {
        inputDate.val(new Date().toISOString());
    }

    divTitle.append(labelTitle);
    divTitle.append(inputTitle);

    divContent.append(labelContent);
    divContent.append(textarea);

    divPublishAt.append(labelDate);
    divPublishAt.append(inputDate);

    let container = $('<div></div>');
    container.append(divTitle);
    container.append(divContent);
    container.append(divPublishAt);

    return container;
}

function openNewsDialog(news = null) {
    const form = buildForm(news);
    let datepicker = null;

    bootbox.dialog({
        message: form,
        title: news === null ? "Rédiger une news" : "Modifier une news",
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
                        published_at: datepicker.toString(),
                    }

                    Api.get('/doctor', false)
                        .done((doctor) => {

                            data.doctor_id = doctor.id;

                            if (data.title === "" || data.content === "" || data.published_at === null) {
                                Flash.error("Tous les champs sont requis.");
                                return false;
                            }

                            if (news === null) {
                                News.create(data).then((news) => {
                                    Helper.redirectTo('news/' + news.id);
                                })
                            }
                            else {
                                news.title = data.title;
                                news.content = data.content;
                                news.published_at = data.published_at;

                                news.update().then((news) => {
                                    const published_at = new Date(news.published_at);
                                    const divInfo = $('#news-visibility-info');

                                    $('#news-title').html(news.title);
                                    $('#news-content').html(news.content);
                                    $('#news-published_at').html(Helper.dateToFormat(published_at, 'd/m/Y'));

                                    if (published_at > new Date()) {
                                        let tag = $('#news-visibility-info .top-left-symbol');

                                        try {
                                            let titleTemplate = tag.data('title-template');
                                            if (titleTemplate === null)
                                                titleTemplate = "";

                                            const titleTemplateVar = '{' + tag.data('title-template-variable') + '}';
                                            const title = titleTemplate.replace(titleTemplateVar, Helper.dateToFormat(published_at));

                                            tag.attr('data-original-title', title);
                                        } catch (e) {
                                        }

                                        divInfo.prop('hidden', false);
                                    }
                                    else {
                                        divInfo.prop('hidden', true);
                                    }

                                    Flash.success('La news a été modifiée avec succès.');
                                });
                            }
                        })
                        .fail((error) => {
                            Flash.error("Une erreur est survenue, la news n'a pas été publiée.");
                            return false;
                        });
                }
            }
        }
    });

    Editor.createUnique('#bb_content');

    const pikadayConfig = config_pikaday;
    pikadayConfig.field = $('#bb_published_at')[0];

    datepicker = new Pikaday(pikadayConfig);
}

export function createNews() {
    $('.create-news').click(function (ev) {
        ev.preventDefault();
        openNewsDialog();
    });
}

export function news() {
    $('#edit-news').click(function () {
        const newsId = $(this).data('id');

        News.get(newsId).then((news) => {
            openNewsDialog(news);
        })
    });

    $('#btn-remove-news').click(function () {
        const newsId = $(this).data('id');

        let dialog = new RemovingConfirmDialog();
        dialog.message = "Voulez-vous vraiment supprimer cette news ?";
        dialog.title = "Supprimer la news";
        dialog.callback = function () {
            News.remove(newsId)
                .then((response) => {
                    Flash.success("La news a été supprimée avec succès.");
                    Helper.redirectTo("/news");
                })
                .catch((error) => {
                    Flash.error("Une erreur est survenue, la news n'a pas été supprimée.");
                })
        }

        dialog.build();
    })


}


// export function news() {
//     $('#edit-news').click(function (ev) {
//         const newsId = $(this).data('id');
//
//         News.get(newsId).then(() => {
//             const form = buildForm(news);
//             let datepicker = null;
//
//             bootbox.dialog({
//                 message: form,
//                 title: news === null ? "Rédiger une news" : "Modifier une news",
//                 backdrop: true,
//                 buttons: {
//                     cancel: {
//                         label: "Annuler",
//                         className: "btn-default",
//                     },
//                     validate: {
//                         label: "Valider",
//                         className: "btn-primary",
//                         callback: () => {
//
//                             const data = {
//                                 title: $('#bb_title').val(),
//                                 content: Editor.getActiveEditorContent(),
//                                 published_at: datepicker.toString(),
//                             }
//
//                             Api.get('user', false)
//                                 .done((user) => {
//
//                                     data.user_id = user.id;
//
//                                     if (data.title === "" || data.content === "" || data.published_at === null) {
//                                         Flash.error("Tous les champs sont requis.");
//                                         return false;
//                                     }
//
//                                     News.create(data).then((news) => {
//                                         Helper.redirectTo('news/' + news.id);
//                                     })
//                                 })
//                                 .fail((error) => {
//                                     Flash.error("Une erreur est survenue, la news n'a pas été publiée.");
//                                     return false;
//                                 });
//                         }
//                     }
//                 }
//             });
//
//             Editor.createUnique('#bb_content');
//             datepicker = new Pikaday({
//                 field: $('#bb_published_at')[0],
//                 toString(date, format)
//                 {
//                     const day = date.getDate();
//                     const month = date.getMonth() + 1;
//                     const year = date.getFullYear();
//                     return `${year}-${month}-${day}`;
//                 },
//                 i18n: {
//                     previousMonth: 'Mois précédent',
//                     nextMonth: 'Mois suivant',
//                     months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
//                     weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
//                     weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
//                 }
//             });
//         });
//     });
// }