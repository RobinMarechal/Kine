import User from "../models/User";
import Tag from "../models/Tag";
import Api from "../libs/Api";
import Flash from "../libs/flash/Flash";
import Helper from "../helpers/Helper";
import Doctor from "../models/Doctor";

function updateUserTagListInTable(response) {
    const userId = response.user_id;
    const table = $('#users-list');
    const tr = table.find('tr[data-id=' + userId + ']');
    const div = tr.find('.table-tag-list');

    div.html('');

    const tags = response.tags;
    for (let i = 0; i < tags.length; i++) {
        div.append('<span class="tag">' + tags[i] + '</span>');
    }

    Flash.success("Les tags de l'utilisateur ont bien été modifiés.");
}

function submit() {
    const userTags = $('#tag-list .tag');
    const userId = $('#edit-user-tags').data('user-id');
    let ids = [];

    for (let i = 0; i < userTags.length; i++) {
        ids.push($(userTags[i]).data('id'));
    }

    const data = {
        tags: ids,
    };

    return new Promise((resolve, reject) => {
        Api.sendData(`users/${userId}/tags`, 'PUT', data)
            .done((response) => {

                updateUserTagListInTable(response);

                resolve(response);
            })
            .fail((error) => {
                Flash.error("Une erreur est survenue, les tags de l'utilsateur n'ont peut être pas été correctement modifiés...", 4000);
                reject(error);
            });
    });
}

function getTagInUserTagList(id) {
    return $(`.tag[data-id=${id}]`);
}

function getTagInAllTagList(id) {
    return $(`.tag-item[data-id=${id}]`);
}

function getUserTagsDiv() {
    return $('#tag-list');
}

function removeTag(id) {
    const tagInUserTagList = getTagInUserTagList(id);
    const tagInAllTagList = getTagInAllTagList(id);

    tagInUserTagList.remove();
    tagInAllTagList.removeClass('selected-tag');
}

function createTag(id, name) {
    const cross = $('<i class="fa fa-times remove-tag" title="Retirer ce tag"></i>');
    cross.click(function () {
        removeTag($(this).parent('span').data('id'));
    });

    let span = $(`<span class="tag" data-name="${name}" data-id="${id}">${name}</span>`);
    span.append(cross);

    return span;
}

function addTag(id, name) {
    const tagInAllTagList = getTagInAllTagList(id);
    const userTagsList = getUserTagsDiv();

    tagInAllTagList.addClass('selected-tag');

    const tag = createTag(id, name);
    userTagsList.append(tag);
}

function buildStandardUserHtml(user) {
    return new Promise((resolve, reject) => {
        Tag.all('orderby=name').then((tags) => {
            const usersTags = user.tags;
            let usersTagIds = [];

            const form = $('<form class="row" id="edit-user-tags" data-user-id="' + user.id + '"></form>');
            const formGroupEmail = $('<div class="form-group col-lg-10 col-lg-offset-1"></div>');
            form.append(formGroupEmail);
            formGroupEmail.append('<label>Email : </label> &nbsp; ');
            formGroupEmail.append(`<a style="text-indent: 20px" href="mailto:${user.email}">${user.email}</a>`);

            const formGroup = $('<div class="form-group col-lg-10 col-lg-offset-1"></div>');
            form.append(formGroup);

            formGroup.append('<label>Tags : </label>');

            const tagList = $('<div id="tag-list"></div>');

            for (let i = 0; i < usersTags.length; i++) {
                const id = usersTags[i].id;
                const name = usersTags[i].name;

                usersTagIds.push(id);

                const span = createTag(id, name);

                tagList.append(span);
            }

            formGroup.append(tagList);
            formGroup.append('<br>');

            const ul = $('<ul class="list-group" id="tag-list-group"></ul>');
            const items = $('<div class="items"></div>');


            for (let i = 0; i < tags.length; i++) {
                const id = tags[i].id;
                const name = tags[i].name;

                let classes = 'list-group-item tag-item';
                if (usersTagIds.indexOf(id) != -1) {
                    classes += ' selected-tag';
                }

                const li = $(`<li data-name="${name}" data-id="${id}" class="${classes}">${name}</li>`);
                li.click(function () {
                    if ($(this).hasClass('selected-tag')) {
                        removeTag(id);
                    } else {
                        addTag(id, name);
                    }
                });

                items.append(li);
            }

            ul.append(items);
            formGroup.append(ul);

            resolve(form);

        }).catch((error) => {
            reject(error);
        });
    });
}

function buildCoursesTable(user) {
    const table = $('<table id="doctors-list" class="table table-hover table-striped "></table>');
    const thead = $('<thead></thead>');
    const tbody = $('<tbody></tbody>');
    thead.append('<td>Cours</td>');
    thead.append('<td>Tags</td>');
    thead.append('<td align="center">Utilisateurs inscrits</td>');

    if (user.courses.length == 0) {
        tbody.append('<td>-</td>');
        tbody.append('<td>-</td>');
        tbody.append('<td align="center">-</td>');
    }
    else {
        for (let i = 0; i < user.courses.length; i++) {
            const course = user.courses[i];
            const tr = $('<tr></tr>');

            const tdTitle = `<td><a href="/cours/${course.id}">${course.name}</a>`;

            const tdTags = $('<td><div class="table-tag-list"></div></td>');
            for (let i = 0; i < course.tags.length; i++) {
                const tag = course.tags[i];
                tdTags.append('<span class="tag">' + tag.name + '</span>');
            }

            const tdUsers = '<td align="center">' + course.users.length + '</td>';

            tr.append(tdTitle);
            tr.append(tdTags);
            tr.append(tdUsers);

            tbody.append(tr);
        }
    }


    table.append(thead);
    table.append(tbody);

    return table;
}

function buildNewsTable(user) {
    const table = $('<table id="doctors-list" class="table table-hover table-striped "></table>');

    const thead = $('<thead></thead>');
    const tbody = $('<tbody></tbody>');

    thead.append('<td>News</td>');
    thead.append('<td align="center">Date de publication</td>');
    thead.append('<td align="center">Vues</td>');

    if (user.news.length == 0) {
        tbody.append('<td>-</td>');
        tbody.append('<td align="center">-</td>');
        tbody.append('<td align="center">-</td>');
    }
    else {
        for (let i = 0; i < user.news.length; i++) {
            const news = user.news[i];
            const tr = $('<tr></tr>');

            tr.append(`<td><a href="/news/${ news.id }">${ news.title }</a></td>`);
            tr.append(`<td align="center">${ Helper.dateToFormat(new Date(news.published_at), 'd/m/Y') }</td>`);
            tr.append(`<td align="center">${ news.views }</td>`);

            tbody.append(tr);
        }
    }

    table.append(thead);
    table.append(tbody);

    return table;
}

function buildArticlesTable(user) {
    const table = $('<table id="doctors-list" class="table table-hover table-striped "></table>');

    const thead = $('<thead></thead>');
    const tbody = $('<tbody></tbody>');

    thead.append('<td>Article</td>');
    thead.append('<td align="center">Date de publication</td>');
    thead.append('<td>Tags</td>');
    thead.append('<td align="center">Vues</td>');


    if (user.articles.length == 0) {
        tbody.append('<td>-</td>');
        tbody.append('<td align="center">-</td>');
        tbody.append('<td>-</td>');
        tbody.append('<td align="center">-</td>');
    }
    else {
        for (let i = 0; i < user.articles.length; i++) {
            const article = user.articles[i];
            const tr = $('<tr></tr>');

            tr.append(`<td><a href="/articles/${ article.id }">${ article.title }</a></td>`);
            tr.append(`<td align="center">${ Helper.dateToFormat(new Date(article.created_at), 'd/m/Y') }</td>`);
            const tagsDiv = $('<td><div class="table-tag-list"></div></td>');
            for (let i = 0; i < article.tags.length; i++) {
                const tag = article.tags[i];
                tagsDiv.append(`<span class="tag">${tag.name}</span>`);
            }
            tr.append(tagsDiv);
            tr.append(`<td align="center">${ article.views }</td>`);

            tbody.append(tr);
        }
    }
    table.append(thead);
    table.append(tbody);

    return table;
}

function buildDoctorUserHtml(user) {
    return new Promise((resolve) => {

        const div = $('<table id="doctor-info-dialog" class="table table-hover table-striped"></table>');

        // const tableCourses = $('<div class="doctor-info-table"></div>');
        // tableCourses.append(buildCoursesTable(user));
        //
        // const tableNews = $('<div class="doctor-info-table"></div>');
        // tableNews.append(buildNewsTable(user));
        //
        // const tableArticles = $('<div class="doctor-info-table"></div>');
        // tableArticles.append(buildArticlesTable(user));
        //
        //
        // div.append(tableCourses);
        // div.append('<br>');
        // div.append(tableNews);
        // div.append('<br>');
        // div.append(tableArticles);

        const thead = $('<thead></thead>');
        thead.append('<td>');


        resolve(div);
    });
}

function buildHtml(user) {
    return user instanceof Doctor || user.is_doctor == 1 || user.user_id != null ? buildDoctorUserHtml(user) : buildStandardUserHtml(user);
}

function editUser(target) {
    const tr = $(target).parents('tr');
    const userId = tr.data('id');

    let params;
    let size;
    if (tr.hasClass('doctor')) {
        // params = 'with=articles.tags,news,supervisedCourses.users,supervisedCourses.tags';
        params = 'with=contacts';
        size = 'small';

        Doctor.get(userId, params).then((doctor) => {
            buildHtml(doctor)
                .then((html) => {
                    bootbox.dialog({
                        title: doctor.name,
                        message: html,
                        size: size,
                        buttons: {
                            cancel: {
                                label: "Annuler",
                                className: "btn-default",
                            },
                            submit: {
                                label: "Valider",
                                className: "btn-primary",
                                callback: function () {
                                    return submit();
                                }
                            }
                        }
                    });
                })
                .catch((error) => {
                    throw error;
                });
        });
    }
    else {
        params = 'with=tags';
        size = 'small';

        User.get(userId, params).then((user) => {
            buildHtml(user)
                .then((html) => {
                    bootbox.dialog({
                        title: user.name,
                        message: html,
                        size: size,
                        buttons: {
                            cancel: {
                                label: "Annuler",
                                className: "btn-default",
                            },
                            submit: {
                                label: "Valider",
                                className: "btn-primary",
                                callback: function () {
                                    return submit();
                                }
                            }
                        }
                    });
                })
                .catch((error) => {
                    throw error;
                });
        });
    }
}

function downgradeDoctor(target) {
    const tr = $(target).parents('tr');
    const userId = tr.data('id');

    Doctor.remove(userId).then(() => {

        User.get(userId).then((user) => {

            user.is_doctor = 0;
            user.update('with=courses,tags').then((user) => {
                const usersTable = $('#users-list');
                const tbody = usersTable.children('tbody');

                const newTr = $('<tr></tr>');
                newTr.addClass('user');
                newTr.attr('data-id', user.id);

                const name = $('<td>' + user.name + '</td>');

                const courses = '<td align="center" class="user-courses user-info"> ' + user.courses.length + ' </td>';

                const tags = $('<td></td>');
                tags.addClass('user-tags');
                tags.addClass('user-info');

                let i;
                for (i = 0; i < user.tags.length; i++) {
                    const tag = user.tags[i];
                    const html = $(`<span>${tag.name}</span>`);
                    html.addClass('tag');
                    tags.append(html);
                }

                if (i == 0) {
                    tags.append('-');
                }

                const upgrade = $('<i title="Ajouter cet utilisateur à la liste des docteurs" class="fa fa-plus-circle upgrade-user" aria-hidden="true"></i>');
                const edit = $('<i title="Voir la fiche de cet utilisateur" class="glyphicon glyphicon-pencil edit-user"></i>');

                upgrade.click(function (el) {
                    upgradeUser(upgrade);
                });

                edit.click(function (el) {
                    editUser(edit);
                });

                const controls = $('<td></td>');
                controls.attr('align', 'center');
                controls.addClass('controls');
                controls.append(upgrade);
                controls.append(edit);

                newTr.append(name);
                newTr.append(courses);
                newTr.append(tags);
                newTr.append(controls);

                tbody.append(newTr);
                tr.remove();
            })
                .catch(() => {
                    throw 3;
                });
        }).catch((error) => {
            throw error == 3 ? error : 2;
        });
    }).catch((error) => {
        console.log(error);
        Flash.error("Une erreur est survenue, l'utilisateur n'a pas été rétrogradé.");
    });
}

function upgradeUser(target) {
    const tr = $(target).parents('tr');

    const userId = tr.data('id');

    // ICI
    User.get(userId).then((user) => {
        user.is_doctor = 1;
        user.update(/*'with=courses,news,articles'*/).then((user) => {
            let doc = {
                id: user.id,
                name: user.name
            };


            Doctor.create(doc, 'with=courses,news,articles')
                .then((doctor) => {

                    const usersTable = $('#doctors-list');
                    const tbody = usersTable.children('tbody');

                    const newTr = $('<tr></tr>');
                    newTr.addClass('user');
                    newTr.addClass('doctor');
                    newTr.attr('data-id', doctor.id);

                    const name = $(`<td><a title="Voir la fiche détaillée de cet utilisateur" href="/admin/utilisateurs/${doctor.id}">${doctor.name}</a></td>`);

                    const courses = '<td align="center" class="supervised-courses user-info"> ' + doctor.courses.length + ' </td>';
                    const news = '<td align="center" class="published-news user-info"> ' + doctor.news.length + ' </td>';
                    const articles = '<td align="center" class="published-articles user-info"> ' + doctor.articles.length + ' </td>';

                    const downgrade = $('<i title="Supprimer cet utilisateur de la liste des docteurs" class="fa fa-times-circle downgrade-doctor" aria-hidden="true"></i>');
                    const edit = $('<i title="Voir la fiche de cet utilisateur" class="glyphicon glyphicon-pencil edit-user"></i>');

                    downgrade.click(function () {
                        downgradeDoctor(downgrade);
                    });

                    edit.click(function () {
                        editUser(edit);
                    });

                    const controls = $('<td></td>');
                    controls.attr('align', 'center');
                    controls.addClass('controls');
                    controls.append(downgrade);
                    controls.append(edit);

                    newTr.append(name);
                    newTr.append(courses);
                    newTr.append(news);
                    newTr.append(articles);
                    newTr.append(controls);

                    tbody.append(newTr);
                    tr.remove();
                })
                .catch((error) => {
                    user.is_doctor = 0;
                    user.update();
                    Flash.error("L'utilisateur n'a pas pu être promu.");
                });
        });
    });
}

export function usersManagement() {
    $('.downgrade-doctor').click(function () {
        downgradeDoctor($(this));
    });

    $('.upgrade-user').click(function () {
        upgradeUser($(this));
    });

    $('.edit-user').click(function () {
        editUser($(this));
    });
}