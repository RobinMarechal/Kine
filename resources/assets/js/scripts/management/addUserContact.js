/**
 * Created by Utilisateur on 08/09/2017.
 */

import Contact from "../models/Contact";
import Flash from "../libs/Flash";

function addContact(contact) {
    const tbody = $('#table-contacts tbody');
    const tr = $(`<tr data-id="${contact.id}" data-namespace="contacts">`);

    tr.append(`<td class="user-edition-field-container" data-field="name" data-toggle="input" data-max-length="255">${contact.name}</td>`);
    tr.append(`<td data-pattern="link|address|phone|email" class="user-edition-field-container" data-field="value" data-toggle="input" data-max-length="255">${contact.value}</td>`);
    tr.append(`<td class="user-edition-field-container" data-field="description" data-toggle="input" data-max-length="255">${contact.description}</td>`);

    const td = $('<td class="controls" align="center"></td>');
    const fa = $('<i title="Supprimer cette ligne" class="fa fa-times-circle delete-contact" aria-hidden="true"></i>');
    fa.click(function()
    {
        removeLine($(this).parents('tr'));
    });
    td.append(fa);
    tr.append(td);

    tbody.append(tr);
}

function createContact() {
    const inputName = $('#new-contact-name');
    const inputValue = $('#new-contact-value');
    const inputDescription = $('#new-contact-description');
    const table = $('#table-contacts');

    inputName.removeClass('has-error');
    inputValue.removeClass('has-error');
    inputDescription.removeClass('has-error');

    const name = inputName.val();
    const value = inputValue.val();
    const description = inputDescription.val();
    const userId = table.length == 0 ? null : $('#table-contacts').data('user-id');

    let ok = true;

    if (name.length == 0) {
        ok = false;
        inputName.addClass('has-error');
    }
    if (value.length == 0) {
        ok = false;
        inputValue.addClass('has-error');
    }

    if (!ok) {
        return false;
    }

    const data = {
        name: name,
        value: value,
        description: description,
        doctor_id: userId,
    };

    return Contact.create(data)
        .then(contact => {
            addContact(contact);
            inputName.val('');
            inputValue.val('');
            inputDescription.val('');
        }).catch(() => {
            Flash.error("Une erreur est survenue, la données n'a peut être pas été créée.");
        });
}

export function addUserContact() {
    $('#add-contact').click(function () {
        createContact();
    });

    $('#table-contacts input').keydown(function (ev) {
        if (ev.which == 13) {
            $('#add-contact').click();
        }
    });
}


function removeLine(line) {
    const id = line.data('id');
    return Contact.remove(id)
        .then(() => {
            Flash.success("Cet enregistrement a bien été supprimé de la base de données.");
            line.remove();
        })
        .catch(() => {
            Flash.error("Une erreur est survenue, l'enregistrement n'a pas pu être supprimé.");
        });
}

export function removeUserContact() {
    $('.delete-contact').click(function () {
        removeLine($(this).parents('tr'));
    });
}