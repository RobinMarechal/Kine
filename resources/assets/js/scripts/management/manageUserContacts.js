import Contact from "../models/Contact";
import Flash from "../libs/flash/Flash";
import {toggleInputClicked} from "./toggleInputControls";
import Key from '../libs/Key';
import RegexpPattern from '../helpers/RegexpPattern';

function addContact(contact) {
    const tbody = $('#table-contacts').find('tbody');
    const tr = $(`<tr data-id="${contact.id}" data-namespace="contacts" class="hover-container">`);

    let tdName = $(`<td class="user-edition-field-container" data-field="name" data-toggle="input" data-max-length="255">${contact.name || ''}</td>`);
    let tdValue = $(`<td data-pattern="phone|email|link|address" class="user-edition-field-container" data-field="value" data-toggle="input" data-max-length="255">${contact.value}</td>`);
    let tdDisplay = $(`<td class="user-edition-field-container" data-field="display" data-toggle="input" data-max-length="255">${contact.display || ''}</td>`);

    tr.append(tdName);
    tr.append(tdValue);
    tr.append(tdDisplay);

    tdName.click(function () {
        toggleInputClicked($(this));
    });
    tdValue.click(function () {
        toggleInputClicked($(this));
    });
    tdDisplay.click(function () {
        toggleInputClicked($(this));
    });

    const td = $(`<td class="controls" align="center"></td>`);
    const fa = $(`<span class="delete-contact pointer show-on-hover show-on-hover-container" title="Supprimer cette ligne" data-toggle="tooltip">
                     <i class="fas fa-times-circle fa-sm" aria-hidden="true"></i>
                  </span>`);
    fa.click(function () {
        removeLine($(this).parents('tr'));
    });
    td.append(fa);
    tr.append(td);

    tbody.append(tr);
}

async function createContact() {
    const inputName = $('#new-contact-name');
    const inputValue = $('#new-contact-value');
    const inputDescription = $('#new-contact-description');
    const table = $('#table-contacts');

    inputName.removeClass('has-error');
    inputValue.removeClass('has-error');
    inputDescription.removeClass('has-error');

    const name = inputName.val();
    const value = inputValue.val();
    const display = inputDescription.val();
    const doctor_id = table.length === 0 ? null : table.data('user-id');

    let ok = true;

    if (name.length === 0) {
        ok = false;
        inputName.addClass('has-error');
    }
    if (value.length === 0) {
        ok = false;
        inputValue.addClass('has-error');
    }

    if (!ok) {
        return false;
    }

    const type = RegexpPattern.getTypeOfString(value, 'phone', 'email', 'link') || 'link';

    const data = {
        name,
        value,
        display,
        doctor_id,
        type: type.toUpperCase(),
    };

    try {
        const contact = await Contact.create(data);
        addContact(contact);
        inputName.val('');
        inputValue.val('');
        inputDescription.val('');
    }
    catch (e) {
        Flash.error("Une erreur est survenue, la données n'a peut être pas été créée.");
    }
}

export default function manageUserContacts() {
    addUserContact();
    removeUserContact();
}

function addUserContact() {
    $('#add-contact').click(function () {
        createContact();
    });

    $('#table-contacts').find('input').keydown(function (ev) {
        if (ev.which === Key.ENTER) {
            $('#add-contact').click();
        }
    });
}


async function removeLine(line) {
    const id = line.data('id');
    const remove = await Contact.remove(id);
    if (!remove)
        throw false;

    Flash.success("Cet enregistrement a bien été supprimé de la base de données.");
    line.remove();
}

function removeUserContact() {
    $('.delete-contact').click(function () {
        console.log('oui');
        removeLine($(this).parents('tr'));
    });
}