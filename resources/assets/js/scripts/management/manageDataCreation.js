import FormGenerator from "../helpers/FormGenerator";
import Api from "../libs/Api";
import Flash from "../libs/flash/Flash";
import EventHandler, {EVENT_TYPES} from "../libs/EventHandler";
import RemovingConfirmDialog from "../helpers/RemovingConfirmDialog";
import FlashMessage from "../libs/flash/FlashMessage";
import Editor from '../helpers/Editor';

async function onSubmit(formGenerator) {
    const namespace = formGenerator.namespace;
    let sendDataTo;
    let method = 'POST';
    let obj;

    try {
        obj = formGenerator.buildObject();
    } catch (e) {
        if (e instanceof FlashMessage) {
            Flash.error(e);
            return false;
        }
    }

    obj = EventHandler.event(EVENT_TYPES.BEFORE, namespace, obj);

    sendDataTo = namespace;
    if (obj.id) {
        sendDataTo += '/' + obj.id;
        method = 'PUT';
    }

    try {
        let response = await Api.sendData(sendDataTo, method, obj);
        response = await response.json();

        if (response.length === 0) {
            throw null;
        }

        if (obj.id && obj.id === response.id) {
            EventHandler.event(EVENT_TYPES.UPDATED, namespace, response);
        } else {
            EventHandler.event(EVENT_TYPES.CREATED, namespace, response);
        }
    }
    catch (e) {
        if (obj && obj.id) {
            Flash.error("Une erreur est survenue, la donnée n'a pas été modifiée.");
        } else {
            Flash.error("Une erreur est survenue, la donnée n'a pas été créée.");
        }
        console.log(e);
    }
}

export function dataCreationButtonClicked(button) {
    const namespace = button.data('namespace');

    const generator = FormGenerator.create(namespace);
    generator.onValidate = onSubmit;
    generator.displayInDialog();
}


export async function dataUpdatingButtonClicked(button) {
    const namespace = button.data('namespace');
    const dataId = button.data('id');

    try {
        const generator = FormGenerator.create(namespace);
        generator.onValidate = onSubmit;
        generator.displayInDialog()
            .on('shown.bs.modal', async function () {
                const dialog = $(this);

                const response = await Api.get(namespace + '/' + dataId);
                generator.data = await response.json();

                dialog.find('.modal-body').html(generator.generateFormBody());

                generator.processEditor();
            });
    }
    catch (e) {
        Flash.error("Une erreur est survenue lors de la récupération des données.");
        console.log(["manageDataCreation#dataUpdatingButtonClickec", e]);
    }
}

export function dataRemovingButtonClicked(button) {
    const dataId = button.data('id');
    const blockId = button.parents('section').attr('id');
    const namespace = button.data('namespace');

    const dialog = new RemovingConfirmDialog();

    dialog.title = "Supprimer la donnée";
    dialog.message = "Voulez-vous vraime supprimer cette donnée ?";
    dialog.callback = function () {
        Api.sendData(namespace + '/' + dataId, 'DELETE')
            .then((response) => {
                if (!response) {
                    throw null;
                }

                EventHandler.event(EVENT_TYPES.DELETED, namespace, blockId);
            })
            .catch(() => {
                Flash.error("Une erreur est survenue, la donnée n'a pas été supprimée.");
            });
    };

    dialog.show();
}

export default function manageDataCreation() {
    $('.create-data, [data-creator]').click(function (ev) {
        ev.preventDefault();
        dataCreationButtonClicked($(this));
    });

    manageDataRemovingAndUpdate();
}

export function manageDataRemovingAndUpdate() {
    $('.update-data, [data-updater]').click(function (ev) {
        ev.preventDefault();
        dataUpdatingButtonClicked($(this));
    });

    $('.remove-data, [data-remover]').click(function (ev) {
        ev.preventDefault();
        dataRemovingButtonClicked($(this));
    });
}