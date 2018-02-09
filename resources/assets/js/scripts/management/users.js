import User from "../models/User";
import Tag from "../models/Tag";
import Api from "../libs/Api";
import Flash from "../libs/flash/Flash";
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

async function submit() {
    const userTags = $('#tag-list').find('.tag');
    const userId = $('#edit-user-tags').data('user-id');
    let ids = [];

    for (let i = 0; i < userTags.length; i++) {
        ids.push($(userTags[i]).data('id'));
    }

    const data = {
        tags: ids,
    };

    try {
        let response = await Api.sendData(`users/${userId}/tags`, 'PUT', data);
        response = await response.json();
        updateUserTagListInTable(response);
        return response;
    }
    catch (e) {
        Flash.error("Une erreur est survenue, les tags de l'utilsateur n'ont peut être pas été correctement modifiés...", 4000);
        console.log(["users#submit", e]);
        return null;
    }
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
    const cross = $('<i title="Retirer ce tag" class="times">x</i>');
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
                if(id in usersTagIds){
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

function buildDoctorUserHtml() {
    return new Promise((resolve) => {

        const div = $('<table id="doctor-info-dialog" class="table table-hover table-striped"></table>');

        const thead = $('<thead></thead>');
        thead.append('<td>');

        resolve(div);
    });
}

function buildHtml(user) {
    return user instanceof Doctor || user.is_doctor === 1 || user.user_id != null ? buildDoctorUserHtml() : buildStandardUserHtml(user);
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
                                },
                            },
                        },
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
                                },
                            },
                        },
                    });
                })
                .catch((error) => {
                    throw error;
                });
        });
    }
}

async function downgradeDoctor(target) {
    const tr = $(target).parents('tr');
    const userId = tr.data('id');

    try {
        await Doctor.remove(userId);
        let user = await User.get(userId);
        user.is_doctor = 0;
        user = await user.update("with=courses,tags");

        const usersTable = $('#users-list');
        const tbody = usersTable.children('tbody');

        const newTr = $(`<tr class="hover-container" class="user" data-id="${user.id}"></tr>`);
        const name = $(`<td> ${user.name} </td>`);
        const courses = $(`<td align="center" class="user-courses user-info"> ${user.courses.length} </td>`);
        const tags = $('<td class="user-tags user-info"></td>');

        let i;
        for (i = 0; i < user.tags.length; i++) {
            const tag = user.tags[i];
            const html = $(`<span class="tag">${tag.name}</span>`);
            tags.append(html);
        }

        if (i === 0) {
            tags.append('-');
        }

        const upgrade = $(`<span class="pointer upgrade-user btn-table-control show-on-hover-container show-on-hover ">
                                <i title="Ajouter cet utilisateur à la liste des docteurs"
                                   class="fas fa-sm fa-angle-double-up upgrade-user" aria-hidden="true"></i>
                            </span>`);
        const edit = $(`<span class="pointer edit-user btn-table-control show-on-hover-container show-on-hover ">
                            <i title="Voir la fiche de cet utilisateur" class="fas fa-sm fa-edit edit-user"></i>
                        </span>`);

        upgrade.click(function () {
            upgradeUser($(this));
        });

        edit.click(function () {
            editUser($(this));
        });


        const controls = $(`<td align="center" class="controls"></td>`);
        controls.append(upgrade);
        controls.append(edit);

        newTr.append(`${name.toHtmlString()}
                      ${courses.toHtmlString()}
                      ${tags.toHtmlString()}`);
        newTr.append(controls);

        tbody.append(newTr);
        tr.remove();
    }

    catch (e) {
        Flash.error("Une erreur est survenue, l'utilisateur n'a pas été rétrogradé.");
        console.log("users#downgradeDoctor", e);
    }
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
                name: user.name,
            };


            Doctor.create(doc, 'with=courses,news,articles')
                .then((doctor) => {

                    const usersTable = $('#doctors-list');
                    const tbody = usersTable.children('tbody');

                    const newTr = $('<tr></tr>');
                    newTr.addClass('user');
                    newTr.addClass('doctor');
                    newTr.addClass('hover-container');
                    newTr.attr('data-id', doctor.id);

                    const name = $(
                        `<td><a title="Voir la fiche détaillée de cet utilisateur" href="/admin/utilisateurs/${doctor.id}">${doctor.name}</a></td>`,
                    );

                    const courses = `<td align="center" class="supervised-courses user-info"> ${doctor.courses.length} </td>`;
                    const news = `<td align="center" class="published-news user-info"> ${doctor.news.length} </td>`;
                    const articles = `<td align="center" class="published-articles user-info"> ${doctor.articles.length} </td>`;

                    const downgrade = $(`<span class="downgrade-doctor pointer btn-table-control show-on-hover-container show-on-hover " title="Supprimer cet utilisateur de la liste des docteurs" data-toggle="tooltip">
                                                <i class="fas fa-angle-double-down fa-sm" aria-hidden="true"></i>
                                            </span>`);
                    const edit = $(`<span class="edit-user pointer btn-table-control show-on-hover-container show-on-hover " title="Supprimer cet utilisateur de la liste des docteurs" data-toggle="tooltip">
                                        <i class="fas fa-edit fa-sm"></i>
                                    </span>`);

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
                    console.log('users#upgradeUser', error);
                });
        });
    });
}

export function usersManagement() {
    bindEvents();
}

function bindEvents() {
    $('.downgrade-user').click(function () {
        downgradeDoctor($(this));
    });

    $('.upgrade-user').click(function () {
        upgradeUser($(this));
    });

    $('.edit-user').click(function () {
        editUser($(this));
    });
}