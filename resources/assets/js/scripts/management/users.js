import User from "../models/User";
import Tag from "../models/Tag";
import Api from "../libs/Api";
import Flash from "../libs/Flash";

function updateUserTagListInTable(response)
{
    const userId = response.user_id;
    const table = $('#users-list');
    const tr = table.find('tr[data-id='+userId+']');
    const div = tr.find('.table-tag-list');

    console.log(table, tr, div);

    div.html('');

    const tags = response.tags;
    for(let i = 0; i < tags.length; i++)
    {
        div.append('<span class="tag">'+tags[i]+'</span>');
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
            })
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
            formGroupEmail.append(`<a style="text-indent: 20px" href="mailto:${user.email}">${user.email}</a>`)

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

function buildDoctorUserHtml(user) {

}

function buildHtml(user) {
    return user.level == 0 ? buildStandardUserHtml(user) : buildDoctorUserHtml(user);
}

function editUser(target) {
    const tr = $(target).parents('tr');
    const userId = tr.data('id');

    let params;
    let size;
    if (tr.hasClass('doctor')) {
        params = 'with=articles,news,supervisedCourses';
        size = 'large';
    }
    else {
        params = 'with=tags';
        size = 'small';
    }

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

function downgradeDoctor(target) {
    const tr = $(target).parents('tr');
    const userId = tr.data('id');

    User.get(userId).then((user) => {
        user.level = 0;
        user.update('with=courses,tags').then((user) => {

            const usersTable = $('#users-list');
            const tbody = usersTable.children('tbody');

            const newTr = $('<tr></tr>');
            newTr.addClass('user');
            newTr.attr('data-id', user.id);

            const name = $('<td>' + user.name + '</td>');

            const courses = '<td align="center" class="user-courses user-info"> ' + user.courses.length + ' </td>';

            const tags = $('<td></td>');
            tags.attr('align', 'center');
            tags.addClass('user-tags');
            tags.addClass('user-info');

            let i;
            for (i = 0; i < user.tags.length; i++) {
                const tag = user.tags[i];
                const html = $('<span></span>');
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
        });
    });
}

function upgradeUser(target) {
    const tr = $(target).parents('tr');

    const userId = tr.data('id');

    User.get(userId).then((user) => {
        user.level = 1;
        user.update('with=supervisedCourses,news,articles').then((user) => {

            const usersTable = $('#doctors-list');
            const tbody = usersTable.children('tbody');

            const newTr = $('<tr></tr>');
            newTr.addClass('user');
            newTr.addClass('doctor');
            newTr.attr('data-id', user.id);

            const name = $('<td>' + user.name + '</td>');

            const courses = '<td align="center" class="supervised-courses user-info"> ' + user.supervised_courses.length + ' </td>';
            const news = '<td align="center" class="published-news user-info"> ' + user.news.length + ' </td>';
            const articles = '<td align="center" class="published-articles user-info"> ' + user.articles.length + ' </td>';

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