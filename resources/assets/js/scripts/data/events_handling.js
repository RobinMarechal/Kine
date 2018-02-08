import Flash from "../libs/flash/Flash";
import {
    dataRemovingButtonClicked,
    dataUpdatingButtonClicked,
    manageDataRemovingAndUpdate
} from "../management/manageDataCreation";
import User from "../models/User";
import FlashMessage from "../libs/flash/FlashMessage";
import Exception from "../libs/Exception";
import Helper from "../helpers/Helper";
import DAO from "../models/DAO";
import PhpVarCatcher from "../libs/PhpVarCatcher";

export const EVENT_CALLBACKS = {
    creation_abouts,
    update_abouts,
    deletion_abouts,
    before_events,
    before_news,
    deletion_news,
    creation_news,
    update_contents,
    before_bugs,
    creation_bugs,
};

export function creation_abouts(about) {

    const container = $('#abouts');

    // Block creation

    console.log(about);

    const newBlock = $('<section></section>');
    newBlock.attr('id', about.slug);
    newBlock.addClass('about-block');
    newBlock.addClass('editable');
    newBlock.addClass('content-editable');
    newBlock.attr('data-id', about.id);

    const newBlockTitle = $('<h3></h3>');
    newBlockTitle.addClass('about-title');
    newBlockTitle.html(about.title);

    const btnEdit = `<button data-id="${about.id}" title="" data-toggle="tooltip" data-placement="top" data-name="" class="update-data btn btn-edit btn-primary " data-namespace="abouts" data-original-title="Modifier la rubrique"><span class="glyphicon glyphicon-pencil"></span></button>`;
    const btnRemove = `<button data-toggle="tooltip" data-placement="top" title="" data-id="${about.id}" data-namespace="abouts" class="remove-data btn-remove btn btn-primary btn-edit trash create-new glyphicon glyphicon-trash" data-original-title="Supprimer la rubrique"></button>`;

    const newBlockContent = $('<div></div>');
    newBlockContent.addClass('about-content');
    newBlockContent.append(about.content);

    newBlockTitle.append(btnRemove);
    newBlockTitle.append(btnEdit);
    newBlock.append(newBlockTitle);
    newBlock.append(newBlockContent);

    // Adding the block to the list

    console.log(newBlock);

    container.append(newBlock);

    // Sorting the blocks

    const blocks = $('#abouts .about-block');

    blocks.sort(function (block1, block2) {
        const slug1 = $(block1).attr('id').trim().toLowerCase();
        const slug2 = $(block2).attr('id').trim().toLowerCase();

        return (slug1 > slug2) ? 1 : (slug1 < slug2) ? -1 : 0;
    });

    // Emptying the container
    container.html('');

    // Re-append the sorted block list
    for (let i = 0; i < blocks.length; i++) {
        const b = $(blocks[i]);

        container.append(b);

        const bId = b.attr('id');
        const editBtn = $('#' + bId + ' .update-data');
        const removeBtn = $('#' + bId + ' .remove-data');

        editBtn.click(function () {
            dataUpdatingButtonClicked($(this));
        });

        removeBtn.click(function () {
            dataRemovingButtonClicked($(this));
        });
    }
    // container.append(blocks);

    Flash.success("La rubrique a bien été créée.");
}

export function update_abouts(about) {
    3
    const aboutSelector = '[data-id=' + about.id + ']';

    const aboutTitle = $(aboutSelector + ' .about-title');
    const aboutContent = $(aboutSelector + ' .about-content');

    const editBtn = aboutTitle.children('.update-data');
    const removeBtn = aboutTitle.children('.remove-data');

    aboutTitle.html(about.title);
    aboutTitle.append(editBtn);
    aboutTitle.append(removeBtn);
    aboutContent.html(about.content);

    editBtn.click(function () {
        dataUpdatingButtonClicked($(this));
    });

    removeBtn.click(function () {
        dataRemovingButtonClicked($(this));
    });

    Flash.success("La rubrique a bien été modifiée.");
}

export function deletion_abouts(blockId) {
    const block = $('#' + blockId);
    if (!block) {
        throw null;
    }

    block.remove();

    Flash.success("La rubrique a été supprimée avec succès.");
}

export function before_events(data) {
    console.log('before', data);

    data.starts_at = data.start_date;
    data.ends_at = data.end_date;

    if (data.start_time)
        data.starts_at += ' ' + data.start_time + ':00';
    else
        data.starts_at += ' 00:00:00';

    if (data.ends_at && data.end_time)
        data.ends_at += ' ' + data.end_time + ':00';
    else
        data.ends_at += ' 00:00:00';

    delete data.start_date;
    delete data.end_date;
    delete data.start_time;
    delete data.end_time;

    console.log('after', data);

    return data;
}

function before_news(news) {
    const user = User.getAuthenticatedUser();

    if (!user || user.id < 1) {
        throw new Exception("Auth user's id not defined");
    }

    if (!user.is_doctor) {
        throw new Exception("Auth user is not an admin");
    }

    news.doctor_id = user.id;


    return news;
}

function creation_news(news) {
    if (!news || !news.id) {
        throw new Exception();
    }

    Helper.redirectTo(`/news/${news.id}`);
}

function update_contents(content) {
    const container = $(`[data-editable="true"][data-namespace="contents"][data-id="${content.id}"]`);
    const titleTag = container.children('.content-title');
    const contentTag = container.children('.content-content');

    titleTag.html(content.title);
    contentTag.html(content.content);

    Flash.success("La rubrique a bien été modifiée.");
}

function deletion_news() {
    Flash.success("La news a bien été supprimée", 300)
        .then(() => Helper.redirectTo('/news'));
}

function before_bugs(bug) {
    if (bug.id)
        bug.solved_at = Helper.currentDateTime();

    if(PhpVarCatcher.has('userId')){
        bug.user_id = PhpVarCatcher.get('userId');
    }

    return bug;
}

function creation_bugs(bug) {
    Flash.success("Merci d'avoir signalé un bug. Il sera traité dès que possible");
}