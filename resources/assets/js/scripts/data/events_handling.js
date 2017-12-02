import Flash from "../libs/Flash";
import {dataRemovingButtonClicked, dataUpdatingButtonClicked, manageDataRemovingAndUpdate} from "../management/manageDataCreation";

export const EVENT_CALLBACKS = {
    creation_abouts: creation_abouts,
    update_abouts: update_abouts,
    deletion_abouts: deletion_abouts,
};

export function creation_abouts(about) {

    const container = $('#abouts');

    // Block creation

    const newBlock = $('<section></section>');
    newBlock.attr('id', about.slug);
    newBlock.addClass('about-block');
    newBlock.addClass('editable');
    newBlock.addClass('content-editable');

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
    const tagId = '#' + about.slug;

    const aboutTitle = $(tagId + ' .about-title');
    const aboutContent = $(tagId + ' .about-content');

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

export function deletion_abouts(blockId)
{
    const block = $('#'+ blockId);
    if(!block)
        throw null;

    block.remove();

    Flash.success("La rubrique a été supprimée avec succès.");
}