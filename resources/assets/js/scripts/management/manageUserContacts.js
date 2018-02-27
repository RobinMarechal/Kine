import Contact from "../models/Contact";
import Flash from "../libs/flash/Flash";
import Key from '../libs/Key';
import RegexpPattern from '../helpers/RegexpPattern';
import Api from '../libs/Api';

function addContact(contact) {
    const tbody = $('#table-contacts').find('tbody');
    const tr = $(`<tr data-id="${contact.id}" data-namespace="contacts" class="hover-container">`);

    console.log(contact);

    tr.append(`<td>
                    <input data-field="name"
                           data-pattern="varchar"
                           data-previous-value="${contact.name || ''}"
                           class="form-control input-sm input-bottom-border edit-data-field"
                           maxlength="255"
                           value="${contact.name || ''}"
                </td>
                <td>
                    <input data-field="value"
                           data-pattern="phone|email|link|address"
                           data-previous-value="${contact.value}"
                           class="form-control input-sm input-bottom-border edit-data-field"
                           maxlength="255"
                           value="${contact.value}">
                </td>
                <td>
                    <input data-field="display"
                           data-pattern="varchar"
                           data-previous-value="${contact.display || ''}"
                           class="form-control input-sm input-bottom-border edit-data-field"
                           maxlength="255"
                           value="${contact.display || ''}"
                </td>`);

    const inputs = tr.find('.edit-data-field');
    inputs.keydown(handleKeyDown);

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

function handleKeyDown(ev) {
    const that = $(this);
    if (ev.which == Key.ENTER) {
        that.blur();
    }
    else if (ev.which == Key.ESCAPE) {
        const prevValue = that.data('previous-value');
        that.val(prevValue);
        that.blur();
    }
}

async function handleFocusout(ev) {
    const input = $(ev.currentTarget);
    const namespace = input.parents('[data-namespace]').data('namespace');
    const id = input.parents('[data-id]').data('id');
    const patternName = input.data('pattern');
    const field = input.data('field');
    const prevValue = input.data('previous-value');
    let newValue = input.val();

    if (newValue.length > 0 && !RegexpPattern.getRegexpFromPattern(patternName).test(newValue)) {
        Flash.error('Format invalide.');
        input.val(prevValue);
        return;
    }

    if (patternName == 'time') {
        const [h, m] = newValue.split(':');
        if (m.length === 1) {
            Flash.error('Format invalue.');
            input.val(prevValue);
            return;
        }

        newValue = `${h.length == 1 ? '0' + h : h}:${m}`;
    }

    if (newValue === prevValue) {
        return;
    }

    try {
        let response = await Api.sendData(`${namespace}/${id}`, 'PUT', {[field]: newValue});
        response = await response.json();
        input.val(response[field]);
        input.data('previous-value', response[field]);
    }
    catch (e) {
        Flash.error('Une erreur est survenue, le champs n\'a pas pu être modifié.');
        input.val(prevValue);
        return;
    }
}

function editUserContact() {
    $('.edit-data-field').keydown(handleKeyDown);
    $('.edit-data-field').focusout(handleFocusout);
}

export default function manageUserContacts() {
    addUserContact();
    removeUserContact();
    editUserContact();
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